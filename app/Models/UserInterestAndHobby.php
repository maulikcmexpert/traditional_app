<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    User,
    InterestAndHobby
};

class UserInterestAndHobby extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function interest_and_hobbies()
    {
        return $this->belongsTo(InterestAndHobby::class, 'interest_and_hobby_id');
    }
}
