<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;
use app\Models\Lifestyle;


class UserLifestyle extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lifestyles()
    {
        return $this->belongsTo(Lifestyle::class, 'lifestyle_id', 'id');
    }
}
