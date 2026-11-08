<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded([])]
#[Hidden(['created_at', 'updated_at', 'is_active'])]
class FirebaseToken extends Model
{
    use HasFactory;

    protected $table = 'firebase_tokens';

    protected function casts(): array
    {
        return [
            'id'         => 'integer',
            'user_id'    => 'integer',
            'token'      => 'string',
            'device_id'  => 'string',
            'is_active'  => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
