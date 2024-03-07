<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use HasFactory;

    public function user_detail()
    {
        return $this->hasMany(UserDetail::class, 'id', 'religion_id');
    }
}
