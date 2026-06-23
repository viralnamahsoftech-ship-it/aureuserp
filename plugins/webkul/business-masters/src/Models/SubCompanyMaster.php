<?php

namespace Webkul\BusinessMasters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Webkul\BusinessMasters\Database\Factories\SubCompanyMasterFactory;
use Webkul\Security\Models\User;

class SubCompanyMaster extends Model
{
    use HasFactory;

    protected $table = 'bm_sub_company_masters';

    protected $fillable = [
        0 => 'company_id',
        1 => 'sub_company_code',
        2 => 'sub_company_name',
        3 => 'address',
        4 => 'is_active',
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

    protected static function newFactory(): Factory
    {
        return SubCompanyMasterFactory::new();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $SubCompanyMaster) {
            $SubCompanyMaster->created_by ??= Auth::id();
        });

        static::updating(function (self $SubCompanyMaster) {
            $SubCompanyMaster->updated_by = Auth::id();
        });
    }
}
