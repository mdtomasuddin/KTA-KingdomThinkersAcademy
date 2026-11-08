<?php

namespace App\Http\Controllers\Api\V1\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Settings\Content\ContentResource;
use App\Models\Content;
use App\Traits\Api\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // ! Trait For API Response
    use ApiResponse;

    /**
     * Display a listing of contents.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $slug = $request->query('slug');

            if (! empty($slug)) {
                $content = Content::where('status', 'active')->where('slug', $slug)->first();

                if (! $content) {
                    return $this->error('Data not found.', 404);
                }

                return $this->success(new ContentResource($content), 'Data retrieved successfully.', 200);
            }

            $contents = Content::where('status', 'active')->get();

            return $this->success(ContentResource::collection($contents), 'Data retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified content.
     */
    public function show(string $identifier): JsonResponse
    {
        try {
            $content = Content::where('status', 'active')->where(function ($q) use ($identifier) {
                $q->where('slug', $identifier)->orWhere('id', $identifier);
            })->first();

            if (! $content) {
                return $this->error('Data not found.', 404);
            }

            return $this->success(new ContentResource($content), 'Data details retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
