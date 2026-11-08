<?php

namespace App\Http\Controllers\Web\V1\Users;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\V1\User\UserCreateRequest;
use App\Http\Requests\Web\V1\User\UserUpdateRequest;
use App\Models\User;
use App\Services\Web\V1\User\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * Display a listing of the resource with modal-driven workflows.
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $query = User::query()->latest();

            return DataTables::of($query)
                ->addColumn('avatar', function (User $user) {
                    if ($user->avatar) {
                        return '<img src="' . asset($user->avatar) . '" alt="' . e($user->full_name) . '" class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-gray-700 shadow-sm">';
                    }

                    $initial = strtoupper(substr($user->first_name ?: 'U', 0, 1));

                    return '<div class="w-10 h-10 rounded-full bg-primary-50 dark:bg-primary-950 text-primary-600 dark:text-primary-400 font-bold text-xs flex items-center justify-center border border-primary-200 dark:border-primary-800">' . $initial . '</div>';
                })
                ->addColumn('name', function (User $user) {
                    $fullName = ! empty($user->full_name) ? e($user->full_name) : 'N/A';
                    $username = $user->username ? '<span class="text-[11px] text-gray-400 font-normal block">@' . e($user->username) . '</span>' : '';
                    $empId    = $user->employee_id ? '<span class="text-[10px] text-gray-500 font-mono block">ID: ' . e($user->employee_id) . '</span>' : '';

                    return '<div class="font-semibold text-gray-900 dark:text-white text-xs">' . $fullName . '</div>' . $username . $empId;
                })
                ->addColumn('email', function (User $user) {
                    $email = ! empty($user->email) ? e($user->email) : 'N/A';
                    $phone = $user->phone ? '<span class="text-[11px] text-gray-400 block">' . e($user->phone) . '</span>' : '';

                    return '<div class="text-xs text-gray-700 dark:text-gray-300">' . $email . '</div>' . $phone;
                })
                ->addColumn('role', function (User $user) {
                    $roleStyles = [
                        'parent'             => 'bg-purple-100 text-purple-700 dark:bg-purple-950 dark:text-purple-300',
                        'student'            => 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
                        'teacher'            => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
                        'contracted_teacher' => 'bg-teal-100 text-teal-700 dark:bg-teal-950 dark:text-teal-300',
                        'coop'               => 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
                        'micro_school'       => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
                        'admin'              => 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300',
                        'super_admin'        => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
                    ];
                    $style     = $roleStyles[$user->role] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300';
                    $roleLabel = ucwords(str_replace('_', ' ', (string) $user->role));
                    $desig     = $user->designation ? '<span class="text-[10px] text-gray-400 block mt-0.5">' . e($user->designation) . '</span>' : '';

                    return '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold ' . $style . '">' . $roleLabel . '</span>' . $desig;
                })
                ->addColumn('status', function (User $user) {
                    $checked = $user->status === 'active' ? 'checked' : '';

                    return '<label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" onclick="changeStatus(event, ' . $user->id . ')"
                            class="sr-only peer" ' . $checked . '>
                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-green-500"></div>
                    </label>';
                })
                ->addColumn('created_at', function (User $user) {
                    return $user->created_at ? '<span class="text-xs text-gray-600 dark:text-gray-400 font-medium">' . $user->created_at->format('d M, Y') . '</span>' : 'N/A';
                })
                ->addColumn('action', function (User $user) {
                    return '<div class="flex items-center justify-center gap-2">
                        <button type="button"
                            onclick="viewUserDetails(' . $user->id . ')"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-emerald-600 bg-emerald-100 hover:bg-emerald-600 hover:text-white dark:text-emerald-400 dark:bg-emerald-900/30 dark:hover:bg-emerald-600 dark:hover:text-white transition-all shadow-sm hover:shadow"
                            title="View Details">
                            <i class="fa-solid fa-eye text-sm"></i>
                        </button>
                        <button type="button"
                            onclick="editUser(' . $user->id . ')"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 bg-blue-100 hover:bg-blue-600 hover:text-white dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-600 dark:hover:text-white transition-all shadow-sm hover:shadow"
                            title="Edit">
                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                        </button>
                        <button type="button"
                            onclick="deleteRecord(event, ' . $user->id . ')"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 bg-red-100 hover:bg-red-600 hover:text-white dark:text-red-400 dark:bg-red-900/30 dark:hover:bg-red-600 dark:hover:text-white transition-all shadow-sm hover:shadow"
                            title="Delete">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    </div>';
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('first_name', 'like', "%{$keyword}%")
                            ->orWhere('last_name', 'like', "%{$keyword}%")
                            ->orWhere('username', 'like', "%{$keyword}%")
                            ->orWhere('employee_id', 'like', "%{$keyword}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$keyword}%"]);
                    });
                })
                ->rawColumns(['avatar', 'name', 'email', 'role', 'status', 'created_at', 'action'])
                ->make(true);
        }

        return view('backend.users.index');
    }

    /**
     * Show create page fallback (modal-driven).
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('users.index');
    }

    /**
     * Store a newly created resource via Modal AJAX.
     */
    public function store(UserCreateRequest $request): JsonResponse | RedirectResponse
    {
        try {
            $user = $this->userService->create($request->validated());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'   => true,
                    't-success' => true,
                    'message'   => 'User created successfully.',
                    'data'      => $user,
                ], 201);
            }

            return redirect()->route('users.index')->with('t-success', 'User created successfully.');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    't-error' => true,
                    'message' => 'Failed to create user: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->withInput()->with('t-error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource for the View/Show Modal.
     */
    public function show(int $id): JsonResponse | RedirectResponse
    {
        try {
            $user = User::query()->findOrFail($id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success'   => true,
                    't-success' => true,
                    'data'      => $user,
                ]);
            }

            return redirect()->route('users.index');
        } catch (Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    't-error' => true,
                    'message' => 'User not found.',
                ], 404);
            }

            return redirect()->route('users.index')->with('t-error', 'User not found.');
        }
    }

    /**
     * Fetch user details for the Edit Modal.
     */
    public function edit(int $id): JsonResponse | RedirectResponse
    {
        try {
            $user = User::query()->findOrFail($id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success'   => true,
                    't-success' => true,
                    'data'      => $user,
                ]);
            }

            return redirect()->route('users.index');
        } catch (Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    't-error' => true,
                    'message' => 'User not found.',
                ], 404);
            }

            return redirect()->route('users.index')->with('t-error', 'User not found.');
        }
    }

    /**
     * Update the specified resource via Modal AJAX.
     */
    public function update(UserUpdateRequest $request, int $id): JsonResponse | RedirectResponse
    {
        try {
            $user = $this->userService->update($id, $request->validated());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'   => true,
                    't-success' => true,
                    'message'   => 'User updated successfully.',
                    'data'      => $user,
                ]);
            }

            return redirect()->route('users.index')->with('t-success', 'User updated successfully.');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    't-error' => true,
                    'message' => 'Failed to update user: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->withInput()->with('t-error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $user = User::query()->findOrFail($id);

            if ($user->avatar) {
                Helper::deleteFile($user->avatar);
            }
            if ($user->cover) {
                Helper::deleteFile($user->cover);
            }

            $user->delete();

            return response()->json([
                'success'   => true,
                't-success' => true,
                'message'   => 'User deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                't-error' => true,
                'message' => 'Failed to delete user.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle user status (active/inactive).
     */
    public function status(int $id): JsonResponse
    {
        try {
            $user         = User::query()->findOrFail($id);
            $user->status = $user->status === 'active' ? 'inactive' : 'active';
            $user->save();

            return response()->json([
                'success'   => true,
                't-success' => true,
                'message'   => 'Status changed successfully.',
                'status'    => $user->status,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                't-error' => true,
                'message' => 'Failed to update user status.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
