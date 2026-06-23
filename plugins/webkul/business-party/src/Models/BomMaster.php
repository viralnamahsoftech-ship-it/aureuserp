<?php

namespace Webkul\BusinessParty\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\BusinessMasters\Models\BranchMaster;
use Webkul\BusinessMasters\Models\CompanyMaster;
use Webkul\BusinessParty\Database\Factories\BomMasterFactory;
use Webkul\BusinessParty\Models\Traits\HasBranchScope;
use Webkul\Security\Models\User;

class BomMaster extends Model
{
    use HasBranchScope, HasFactory;

    protected $table = 'bp_bom_masters';

    protected $fillable = [
        0 => 'company_id',
        1 => 'branch_id',
        2 => 'item_id',
        3 => 'bom_code',
        4 => 'bom_name',
        5 => 'revision',
        6 => 'is_active',
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

    public function item(): BelongsTo
    {
        return $this->belongsTo(ItemMaster::class, 'item_id');
    }

    public function bomLines(): HasMany
    {
        return $this->hasMany(BomLine::class, 'bom_id');
    }

    protected static function newFactory(): Factory
    {
        return BomMasterFactory::new();
    }
}
