<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    UserShowstoppersAnswer
};

class ShowstoppersQuestion extends Model
{
    use HasFactory;
    public function user_showstoppers_answers()
    {
        return $this->hasMany(UserShowstoppersAnswer::class, 'question_id', 'id');
    }
}
