<?php

namespace Webkul\BusinessMasters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BusinessMasters\Database\Factories\QcTemplateLineFactory;
use Webkul\Security\Models\User;

class QcTemplateLine extends Model
{
    use HasFactory;

    protected $table = 'bm_qc_template_lines';

    protected $fillable = [
        0 => 'qc_template_id',
        1 => 'qc_parameter_id',
        2 => 'min_value',
        3 => 'max_value',
        4 => 'result_type',
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

    public function template(): BelongsTo
    {
        return $this->belongsTo(QcTemplate::class, 'qc_template_id');
    }

    public function parameter(): BelongsTo
    {
        return $this->belongsTo(QcParameter::class, 'qc_parameter_id');
    }

    protected static function newFactory(): Factory
    {
        return QcTemplateLineFactory::new();
    }
}
