<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;

    public function userdetail()
    {
        return $this->hasOne(DailyActivity::class, 'id', 'daily_activity_id');
    }
}
