<?php

namespace Webkul\BusinessParty\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Webkul\BusinessMasters\Models\BranchMaster;
use Webkul\BusinessMasters\Models\City;
use Webkul\BusinessMasters\Models\CompanyMaster;
use Webkul\BusinessMasters\Models\Country;
use Webkul\BusinessMasters\Models\Currency;
use Webkul\BusinessMasters\Models\State;
use Webkul\BusinessParty\Database\Factories\PartyMasterFactory;
use Webkul\BusinessParty\Models\Traits\HasBranchScope;
use Webkul\BusinessParty\Support\SerialNumberGenerator;
use Webkul\Security\Models\User;

class PartyMaster extends Model
{
    use HasBranchScope, HasFactory;

    protected $table = 'bp_party_masters';

    protected $fillable = [
        0  => 'company_id',
        1  => 'branch_id',
        2  => 'party_code',
        3  => 'party_name',
        4  => 'party_type_id',
        5  => 'party_group_id',
        6  => 'industry_type_id',
        7  => 'currency_id',
        8  => 'ho_address',
        9  => 'city_id',
        10 => 'state_id',
        11 => 'country_id',
        12 => 'pincode',
        13 => 'phone',
        14 => 'mobile',
        15 => 'email',
        16 => 'gst_supply_type',
        17 => 'tax_on',
        18 => 'gstin',
        19 => 'pan_no',
        20 => 'ecc_no',
        21 => 'uan_no',
        22 => 'tin_no',
        23 => 'msme_no',
        24 => 'msme_type',
        25 => 'udaid_no',
        26 => 'other_ref_no',
        27 => 'op_bal',
        28 => 'op_bal_type',
        29 => 'account_group_id',
        30 => 'is_tds_applicable',
        31 => 'tds_payment_id',
        32 => 'gl_tds_code',
        33 => 'credit_limit',
        34 => 'allow_multiple_invoice',
        35 => 'is_parent_party',
        36 => 'parent_party_id',
        37 => 'is_active',
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

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyMaster::class, 'company_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(BranchMaster::class, 'branch_id');
    }

    public function partyType(): BelongsTo
    {
        return $this->belongsTo(PartyType::class, 'party_type_id');
    }

    public function partyGroup(): BelongsTo
    {
        return $this->belongsTo(PartyGroup::class, 'party_group_id');
    }

    public function industryType(): BelongsTo
    {
        return $this->belongsTo(IndustryType::class, 'industry_type_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
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

    public function parentParty(): BelongsTo
    {
        return $this->belongsTo(PartyMaster::class, 'parent_party_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(PartyAddress::class, 'party_id');
    }

    public function contactPersons(): HasMany
    {
        return $this->hasMany(PartyContactPerson::class, 'party_id');
    }

    public function bankDetails(): HasMany
    {
        return $this->hasMany(PartyBankDetail::class, 'party_id');
    }

    protected static function newFactory(): Factory
    {
        return PartyMasterFactory::new();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $PartyMaster) {
            $PartyMaster->created_by ??= Auth::id();
        });

        static::updating(function (self $PartyMaster) {
            $PartyMaster->updated_by = Auth::id();
        });
        static::creating(function (self $PartyMaster) {
            if (blank($PartyMaster->party_code)) {
                $PartyMaster->party_code = SerialNumberGenerator::generate('PARTY', $PartyMaster->company_id, $PartyMaster->branch_id);
            }
        });
    }
}
