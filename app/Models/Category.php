<?php

namespace App\Models;

use Illuminate\Console\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded([])]
#[Hidden(['updated_at', 'created_at'])]
class Category extends Model
{
    // table name
    protected $table = 'categories';

    // The attributes that should be cast.
    protected function casts(): array
    {
        return [
            'id'         => 'integer',
            'name'       => 'string',
            'slug'       => 'string',
            'status'     => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relationships and other model methods can be added here
}
