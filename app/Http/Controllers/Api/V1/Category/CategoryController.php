<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Category\CategoryResource;
use App\Models\Category;
use App\Traits\Api\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 *
 * Provides habit categories for Onboarding Screen 1 ("What are you spending on?").
 */
class CategoryController extends Controller
{
    // Trait for API Response
    use ApiResponse;

    /**
     * Display a listing of active categories.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Params
            $perPage = (int) $request->query('per_page', 25);
            $search  = $request->query('search');
            $order   = $request->query('order', 'desc');

            // Database query
            $query = Category::query()->where('status', 'active')->orderBy('id', $order);

            // Handle filters
            if (! empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            }

            // Pagination
            $categories = $query->paginate($perPage);

            // Response
            return $this->success(CategoryResource::collection($categories), 'Categories retrieved successfully.', 200, true);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified category by ID or slug.
     */
    public function show(string $identifier): JsonResponse
    {
        try {
            // Database query
            $category = Category::query()->where('status', 'active')
                ->where(function ($q) use ($identifier) {
                    $q->where('id', $identifier)->orWhere('slug', $identifier);
                })->first();

            // Not found check
            if (! $category) {
                return $this->notFound('Category not found.');
            }

            // Response
            return $this->success(new CategoryResource($category), 'Category details retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
