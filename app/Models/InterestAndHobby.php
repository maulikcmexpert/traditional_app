<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestAndHobby extends Model
{
    use HasFactory;

    public function user_interest_and_hobby()
    {
        return $this->hasMany(UserInterestAndHobby::class, 'interest_and_hobby_id', 'id');
    }
}
