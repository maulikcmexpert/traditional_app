<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Lifestyle};

class UserLifestyle extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lifestyle()
    {
        return $this->belongsTo(Lifestyle::class, 'lifestyle_id', 'id');
    }
}
