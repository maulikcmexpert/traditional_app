<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Report extends Model
{
    use HasFactory;

    public function reporter_user()
    {
        return $this->belongsTo(User::class);
    }


    public function to_reporter_user()
    {
        return $this->belongsTo(User::class);
    }
}
