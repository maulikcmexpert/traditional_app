<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserDetail;

class Faith extends Model
{
    use HasFactory;

    public function userdetail()
    {
        return $this->hasOne(UserDetail::class, 'id', 'faith_id');
    }
}
