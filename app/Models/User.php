<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Relationships ──

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function sentLikes()
    {
        return $this->hasMany(Like::class, 'sender_id');
    }

    public function receivedLikes()
    {
        return $this->hasMany(Like::class, 'receiver_id');
    }

    public function matchesAsUser1()
    {
        return $this->hasMany(UserMatch::class, 'user1_id');
    }

    public function matchesAsUser2()
    {
        return $this->hasMany(UserMatch::class, 'user2_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function adminLogs()
    {
        return $this->hasMany(AdminLog::class, 'admin_id');
    }

    // ── Helpers ──

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }

    public function hasCompletedProfile(): bool
    {
        return $this->profile && $this->profile->is_complete;
    }

    public function getAllMatches()
    {
        return UserMatch::where('status', 'active')
            ->where(function ($q) {
                $q->where('user1_id', $this->id)
                  ->orWhere('user2_id', $this->id);
            })->get();
    }

    public function isMatchedWith(int $userId): bool
    {
        return UserMatch::where('status', 'active')
            ->where(function ($q) use ($userId) {
                $q->where(function ($q2) use ($userId) {
                    $q2->where('user1_id', $this->id)->where('user2_id', $userId);
                })->orWhere(function ($q2) use ($userId) {
                    $q2->where('user1_id', $userId)->where('user2_id', $this->id);
                });
            })->exists();
    }

    public function hasLiked(int $userId): bool
    {
        return $this->sentLikes()->where('receiver_id', $userId)->exists();
    }

    public function hasBlocked(int $userId): bool
    {
        return $this->blocks()->where('blocked_user_id', $userId)->exists();
    }

    public function unreadMessagesCount(): int
    {
        return $this->receivedMessages()->whereNull('read_at')->count();
    }

    public function compatibilityWith(User $other): int
    {
        if (!$this->profile || !$other->profile) {
            return 0;
        }

        $score = 0;
        $factors = 0;

        // Shared hobbies (weight: 40%)
        $myHobbies = array_map('strtolower', $this->profile->hobbies_array);
        $theirHobbies = array_map('strtolower', $other->profile->hobbies_array);
        if (!empty($myHobbies) && !empty($theirHobbies)) {
            $shared = count(array_intersect($myHobbies, $theirHobbies));
            $total = count(array_unique(array_merge($myHobbies, $theirHobbies)));
            $score += ($total > 0 ? ($shared / $total) * 40 : 0);
            $factors++;
        }

        // Shared interests (weight: 40%)
        $myInterests = array_map('strtolower', $this->profile->interests_array);
        $theirInterests = array_map('strtolower', $other->profile->interests_array);
        if (!empty($myInterests) && !empty($theirInterests)) {
            $shared = count(array_intersect($myInterests, $theirInterests));
            $total = count(array_unique(array_merge($myInterests, $theirInterests)));
            $score += ($total > 0 ? ($shared / $total) * 40 : 0);
            $factors++;
        }

        // Same prefecture (weight: 10%)
        if ($this->profile->prefecture && $other->profile->prefecture) {
            if ($this->profile->prefecture === $other->profile->prefecture) {
                $score += 10;
            }
            $factors++;
        }

        // Age proximity (weight: 10%) - closer age = higher score
        if ($this->profile->age && $other->profile->age) {
            $ageDiff = abs($this->profile->age - $other->profile->age);
            $score += max(0, 10 - $ageDiff);
            $factors++;
        }

        return $factors > 0 ? min(100, (int) round($score)) : 0;
    }
}
