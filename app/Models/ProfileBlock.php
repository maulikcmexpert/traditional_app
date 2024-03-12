<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileBlock extends Model
{
    use HasFactory;


    public function blocker_user()
    {
        return $this->belongsTo(User::class, 'blocker_user_id');
    }

    public function blocked_user()
    {
        return $this->belongsTo(User::class, 'to_be_blocked_user_id');
    }
}
