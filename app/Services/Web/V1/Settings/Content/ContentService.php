<?php

namespace App\Services\Web\V1\Settings\Content;

use App\Helpers\Helper;
use App\Models\Content;
use Illuminate\Support\Str;

class ContentService
{
    /**
     * Create a new content page.
     *
     * @param  array<string, mixed>  $data
     * @return \App\Models\Content
     */
    public function create(array $data): Content
    {
        $title = trim($data['title']);

        if (! empty($data['slug'])) {
            $slug = Str::slug($data['slug']);
            if (Content::query()->where('slug', $slug)->exists()) {
                $slug = Helper::makeSlug($slug, 'contents');
            }
        } else {
            $slug = Helper::makeSlug($title, 'contents');
        }

        $status = $data['status'] ?? 'active';

        return Content::query()->create([
            'title'   => $title,
            'slug'    => $slug,
            'content' => $data['content'],
            'status'  => $status,
        ]);
    }

    /**
     * Update an existing content page.
     *
     * @param  int                   $id
     * @param  array<string, mixed>  $data
     * @return \App\Models\Content
     */
    public function update(int $id, array $data): Content
    {
        $page  = Content::query()->findOrFail($id);
        $title = trim($data['title']);

        if (! empty($data['slug'])) {
            $slug = Str::slug($data['slug']);
            if (Content::query()->where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = Helper::makeSlug($slug, 'contents');
            }
        } else {
            $slug = $page->slug ?: Helper::makeSlug($title, 'contents');
        }

        $status = $data['status'] ?? $page->status;

        $page->update([
            'title'   => $title,
            'slug'    => $slug,
            'content' => $data['content'],
            'status'  => $status,
        ]);

        return $page->fresh();
    }
}
