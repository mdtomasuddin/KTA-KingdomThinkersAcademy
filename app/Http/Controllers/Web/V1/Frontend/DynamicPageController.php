<?php

namespace App\Http\Controllers\Web\V1\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Contracts\View\View;

class DynamicPageController extends Controller
{
    /**
     * Dynamically display content by slug.
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function showBySlug(string $slug): View
    {
        $content = Content::query()
            ->where('status', 'active')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.dynamicPage.page', [
            'title'     => $content->title,
            'body'      => $content->content,
            'updatedAt' => $content->updated_at ? $content->updated_at->format('F d, Y') : null,
            'appName'   => config('app.name', 'Dashboard'),
        ]);
    }
}
