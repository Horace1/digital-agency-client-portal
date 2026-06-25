<?php

namespace App\Models;

use Database\Factories\SupportTicketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    /** @use HasFactory<SupportTicketFactory> */
    use HasFactory;

    public const STATUS_OPEN = 'open';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_WAITING_ON_CLIENT = 'waiting_on_client';

    public const STATUS_RESOLVED = 'resolved';

    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'project_id',
        'created_by',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'completed_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(SupportTicketComment::class);
    }

    /**
     * @return array<string, string>
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_OPEN => 'Open',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_WAITING_ON_CLIENT => 'Waiting on Client',
            self::STATUS_RESOLVED => 'Resolved',
            self::STATUS_CLOSED => 'Closed',
        ];
    }

    public static function statusLabel(string $status): string
    {
        return self::statuses()[$status] ?? str($status)->replace('_', ' ')->title()->toString();
    }

    public static function statusBadgeClasses(string $status): string
    {
        return match ($status) {
            self::STATUS_OPEN => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-200',
            self::STATUS_IN_PROGRESS => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200',
            self::STATUS_WAITING_ON_CLIENT => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
            self::STATUS_RESOLVED => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200',
            self::STATUS_CLOSED => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
        };
    }
}
