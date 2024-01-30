<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducationDetail extends Model
{
    protected $fillable = [
        'school_name',
        'year',
        'qualification',
        'user_id',
        'degree',
        // Add other attributes as needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userConnection()
    {
        return $this->hasMany(User_connection::class);
    }
}