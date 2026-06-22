<?php

namespace Webkul\CustomerSupport\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Webkul\Partner\Models\Partner;
use Webkul\Security\Models\User;
use Webkul\Support\Models\Company;

class Ticket extends Model
{
    use HasUlids;

    public const STATUS_OPEN = 'open';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_RESOLVED = 'resolved';

    public const STATUS_CLOSED = 'closed';

    public const PRIORITY_LOW = 'low';

    public const PRIORITY_MEDIUM = 'medium';

    public const PRIORITY_HIGH = 'high';

    public const PRIORITY_URGENT = 'urgent';

    protected $table = 'customer_support_tickets';

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'customer_id',
        'assigned_to',
        'resolved_at',
        'company_id',
        'creator_id',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_OPEN        => 'Open',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_RESOLVED    => 'Resolved',
            self::STATUS_CLOSED      => 'Closed',
        ];
    }

    public static function statusColors(): array
    {
        return [
            self::STATUS_OPEN        => 'info',
            self::STATUS_IN_PROGRESS => 'warning',
            self::STATUS_RESOLVED    => 'success',
            self::STATUS_CLOSED      => 'gray',
        ];
    }

    public static function priorityOptions(): array
    {
        return [
            self::PRIORITY_LOW    => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH   => 'High',
            self::PRIORITY_URGENT => 'Urgent',
        ];
    }

    public static function priorityColors(): array
    {
        return [
            self::PRIORITY_LOW    => 'gray',
            self::PRIORITY_MEDIUM => 'info',
            self::PRIORITY_HIGH   => 'warning',
            self::PRIORITY_URGENT => 'danger',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'customer_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Ticket $ticket) {
            $authUser = Auth::user();

            $ticket->status ??= self::STATUS_OPEN;
            $ticket->priority ??= self::PRIORITY_MEDIUM;
            $ticket->creator_id ??= $authUser?->id;
            $ticket->company_id ??= $authUser?->default_company_id;
        });

        static::saving(function (Ticket $ticket) {
            if (in_array($ticket->status, [self::STATUS_RESOLVED, self::STATUS_CLOSED]) && ! $ticket->resolved_at) {
                $ticket->resolved_at = now();
            }
        });
    }
}
