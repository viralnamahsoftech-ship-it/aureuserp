<?php

namespace Webkul\BusinessParty\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BusinessParty\Database\Factories\PartyContactPersonFactory;
use Webkul\Security\Models\User;

class PartyContactPerson extends Model
{
    use HasFactory;

    protected $table = 'bp_party_contact_persons';

    protected $fillable = [
        0  => 'party_id',
        1  => 'site_name',
        2  => 'contact_name',
        3  => 'department_id',
        4  => 'designation_id',
        5  => 'mobile',
        6  => 'phone',
        7  => 'ext_no',
        8  => 'email',
        9  => 'is_whatsapp',
        10 => 'auto_mail',
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
        return PartyContactPersonFactory::new();
    }
}
