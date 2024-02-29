<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    UserDetail
};

class ZodiacSign extends Model
{
    use HasFactory;

    public function user_detail()
    {
        return $this->hasOne(UserDetail::class);
    }
}
