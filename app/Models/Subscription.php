<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    UserSubscription
};

class Subscription extends Model
{
    use HasFactory;


    public function UserSubscription()
    {
        return $this->hasMany(UserSubscription::class, 'subscription_id', 'id');
    }
}
