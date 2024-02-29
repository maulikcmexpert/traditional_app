<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSeenUser extends Model
{
    use HasFactory;

    public function profile()
    {
        return $this->belongsTo(User::class, 'profile_id');
    }
    public function profile_viewer()
    {
        return $this->belongsTo(User::class, 'profile_viewer_id');
    }
}
