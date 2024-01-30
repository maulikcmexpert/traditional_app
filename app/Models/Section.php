<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'subcategory_id',
        'user_id',
        'cover_image',
        'class_title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'venue_type',
        'street_address',
        'country',
        'state',
        'city',
        'pincode',
        'slots',
        'pricing',
        'section_id',
        'latitude',
        'longitude',
        'day',
    ];
}