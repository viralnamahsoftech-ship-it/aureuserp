<?php

namespace Webkul\BusinessParty\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BusinessMasters\Models\City;
use Webkul\BusinessMasters\Models\Country;
use Webkul\BusinessMasters\Models\State;
use Webkul\BusinessParty\Database\Factories\PartyAddressFactory;
use Webkul\Security\Models\User;

class PartyAddress extends Model
{
    use HasFactory;

    protected $table = 'bp_party_addresses';

    protected $fillable = [
        0  => 'party_id',
        1  => 'site_name',
        2  => 'address_type',
        3  => 'address',
        4  => 'city_id',
        5  => 'state_id',
        6  => 'state_code',
        7  => 'country_id',
        8  => 'pincode',
        9  => 'phone',
        10 => 'mobile',
        11 => 'email',
        12 => 'gstin',
        13 => 'is_whatsapp',
        14 => 'auto_mail',
    ];

    protected $casts = [
        'is_active'              => 'boolean',
        'is_tds_applicable'      => 'boolean',
        'allow_multiple_invoice' => 'boolean',
        'is_parent_party'        => 'boolean',
        'send_via_email'         => 'boolean',
        'send_via_whatsapp'      => 'boolean',
        'approved_at'            => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(PartyMaster::class, 'party_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    protected static function newFactory(): Factory
    {
        return PartyAddressFactory::new();
    }
}
