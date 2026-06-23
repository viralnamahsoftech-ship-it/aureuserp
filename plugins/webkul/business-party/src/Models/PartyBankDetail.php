<?php

namespace Webkul\BusinessParty\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BusinessParty\Database\Factories\PartyBankDetailFactory;
use Webkul\Security\Models\User;

class PartyBankDetail extends Model
{
    use HasFactory;

    protected $table = 'bp_party_bank_details';

    protected $fillable = [
        0  => 'party_id',
        1  => 'bank_name',
        2  => 'account_name',
        3  => 'account_no',
        4  => 'account_type',
        5  => 'ifsc_code',
        6  => 'ocr_no',
        7  => 'icri_number',
        8  => 'branch_name',
        9  => 'branch_address',
        10 => 'branch_code',
        11 => 'is_whatsapp',
        12 => 'auto_mail',
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

    protected static function newFactory(): Factory
    {
        return PartyBankDetailFactory::new();
    }
}
