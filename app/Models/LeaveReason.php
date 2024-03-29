<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    ApproachRequest
};

class LeaveReason extends Model
{
    use HasFactory;

    public function approach_requests()
    {
        return $this->hasMany(ApproachRequest::class, 'reason_id', 'id');
    }
}
