<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    UserLifestyle
};

class Lifestyle extends Model
{
    use HasFactory;
    public function userlifestyles()
    {

        return $this->hasMany(UserLifestyle::class, 'lifestyle_id', 'id');
    }
}
