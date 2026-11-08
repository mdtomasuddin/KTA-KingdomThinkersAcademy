<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

#[Guarded([])]
#[Hidden(['password', 'remember_token', 'google_id', 'apple_id'])]
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // table name
    protected $table = 'users';

    // Get the identifier that will be stored in the subject claim of the JWT
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    // Return custom claims to be added to the JWT
    public function getJWTCustomClaims(): array
    {
        return [
            'email' => $this->email,
            'role'  => $this->role,
        ];
    }

    // The attributes that should be cast.
    protected function casts(): array
    {
        return [
            'id'                         => 'integer',
            'employee_id'                => 'string',
            'first_name'                 => 'string',
            'last_name'                  => 'string',
            'username'                   => 'string',
            'email'                      => 'string',
            'phone'                      => 'string',
            'emergency_contact'          => 'string',
            'emergency_contact_relation' => 'string',
            'designation'                => 'string',
            'gender'                     => 'string',
            'birthday'                   => 'date',
            'address'                    => 'string',
            'avatar'                     => 'string',
            'cover'                      => 'string',
            'signature_image'            => 'string',
            'role'                       => 'string',
            'bio'                        => 'string',
            'password'                   => 'hashed',
            'email_verified_at'          => 'datetime',
            'terms_and_conditions'       => 'boolean',
            'timezone'                   => 'string',
            'google_id'                  => 'string',
            'apple_id'                   => 'string',
            'status'                     => 'string',
            'last_seen_at'               => 'datetime',
            'remember_token'             => 'string',
            'created_at'                 => 'datetime',
            'updated_at'                 => 'datetime',
        ];
    }

    // Accessor for full_name
    public function getFullNameAttribute(): string
    {
        return trim(($this->attributes['first_name'] ?? '') . ' ' . ($this->attributes['last_name'] ?? ''));
    }

    // Accessor for the avatar attribute
    public function getAvatarAttribute(?string $url): ?string
    {
        if ($url) {
            if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
                return $url;
            } else {
                return asset('/' . ltrim($url, '/'));
            }
        }

        return null;
    }

    /**
     * Check if the user is currently online (activity within last 2 minutes).
     */
    public function getIsOnlineAttribute(): bool
    {
        return $this->last_seen_at ? $this->last_seen_at->gt(now()->subMinutes(2)) : false;
    }

    // Accessor for the cover attribute
    public function getCoverAttribute(?string $url): ?string
    {
        if ($url) {
            if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
                return $url;
            } else {
                return asset('/' . ltrim($url, '/'));
            }
        }

        return null;
    }

    // Accessor for the signature_image attribute
    public function getSignatureImageAttribute(?string $url): ?string
    {
        if ($url) {
            if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
                return $url;
            } else {
                return asset('/' . ltrim($url, '/'));
            }
        }

        return null;
    }

    // Relationships and other model methods can be added here
    public function otps(): HasMany
    {
        return $this->hasMany(OTP::class);
    }

    public function firebaseTokens(): HasMany
    {
        return $this->hasMany(FirebaseToken::class);
    }
}
