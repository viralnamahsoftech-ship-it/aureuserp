<?php

namespace Webkul\BusinessMasters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BusinessMasters\Database\Factories\DocWiseSerialNoFactory;
use Webkul\Security\Models\User;

class DocWiseSerialNo extends Model
{
    use HasFactory;

    protected $table = 'bm_doc_wise_serial_nos';

    protected $fillable = [
        0 => 'company_id',
        1 => 'branch_id',
        2 => 'document_type',
        3 => 'serial_no_id',
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

    public function serialNo(): BelongsTo
    {
        return $this->belongsTo(SerialNoMaster::class, 'serial_no_id');
    }

    protected static function newFactory(): Factory
    {
        return DocWiseSerialNoFactory::new();
    }
}
