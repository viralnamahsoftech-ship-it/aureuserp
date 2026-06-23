<?php

namespace Webkul\BusinessParty\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BusinessParty\Database\Factories\HsnMasterFactory;
use Webkul\Security\Models\User;

class HsnMaster extends Model
{
    use HasFactory;

    protected $table = 'bp_hsn_masters';

    protected $fillable = [
        0  => 'hsn_no',
        1  => 'hsn_desc',
        2  => 'sgst',
        3  => 'cgst',
        4  => 'igst',
        5  => 'psgt_gl',
        6  => 'pcgt_gl',
        7  => 'pigt_gl',
        8  => 'ssgt_gl',
        9  => 'scgt_gl',
        10 => 'sigt_gl',
        11 => 'is_active',
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

    protected static function newFactory(): Factory
    {
        return HsnMasterFactory::new();
    }
}
