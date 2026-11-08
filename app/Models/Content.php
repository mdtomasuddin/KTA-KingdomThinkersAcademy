<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

#[Guarded([])]
#[Hidden(['updated_at', 'created_at'])]
class Content extends Model
{
    // table name
    protected $table = 'contents';

    // The attributes that should be cast.
    protected function casts(): array
    {
        return [
            'id'         => 'integer',
            'title'      => 'string',
            'slug'       => 'string',
            'content'    => 'string',
            'status'     => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relationships and other model methods can be added here
    public function getUrlAttribute(): string
    {
        return url('/' . ltrim($this->slug ?? '', '/'));
    }
}
