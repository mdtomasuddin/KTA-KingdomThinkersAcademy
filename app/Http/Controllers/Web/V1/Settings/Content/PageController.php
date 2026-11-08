<?php

namespace App\Http\Controllers\Web\V1\Settings\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\V1\Settings\Content\PageRequest;
use App\Models\Content;
use App\Services\Web\V1\Settings\Content\ContentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    public function __construct(
        protected ContentService $contentService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $query = Content::query()->latest();

            return DataTables::of($query)
                ->editColumn('title', function (Content $page) {
                    return e(html_entity_decode($page->title ?? 'N/A', ENT_QUOTES | ENT_HTML5));
                })
                ->editColumn('slug', function (Content $page) {
                    return '<code class="px-2 py-0.5 text-xs font-mono rounded bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">/' . e($page->slug ?? 'N/A') . '</code>';
                })
                ->editColumn('content', function (Content $page) {
                    $decoded = html_entity_decode(strip_tags($page->content ?? ''), ENT_QUOTES | ENT_HTML5);
                    $clean   = preg_replace('/\s+/', ' ', trim($decoded));

                    return $clean ? e(Str::limit($clean, 65)) : 'N/A';
                })
                ->addColumn('created_at', function ($data) {
                    return $data->created_at ? $data->created_at->format('d-m-y') : 'N/A';
                })
                ->addColumn('status', function (Content $page) {
                    $checked = $page->status === 'active' ? 'checked' : '';

                    return '<label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" onclick="changeStatus(event, ' . $page->id . ')"
                            class="sr-only peer" ' . $checked . '>
                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-green-500"></div>
                    </label>';
                })
                ->addColumn('action', function (Content $page) {
                    return '<div class="flex items-center justify-center gap-2">
                        <a href="' . $page->url . '" target="_blank"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-emerald-600 bg-emerald-100 hover:bg-emerald-600 hover:text-white dark:text-emerald-400 dark:bg-emerald-900/30 dark:hover:bg-emerald-600 dark:hover:text-white transition-all shadow-sm hover:shadow"
                            title="View Page">
                            <i class="fa-solid fa-eye text-sm"></i>
                        </a>
                        <a href="' . route('pages.edit', $page->id) . '"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 bg-blue-100 hover:bg-blue-600 hover:text-white dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-600 dark:hover:text-white transition-all shadow-sm hover:shadow"
                            title="Edit Page">
                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                        </a>
                        <button type="button"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 bg-red-100 hover:bg-red-600 hover:text-white dark:text-red-400 dark:bg-red-900/30 dark:hover:bg-red-600 dark:hover:text-white transition-all shadow-sm hover:shadow"
                            onclick="deleteRecord(event, ' . $page->id . ')"
                            title="Delete Page">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['slug', 'status', 'action', 'created_at'])
                ->make(true);
        }

        return view('backend.settings.content.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.settings.content.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request): RedirectResponse
    {
        try {
            $this->contentService->create($request->validated());

            return redirect()->route('pages.index')->with('t-success', 'Page created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('t-error', 'Failed to create page: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View | RedirectResponse
    {
        try {
            $page = Content::query()->findOrFail($id);

            return view('backend.settings.content.pages.edit', compact('page'));
        } catch (Exception $e) {
            return redirect()->route('pages.index')->with('t-error', 'Page not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, int $id): RedirectResponse
    {
        try {
            $this->contentService->update($id, $request->validated());

            return redirect()->route('pages.index')->with('t-success', 'Page updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('t-error', 'Failed to update page: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            Content::destroy($id);

            return response()->json([
                't-success' => true,
                'message'   => 'Page deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                't-error' => true,
                'message' => 'Failed to delete page.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle page status (active/inactive).
     */
    public function status(int $id): JsonResponse
    {
        try {
            $page         = Content::query()->findOrFail($id);
            $page->status = $page->status === 'active' ? 'inactive' : 'active';
            $page->save();

            return response()->json([
                't-success' => true,
                'message'   => 'Status changed successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                't-error' => true,
                'message' => 'Failed to update page status.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
