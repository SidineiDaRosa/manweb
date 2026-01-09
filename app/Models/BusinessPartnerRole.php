<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessPartnerRole extends Model
{
    protected $fillable = [
        'business_partner_id',
        'role'
    ];

    public function businessPartner()
    {
        return $this->belongsTo(BusinessPartner::class);
    }
}
