<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Guarded([])]
#[Hidden(['updated_at', 'created_at', 'deleted_at'])]
class CMS extends Model
{
    use SoftDeletes;

    // table name
    protected $table = 'c_m_s';

    // The attributes that should be cast.
    protected function casts(): array
    {
        return [
            'id'              => 'integer',
            'page'            => 'string',
            'section'         => 'string',
            'title'           => 'string',
            'sub_title'       => 'string',
            'description'     => 'string',
            'sub_description' => 'string',
            'image'           => 'string',
            'video'           => 'string',
            'sub_images'      => 'array',
            'button_text'     => 'string',
            'button_link'     => 'string',
            'sub_button_text' => 'string',
            'sub_button_link' => 'string',
            'content'         => 'array',
            'sort_order'      => 'integer',
            'status'          => 'string',
            'created_at'      => 'datetime',
            'updated_at'      => 'datetime',
            'deleted_at'      => 'datetime',
        ];
    }

    // Relationships and other model methods can be added here

    // Accessor for the image attribute
    public function getImageAttribute(?string $url): ?string
    {
        if ($url) {
            if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
                return $url;
            } else {
                return asset('/' . $url);
            }
        }
        return null;
    }

    // Accessor for the video attribute
    public function getVideoAttribute(?string $url): ?string
    {
        if ($url) {
            if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
                return $url;
            } else {
                return asset('/' . $url);
            }
        }
        return null;
    }

    // Accessor for the sub_images attribute
    public function getSubImagesAttribute(mixed $urls): ?array
    {
        if (is_string($urls)) {
            $urls = json_decode($urls, true);
        }
        if (is_array($urls)) {
            return array_map(function ($url) {
                if ($url) {
                    if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
                        return $url;
                    }
                    return asset('/' . $url);
                }
                return null;
            }, $urls);
        }
        return null;
    }
}
