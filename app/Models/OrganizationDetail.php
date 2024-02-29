<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    User
};

class OrganizationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile',
        'organization_id',
        'established_year',
        'size_of_organization_id',
        'city',
        'state',
        'address',
        'about_us'
    ];
    public function organization()
    {
        return $this->belongsTo(User::class);
    }
}
