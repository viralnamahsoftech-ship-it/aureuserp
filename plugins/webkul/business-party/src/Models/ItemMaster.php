<?php

namespace Webkul\BusinessParty\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Webkul\BusinessMasters\Models\BranchMaster;
use Webkul\BusinessMasters\Models\CompanyMaster;
use Webkul\BusinessParty\Database\Factories\ItemMasterFactory;
use Webkul\BusinessParty\Models\Traits\HasBranchScope;
use Webkul\BusinessParty\Support\SerialNumberGenerator;
use Webkul\Security\Models\User;

class ItemMaster extends Model
{
    use HasBranchScope, HasFactory;

    protected $table = 'bp_item_masters';

    protected $fillable = [
        0  => 'company_id',
        1  => 'branch_id',
        2  => 'category_id',
        3  => 'item_group_id',
        4  => 'item_code',
        5  => 'item_name',
        6  => 'item_type',
        7  => 'process_type',
        8  => 'uom_id',
        9  => 'purch_uom_id',
        10 => 'sales_uom_id',
        11 => 'conv_qty',
        12 => 'purch_conv_qty',
        13 => 'sales_conv_qty',
        14 => 'detail_desc',
        15 => 'drawing_no',
        16 => 'drawing_rev_no',
        17 => 'part_no',
        18 => 'main_group_id',
        19 => 'sub_group_id',
        20 => 'other_group_id',
        21 => 'qc_required',
        22 => 'qc_param_required',
        23 => 'location',
        24 => 'internal_remarks',
        25 => 'make',
        26 => 'serial_no_code',
        27 => 'min_stock',
        28 => 'moq',
        29 => 'lead_time',
        30 => 'class_name',
        31 => 'manual_trans',
        32 => 'tolerance_plus',
        33 => 'tolerance_minus',
        34 => 'max_qty',
        35 => 'max_order_qty',
        36 => 'reorder_qty',
        37 => 'grn_required',
        38 => 'material_provide',
        39 => 'size_packet_qty',
        40 => 'self_life',
        41 => 'warranty_period',
        42 => 'hsn_id',
        43 => 'acct_gl_code',
        44 => 'is_active',
        45 => 'batch_wise',
        46 => 'serial_no_wise',
        47 => 'account_effect',
        48 => 'is_stock_effect',
        49 => 'planning',
        50 => 'gst_on',
        51 => 'gst_supply_type',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }

    public function itemGroup(): BelongsTo
    {
        return $this->belongsTo(ItemGroup::class, 'item_group_id');
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }

    public function purchaseUom(): BelongsTo
    {
        return $this->belongsTo(Uom::class, 'purch_uom_id');
    }

    public function salesUom(): BelongsTo
    {
        return $this->belongsTo(Uom::class, 'sales_uom_id');
    }

    public function mainGroup(): BelongsTo
    {
        return $this->belongsTo(ItemMainSubGroup::class, 'main_group_id');
    }

    public function subGroup(): BelongsTo
    {
        return $this->belongsTo(ItemMainSubGroup::class, 'sub_group_id');
    }

    public function otherGroup(): BelongsTo
    {
        return $this->belongsTo(ItemMainSubGroup::class, 'other_group_id');
    }

    public function hsn(): BelongsTo
    {
        return $this->belongsTo(HsnMaster::class, 'hsn_id');
    }

    protected static function newFactory(): Factory
    {
        return ItemMasterFactory::new();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $ItemMaster) {
            $ItemMaster->created_by ??= Auth::id();
        });

        static::updating(function (self $ItemMaster) {
            $ItemMaster->updated_by = Auth::id();
        });
        static::creating(function (self $ItemMaster) {
            if (blank($ItemMaster->item_code)) {
                $ItemMaster->item_code = SerialNumberGenerator::generate('ITEM', $ItemMaster->company_id, $ItemMaster->branch_id);
            }
        });
    }
}
