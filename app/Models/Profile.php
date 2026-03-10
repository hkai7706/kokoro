<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'location',
        'prefecture',
        'hobbies',
        'interests',
        'bio',
        'profile_photo',
        'is_complete',
        'last_active_at',
    ];

    protected function casts(): array
    {
        return [
            'is_complete' => 'boolean',
            'last_active_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return asset('images/default-avatar.svg');
    }

    public function getHobbiesArrayAttribute(): array
    {
        return $this->hobbies ? array_map('trim', explode(',', $this->hobbies)) : [];
    }

    public function getInterestsArrayAttribute(): array
    {
        return $this->interests ? array_map('trim', explode(',', $this->interests)) : [];
    }
}
