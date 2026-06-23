<?php

namespace Webkul\BusinessParty\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BusinessParty\Database\Factories\BomLineFactory;
use Webkul\Security\Models\User;

class BomLine extends Model
{
    use HasFactory;

    protected $table = 'bp_bom_lines';

    protected $fillable = [
        0 => 'bom_id',
        1 => 'component_id',
        2 => 'process_id',
        3 => 'qty',
        4 => 'uom_id',
        5 => 'sort_order',
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

    public function bom(): BelongsTo
    {
        return $this->belongsTo(BomMaster::class, 'bom_id');
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(ItemMaster::class, 'component_id');
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo(ProcessMaster::class, 'process_id');
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }

    protected static function newFactory(): Factory
    {
        return BomLineFactory::new();
    }
}
