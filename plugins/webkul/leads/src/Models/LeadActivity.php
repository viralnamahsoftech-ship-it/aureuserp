<?php

namespace Webkul\Lead\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Webkul\Security\Models\User;

class LeadActivity extends Model
{
    public const TYPE_NOTE = 'note';

    public const TYPE_CALL = 'call';

    public const TYPE_EMAIL = 'email';

    public const TYPE_MEETING = 'meeting';

    public const TYPE_TASK = 'task';

    protected $table = 'leads_activities';

    protected $fillable = [
        'lead_id',
        'type',
        'subject',
        'body',
        'activity_at',
        'creator_id',
    ];

    protected $casts = [
        'activity_at' => 'datetime',
    ];

    public static function typeOptions(): array
    {
        return [
            self::TYPE_NOTE    => 'Note',
            self::TYPE_CALL    => 'Call',
            self::TYPE_EMAIL   => 'Email',
            self::TYPE_MEETING => 'Meeting',
            self::TYPE_TASK    => 'Task',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (LeadActivity $activity) {
            $activity->activity_at ??= now();
            $activity->creator_id ??= Auth::id();
        });
    }
}
