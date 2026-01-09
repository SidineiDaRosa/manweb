<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessPartnerAddress extends Model
{
    protected $fillable = [
        'business_partner_id',
        'address_id',
        'address_type'
    ];
}
