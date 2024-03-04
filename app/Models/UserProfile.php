<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    User
};

class UserProfile extends Model
{
    use HasFactory;

    protected  $fillable = [
        'user_id',
        'profile',
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}