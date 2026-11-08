<?php

namespace App\Http\Controllers\Web\V1\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\V1\Category\CategoryCreateRequest;
use App\Http\Requests\Web\V1\Category\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\Web\V1\Category\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $query = Category::query()->latest();

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('name', function (Category $category) {
                    return ! empty($category->name) ? e($category->name) : 'N/A';
                })
                ->editColumn('slug', function (Category $category) {
                    return ! empty($category->slug) ? e($category->slug) : 'N/A';
                })
                ->addColumn('status', function (Category $category) {
                    $checked = $category->status === 'active' ? 'checked' : '';
                    return '<label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" onclick="changeStatus(event, ' . $category->id . ')"
                            class="sr-only peer" ' . $checked . '>
                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-green-500"></div>
                    </label>';
                })
                ->addColumn('action', function (Category $category) {
                    return '<div class="flex items-center justify-center gap-2">
                        <a href="' . route('category.edit', $category->id) . '"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 bg-blue-100 hover:bg-blue-600 hover:text-white dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-600 dark:hover:text-white transition-all shadow-sm hover:shadow"
                            title="Edit">
                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                        </a>
                        <button type="button"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 bg-red-100 hover:bg-red-600 hover:text-white dark:text-red-400 dark:bg-red-900/30 dark:hover:bg-red-600 dark:hover:text-white transition-all shadow-sm hover:shadow"
                            onclick="deleteRecord(event, ' . $category->id . ')"
                            title="Delete">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['slug', 'name', 'status', 'action', 'created_at'])
                ->make(true);
        }

        return view('backend.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request): RedirectResponse
    {
        try {
            $this->categoryService->create($request->validated());

            return redirect()->route('category.index')->with('t-success', 'Category created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('t-error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View | RedirectResponse
    {
        try {
            $category = Category::query()->findOrFail($id);

            return view('backend.categories.edit', compact('category'));
        } catch (Exception $e) {
            return redirect()->route('category.index')->with('t-error', 'Category not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, int $id): RedirectResponse
    {
        try {
            $this->categoryService->update($id, $request->validated());

            return redirect()->route('category.index')->with('t-success', 'Category updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('t-error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $category = Category::query()->findOrFail($id);
            $category->delete();

            return response()->json([
                't-success' => true,
                'message'   => 'Category deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                't-error' => true,
                'message' => 'Failed to delete category.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle category status (active/inactive).
     */
    public function status(int $id): JsonResponse
    {
        try {
            $category         = Category::query()->findOrFail($id);
            $category->status = $category->status === 'active' ? 'inactive' : 'active';
            $category->save();

            return response()->json([
                't-success' => true,
                'message'   => 'Status changed successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                't-error' => true,
                'message' => 'Failed to update category status.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
