<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User};

class UserDetail extends Model
{
    use HasFactory;
    protected $table = 'user_details';

    // protected $fillable = [
    //     'user_id',
    //     'gender',
    //     'birth_date',
    //     'document_type',
    //     'document',
    //     'document_number',
    //     'latitude',
    //     'longitude',
    //     'about',
    //     'portfolio',
    //     'work_experience',
    //     'achievement',
    //     'skill',
    //     'hobby',
    //     'facebook_link',
    //     'instagram_link',
    //     'linkedin_link',
    //     'other_link',
    //     'image',
    // ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}