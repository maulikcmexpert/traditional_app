<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    User,
    UserShwstpperAnswr
};

class UserShwstpprQue extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function user_shwstpper_answr()
    {
        return $this->hasMany(UserShwstpperAnswr::class, 'id', 'quesion_id');
    }
}
