<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'document',
        'name_first',
        'name_last',
        'company_name',
        'trade_name',
        'search_key',
        'status'
    ];

    public function roles()
    {
        return $this->hasMany(BusinessPartnerRole::class);
    }

    public function addresses()
    {
        return $this->hasMany(BusinessPartnerAddress::class);
    }
}
