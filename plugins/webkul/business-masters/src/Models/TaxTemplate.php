<?php

namespace Webkul\BusinessMasters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\BusinessMasters\Database\Factories\TaxTemplateFactory;
use Webkul\Security\Models\User;

class TaxTemplate extends Model
{
    use HasFactory;

    protected $table = 'bm_tax_templates';

    protected $fillable = [
        0 => 'template_name',
        1 => 'definition',
        2 => 'is_active',
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

    public function lines(): HasMany
    {
        return $this->hasMany(TaxTemplateLine::class, 'tax_template_id');
    }

    protected static function newFactory(): Factory
    {
        return TaxTemplateFactory::new();
    }
}
