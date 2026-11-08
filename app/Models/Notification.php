<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

#[Guarded([])]
#[Hidden(['updated_at', 'type', 'notifiable_type'])]
class Notification extends BaseDatabaseNotification
{
    // Use the HasFactory trait for factory support
    use HasFactory;

    // table name
    protected $table = 'notifications';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $notification): void {
            if (empty($notification->category) && ! empty($notification->data['category'])) {
                $notification->category = $notification->data['category'];
            }
        });
    }

    // The attributes that should be cast.
    protected function casts(): array
    {
        return [
            'id'            => 'string',
            'type'          => 'string',
            'category'      => 'string',
            'notifiable_id' => 'integer',
            'data'          => 'array',
            'read_at'       => 'datetime',
            'created_at'    => 'datetime',
            'updated_at'    => 'datetime',
        ];
    }

    // Relationships and other model methods can be added here
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
