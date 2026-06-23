<?php

namespace Webkul\BusinessMasters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Webkul\BusinessMasters\Database\Factories\CompanyMasterFactory;
use Webkul\Security\Models\User;

class CompanyMaster extends Model
{
    use HasFactory;

    protected $table = 'bm_company_masters';

    protected $fillable = [
        0  => 'company_code',
        1  => 'company_name',
        2  => 'gstin',
        3  => 'pan_no',
        4  => 'address',
        5  => 'city',
        6  => 'state',
        7  => 'country',
        8  => 'pincode',
        9  => 'phone',
        10 => 'mobile',
        11 => 'email',
        12 => 'logo_path',
        13 => 'is_active',
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

    public function branches(): HasMany
    {
        return $this->hasMany(BranchMaster::class, 'company_id');
    }

    public function subCompanies(): HasMany
    {
        return $this->hasMany(SubCompanyMaster::class, 'company_id');
    }

    protected static function newFactory(): Factory
    {
        return CompanyMasterFactory::new();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $CompanyMaster) {
            $CompanyMaster->created_by ??= Auth::id();
        });

        static::updating(function (self $CompanyMaster) {
            $CompanyMaster->updated_by = Auth::id();
        });
    }
}
