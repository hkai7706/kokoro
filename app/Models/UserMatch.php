<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'user1_id',
        'user2_id',
        'status',
    ];

    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function getPartner(int $userId): ?User
    {
        return $this->user1_id === $userId ? $this->user2 : $this->user1;
    }
}
