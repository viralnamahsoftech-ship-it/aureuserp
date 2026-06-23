<?php

namespace Webkul\BusinessMasters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BusinessMasters\Database\Factories\TaxTemplateLineFactory;
use Webkul\Security\Models\User;

class TaxTemplateLine extends Model
{
    use HasFactory;

    protected $table = 'bm_tax_template_lines';

    protected $fillable = [
        0 => 'tax_template_id',
        1 => 'tax_id',
        2 => 'percentage',
        3 => 'amount',
        4 => 'gl_code',
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

    public function template(): BelongsTo
    {
        return $this->belongsTo(TaxTemplate::class, 'tax_template_id');
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(TaxMaster::class, 'tax_id');
    }

    protected static function newFactory(): Factory
    {
        return TaxTemplateLineFactory::new();
    }
}
