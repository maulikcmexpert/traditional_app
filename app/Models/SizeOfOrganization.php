<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeOfOrganization extends Model
{
    use HasFactory;

    public function organization_detail()
    {
        return $this->haMany(OrganizationDetail::class);
    }
}
