<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EatingHabit extends Model
{
    use HasFactory;
    public function userdetail()
    {
        return $this->hasOne(UserDetail::class, 'id', 'eating_habit_id');
    }
}
