<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    User
};

class ApproachRequest extends Model
{
    use HasFactory;

    public function sender_user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver_user()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
