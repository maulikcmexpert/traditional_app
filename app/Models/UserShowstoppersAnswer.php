<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    ShowstoppersQuestion,
    User
};

class UserShowstoppersAnswer extends Model
{
    use HasFactory;
    public function showstoppers_questions()
    {
        return $this->belongsTo(ShowstoppersQuestion::class, 'question_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
