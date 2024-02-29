<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\{
    UserDetail
};

class City extends Model
{
    use HasFactory;

    public function user_detail()
    {
        return $this->hasMany(UserDetail::class);
    }

    public function organization_detail()
    {
        return $this->hasMany(OrganizationDetail::class);
    }
}
