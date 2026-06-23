<?php

namespace Webkul\BusinessMasters\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\BusinessMasters\Database\Factories\DepartmentFactory;
use Webkul\Security\Models\User;

class Department extends Model
{
    use HasFactory;

    protected $table = 'bm_departments';

    protected $fillable = [
        0 => 'dept_code',
        1 => 'dept_name',
        2 => 'parent_dept_id',
        3 => 'is_active',
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

    public function parentDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_dept_id');
    }

    public function designations(): HasMany
    {
        return $this->hasMany(Designation::class, 'department_id');
    }

    protected static function newFactory(): Factory
    {
        return DepartmentFactory::new();
    }
}
