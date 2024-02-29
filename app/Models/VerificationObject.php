<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationObject extends Model
{
    use HasFactory;

    public function profile_verify()
    {
        return $this->hasMany(ProfileVerify::class, 'id', 'verification_object_id');
    }
}
