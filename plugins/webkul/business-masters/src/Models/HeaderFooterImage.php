<?php

namespace Webkul\BusinessMasters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BusinessMasters\Database\Factories\HeaderFooterImageFactory;
use Webkul\Security\Models\User;

class HeaderFooterImage extends Model
{
    use HasFactory;

    protected $table = 'bm_header_footer_images';

    protected $fillable = [
        0 => 'company_id',
        1 => 'branch_id',
        2 => 'image_type',
        3 => 'file_path',
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

    public function branch(): BelongsTo
    {
        return $this->belongsTo(BranchMaster::class, 'branch_id');
    }

    protected static function newFactory(): Factory
    {
        return HeaderFooterImageFactory::new();
    }
}
