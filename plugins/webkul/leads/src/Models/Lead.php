<?php

namespace Webkul\Lead\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Webkul\Partner\Models\Partner;
use Webkul\Security\Models\User;
use Webkul\Support\Models\Company;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    public const STAGE_NEW = 'new';

    public const STAGE_QUALIFIED = 'qualified';

    public const STAGE_SITE_SURVEY = 'site_survey';

    public const STAGE_DESIGN = 'design';

    public const STAGE_SENT = 'sent';

    public const STAGE_QUOTATION = 'quotation';

    public const STAGE_NEGOTIATION = 'negotiation';

    public const STAGE_MEETING_DONE = 'meeting_done';

    public const STAGE_AGREEMENT_DONE = 'agreement_done';

    public const STAGE_WON = 'won';

    public const STAGE_LOST = 'lost';

    public const STAGE_DISQUALIFIED = 'disqualified';

    public const PRIORITY_LOW = 'low';

    public const PRIORITY_MEDIUM = 'medium';

    public const PRIORITY_HIGH = 'high';

    public const PRIORITY_EXTREME = 'extreme';

    public const PROCESS_PENDING = 'pending';

    public const PROCESS_IN_PROGRESS = 'in_progress';

    public const PROCESS_COMPLETED = 'completed';

    public const PROGRESS_NEW = 'new';

    public const PROGRESS_OPEN = 'open';

    public const PROGRESS_IN_PROGRESS = 'in_progress';

    public const PROGRESS_ON_HOLD = 'on_hold';

    public const PROGRESS_COMPLETED = 'completed';

    public const PROGRESS_CANCELLED = 'cancelled';

    public const PROGRESS_CLOSE_WON = 'close_won';

    public const PROGRESS_CLOSE_LOST = 'close_lost';

    public const USER_STATE_ACTIVE = 'active';

    public const USER_STATE_DEACTIVATED = 'deactivated';

    protected $table = 'leads_leads';

    protected $fillable = [
        'lead_number',
        'lead_date',
        'business_name',
        'contact_title',
        'contact_name',
        'email',
        'phone',
        'alternate_phone',
        'business_segment',
        'business_category',
        'business_sub_category',
        'stage',
        'priority',
        'source',
        'other_source',
        'process_status',
        'progress_status',
        'user_state',
        'project_title',
        'description',
        'remarks',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'country',
        'location',
        'latitude',
        'longitude',
        'site_contact_name',
        'site_contact_phone',
        'site_address_line_1',
        'site_address_line_2',
        'site_city',
        'site_state',
        'site_zip',
        'gst_number',
        'pv_capacity',
        'expected_value',
        'probability',
        'expected_close_date',
        'last_contacted_at',
        'next_follow_up_at',
        'lost_reason',
        'territory',
        'account_manager_id',
        'channel_partner_id',
        'sales_person_ids',
        'products',
        'customer_id',
        'assigned_to',
        'company_id',
        'creator_id',
    ];

    protected $casts = [
        'lead_date'          => 'date',
        'pv_capacity'        => 'decimal:2',
        'expected_value'     => 'decimal:2',
        'probability'        => 'integer',
        'latitude'           => 'decimal:7',
        'longitude'          => 'decimal:7',
        'expected_close_date'=> 'date',
        'last_contacted_at'  => 'datetime',
        'next_follow_up_at'  => 'datetime',
        'sales_person_ids'   => 'array',
        'products'           => 'array',
    ];

    public static function stageOptions(): array
    {
        return [
            self::STAGE_NEW            => 'New',
            self::STAGE_QUALIFIED      => 'Qualified',
            self::STAGE_SITE_SURVEY    => 'Site Survey',
            self::STAGE_DESIGN         => 'Design',
            self::STAGE_QUOTATION      => 'Quotation',
            self::STAGE_SENT           => 'Sent',
            self::STAGE_NEGOTIATION    => 'Negotiation',
            self::STAGE_MEETING_DONE   => 'Meeting Done',
            self::STAGE_AGREEMENT_DONE => 'Agreement Done',
            self::STAGE_WON            => 'Won',
            self::STAGE_LOST           => 'Lost',
            self::STAGE_DISQUALIFIED   => 'Disqualified',
        ];
    }

    public static function stageColors(): array
    {
        return [
            self::STAGE_NEW            => 'gray',
            self::STAGE_QUALIFIED      => 'info',
            self::STAGE_SITE_SURVEY    => 'warning',
            self::STAGE_DESIGN         => 'warning',
            self::STAGE_QUOTATION      => 'primary',
            self::STAGE_SENT           => 'primary',
            self::STAGE_NEGOTIATION    => 'primary',
            self::STAGE_MEETING_DONE   => 'info',
            self::STAGE_AGREEMENT_DONE => 'success',
            self::STAGE_WON            => 'success',
            self::STAGE_LOST           => 'danger',
            self::STAGE_DISQUALIFIED   => 'danger',
        ];
    }

    public static function priorityOptions(): array
    {
        return [
            self::PRIORITY_LOW     => 'Low',
            self::PRIORITY_MEDIUM  => 'Medium',
            self::PRIORITY_HIGH    => 'High',
            self::PRIORITY_EXTREME => 'Extreme',
        ];
    }

    public static function priorityColors(): array
    {
        return [
            self::PRIORITY_LOW     => 'gray',
            self::PRIORITY_MEDIUM  => 'info',
            self::PRIORITY_HIGH    => 'warning',
            self::PRIORITY_EXTREME => 'danger',
        ];
    }

    public static function sourceOptions(): array
    {
        return [
            'advertisement'      => 'Advertisement',
            'business_affiliate' => 'Business Affiliate',
            'business_directory' => 'Business Directory',
            'channel_partners'   => 'Channel Partners',
            'customer_reference' => 'Customer Reference',
            'email_campaign'     => 'Email Campaign',
            'exhibitions'        => 'Exhibitions',
            'friend'             => 'Friend',
            'google'             => 'Google',
            'indiamart'          => 'IndiaMart',
            'just_dial'          => 'Just-Dial',
            'newspaper_ads'      => 'Newspaper Ads',
            'phone_call'         => 'Phone Call',
            'sales_person'       => 'Sales Person Name',
            'social_media'       => 'Social Media',
            'website'            => 'Website',
            'other'              => 'Other',
        ];
    }

    public static function processStatusOptions(): array
    {
        return [
            self::PROCESS_PENDING     => 'Pending',
            self::PROCESS_IN_PROGRESS => 'In Progress',
            self::PROCESS_COMPLETED   => 'Completed',
        ];
    }

    public static function progressStatusOptions(): array
    {
        return [
            self::PROGRESS_NEW         => 'New',
            self::PROGRESS_OPEN        => 'Open',
            self::PROGRESS_IN_PROGRESS => 'In Progress',
            self::PROGRESS_ON_HOLD     => 'On-Hold',
            self::PROGRESS_COMPLETED   => 'Completed',
            self::PROGRESS_CANCELLED   => 'Cancelled',
            self::PROGRESS_CLOSE_WON   => 'Close Won',
            self::PROGRESS_CLOSE_LOST  => 'Close Lost',
        ];
    }

    public static function userStateOptions(): array
    {
        return [
            self::USER_STATE_ACTIVE      => 'Active',
            self::USER_STATE_DEACTIVATED => 'Deactivated',
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

    public function accountManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }

    public function channelPartner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'channel_partner_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Lead $lead) {
            $authUser = Auth::user();

            $lead->lead_number ??= static::nextLeadNumber();
            $lead->lead_date ??= now()->toDateString();
            $lead->stage ??= self::STAGE_NEW;
            $lead->priority ??= self::PRIORITY_MEDIUM;
            $lead->process_status ??= self::PROCESS_PENDING;
            $lead->progress_status ??= self::PROGRESS_NEW;
            $lead->user_state ??= self::USER_STATE_ACTIVE;
            $lead->country ??= 'India';
            $lead->creator_id ??= $authUser?->id;
            $lead->assigned_to ??= $authUser?->id;
            $lead->account_manager_id ??= $authUser?->id;
            $lead->company_id ??= $authUser?->default_company_id;
        });
    }

    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->zip,
            $this->country,
        ])
            ->filter()
            ->implode(', ');
    }

    public function getMapUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return 'https://www.google.com/maps/search/?api=1&query='.$this->latitude.','.$this->longitude;
        }

        $query = $this->location ?: $this->full_address;

        if (! $query) {
            return null;
        }

        return 'https://www.google.com/maps/search/?api=1&query='.urlencode($query);
    }

    protected static function nextLeadNumber(): string
    {
        $prefix = 'LEAD'.now()->format('y');
        $latest = static::query()
            ->where('lead_number', 'like', $prefix.'_%')
            ->latest('created_at')
            ->value('lead_number');

        $number = $latest ? ((int) str($latest)->after('_')->toString()) + 1 : 1;

        return $prefix.'_'.str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }
}
