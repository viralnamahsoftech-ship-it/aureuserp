<?php

namespace Webkul\BusinessMasters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Webkul\BusinessMasters\Database\Factories\BranchMasterFactory;
use Webkul\Security\Models\User;

class BranchMaster extends Model
{
    use HasFactory;

    protected $table = 'bm_branch_masters';

    protected $fillable = [
        0  => 'company_id',
        1  => 'branch_code',
        2  => 'branch_name',
        3  => 'address',
        4  => 'city',
        5  => 'state',
        6  => 'country',
        7  => 'pincode',
        8  => 'header_file',
        9  => 'footer_file',
        10 => 'is_active',
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
        return BranchMasterFactory::new();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $BranchMaster) {
            $BranchMaster->created_by ??= Auth::id();
        });

        static::updating(function (self $BranchMaster) {
            $BranchMaster->updated_by = Auth::id();
        });
    }
}
