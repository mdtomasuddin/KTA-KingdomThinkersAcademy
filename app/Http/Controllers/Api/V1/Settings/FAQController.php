<?php

namespace App\Http\Controllers\Api\V1\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Settings\FAQ\FAQResource;
use App\Models\FAQ;
use App\Traits\Api\V1\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    // Trait For Api Response
    use ApiResponse;

    /**
     * Display a listing of FAQs.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->query('per_page', 25);
            $search  = $request->query('search');

            $query = FAQ::query()->where('status', '=', 'active', 'and')->orderBy('created_at', 'desc');

            // Search filter
            if (! empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('question', 'like', '%' . $search . '%')
                        ->orWhere('answer', 'like', '%' . $search . '%');
                });
            }

            $faqs = $query->paginate($perPage);

            return $this->success(FAQResource::collection($faqs), 'Data retrieved successfully.', 200, true);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified FAQ.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $faq = FAQ::query()->where('status', '=', 'active', 'and')->find($id);

            if (! $faq) {
                return $this->error('Data not found.', 404);
            }

            return $this->success(new FAQResource($faq), 'Data details retrieved successfully.', 200);
        } catch (Exception $e) {
            return $this->error('Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
