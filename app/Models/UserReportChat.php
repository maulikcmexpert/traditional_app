<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReportChat extends Model
{
    use HasFactory;

    public function sender()
    {
        $this->belongsTo(User::class, 'sender_id', 'id');
    }
}
