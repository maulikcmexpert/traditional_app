<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileBlock extends Model
{
    use HasFactory;


    public function blocker_user()
    {
        return $this->belongsTo(User::class, 'blocker_id');
    }
}
