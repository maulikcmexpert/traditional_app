<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyType extends Model
{
    use HasFactory;

    public function userdetail()
    {
        return $this->hasOne(UserDetail::class, 'id', 'body_type_id');
    }
}
