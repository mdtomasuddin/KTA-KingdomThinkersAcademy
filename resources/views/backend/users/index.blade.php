@extends('backend.master')

@section('title')
    {{ config('app.name') }} || User Management
@endsection

@section('content')
    <!--begin: Page Header-->
    <div class="page-header">
        <!--begin: Page Title-->
        <div class="page-title">
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
                <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-active">Users</span>
            </nav>
            <p class="page-description">
                User Management: View, search, create, and manage workforce user accounts with instant modal workflows.
            </p>
        </div>
        <!--end: Page Title-->

        <!--begin: Actions-->
        <div class="page-actions">
            <button type="button" onclick="openCreateUserModal()" class="btn-primary">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add User</span>
            </button>
        </div>
        <!--end: Actions-->
    </div>
    <!--end: Page Header-->

    <!--begin: Table Card-->
    <div class="card p-5">
        <div class="table-responsive">
            <table id="users-table" class="table-hover w-full text-left text-sm text-gray-600 dark:text-gray-300">
                <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-center w-12">Avatar</th>
                        <th scope="col" class="px-4 py-3">Name</th>
                        <th scope="col" class="px-4 py-3">Email & Phone</th>
                        <th scope="col" class="px-4 py-3">Role & Designation</th>
                        <th scope="col" class="px-4 py-3 text-center">Status</th>
                        <th scope="col" class="px-4 py-3">Joined</th>
                        <th scope="col" class="px-4 py-3 text-center w-28">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    {{-- Populated by DataTables via AJAX --}}
                </tbody>
            </table>
        </div>
    </div>
    <!--end: Table Card-->

    <!--begin: Create User Modal-->
    <div id="create-user-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/60 transition-opacity" onclick="closeCreateUserModal()"></div>

        <!-- Dialog -->
        <div class="relative flex items-center justify-center min-h-screen p-4 pointer-events-none">
            <div class="w-full max-w-2xl bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden pointer-events-auto">
                <form id="createUserForm" onsubmit="submitCreateUser(event)" enctype="multipart/form-data">
                    @csrf
                    <!-- Header -->
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 dark:bg-primary-950 dark:text-primary-400 flex items-center justify-center">
                                <i class="fa-solid fa-user-plus text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Add New User</h3>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Create a new workforce team member account</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeCreateUserModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fa-solid fa-xmark text-base"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                        <!-- Avatar Preview & Upload -->
                        <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50/60 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <div class="relative w-16 h-16 rounded-full overflow-hidden border-2 border-primary-500/20 bg-gray-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                                <img id="create_avatar_preview" src="" alt="Avatar Preview" class="w-full h-full object-cover hidden">
                                <i id="create_avatar_placeholder" class="fa-solid fa-user text-2xl text-gray-400"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Profile Photo
                                </label>
                                <input type="file" id="create_avatar" name="avatar" accept="image/*" onchange="previewAvatar(this, 'create_avatar_preview', 'create_avatar_placeholder')" class="form-input text-xs">
                                <p class="text-[11px] text-gray-400 mt-0.5">PNG, JPG, or WEBP up to 2MB.</p>
                            </div>
                        </div>

                        <!-- Name Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="create_first_name" name="first_name" required class="form-input text-xs" placeholder="e.g. John">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Last Name
                                </label>
                                <input type="text" id="create_last_name" name="last_name" class="form-input text-xs" placeholder="e.g. Doe">
                            </div>
                        </div>

                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="create_email" name="email" required class="form-input text-xs" placeholder="john@example.com">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Phone Number
                                </label>
                                <input type="text" id="create_phone" name="phone" class="form-input text-xs" placeholder="+1 555-0199">
                            </div>
                        </div>

                        <!-- Role & Designation -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select id="create_role" name="role" required class="form-input text-xs">
                                    <option value="parent">Parent</option>
                                    <option value="student" selected>Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="contracted_teacher">Contracted Teacher</option>
                                    <option value="coop">Co-op</option>
                                    <option value="micro_school">Micro School</option>
                                    <option value="admin">Admin</option>
                                    <option value="super_admin">Super Admin</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Designation / Title
                                </label>
                                <input type="text" id="create_designation" name="designation" class="form-input text-xs" placeholder="e.g. Mathematics Teacher">
                            </div>
                        </div>

                        <!-- ID & Gender -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Student / Staff ID
                                </label>
                                <input type="text" id="create_employee_id" name="employee_id" class="form-input text-xs" placeholder="e.g. STU-1042">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Gender
                                </label>
                                <select id="create_gender" name="gender" class="form-input text-xs">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Birthday & Status -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Birthday
                                </label>
                                <input type="date" id="create_birthday" name="birthday" class="form-input text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="create_status" name="status" required class="form-input text-xs">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="create_password" name="password" required minlength="8" class="form-input text-xs" placeholder="At least 8 characters">
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Address
                            </label>
                            <input type="text" id="create_address" name="address" class="form-input text-xs" placeholder="City, State, Country">
                        </div>

                        <!-- Bio -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Bio / Notes
                            </label>
                            <textarea id="create_bio" name="bio" rows="2" class="form-input text-xs" placeholder="Short professional summary..."></textarea>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2 bg-gray-50/50 dark:bg-gray-800/50">
                        <button type="button" onclick="closeCreateUserModal()" class="btn-secondary">Cancel</button>
                        <button type="submit" id="saveCreateUserBtn" class="btn-primary">
                            <i class="fa-solid fa-check text-xs"></i>
                            <span>Create</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end: Create User Modal-->

    <!--begin: Edit User Modal-->
    <div id="edit-user-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/60 transition-opacity" onclick="closeEditUserModal()"></div>

        <!-- Dialog -->
        <div class="relative flex items-center justify-center min-h-screen p-4 pointer-events-none">
            <div class="w-full max-w-2xl bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden pointer-events-auto">
                <form id="editUserForm" onsubmit="submitEditUser(event)" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_user_id" name="id">

                    <!-- Header -->
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400 flex items-center justify-center">
                                <i class="fa-solid fa-user-pen text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit User Profile</h3>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Update account details, roles, and status</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeEditUserModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fa-solid fa-xmark text-base"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                        <!-- Avatar Preview & Upload -->
                        <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50/60 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <div class="relative w-16 h-16 rounded-full overflow-hidden border-2 border-primary-500/20 bg-gray-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                                <img id="edit_avatar_preview" src="" alt="Avatar Preview" class="w-full h-full object-cover hidden">
                                <i id="edit_avatar_placeholder" class="fa-solid fa-user text-2xl text-gray-400"></i>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Change Profile Photo
                                </label>
                                <input type="file" id="edit_avatar" name="avatar" accept="image/*" onchange="previewAvatar(this, 'edit_avatar_preview', 'edit_avatar_placeholder')" class="form-input text-xs">
                                <p class="text-[11px] text-gray-400 mt-0.5">Leave empty to keep existing photo.</p>
                            </div>
                        </div>

                        <!-- Name Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="edit_first_name" name="first_name" required class="form-input text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Last Name
                                </label>
                                <input type="text" id="edit_last_name" name="last_name" class="form-input text-xs">
                            </div>
                        </div>

                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="edit_email" name="email" required class="form-input text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Phone Number
                                </label>
                                <input type="text" id="edit_phone" name="phone" class="form-input text-xs">
                            </div>
                        </div>

                        <!-- Role & Designation -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select id="edit_role" name="role" required class="form-input text-xs">
                                    <option value="parent">Parent</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="contracted_teacher">Contracted Teacher</option>
                                    <option value="coop">Co-op</option>
                                    <option value="micro_school">Micro School</option>
                                    <option value="admin">Admin</option>
                                    <option value="super_admin">Super Admin</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Designation / Title
                                </label>
                                <input type="text" id="edit_designation" name="designation" class="form-input text-xs" placeholder="e.g. Mathematics Teacher">
                            </div>
                        </div>

                        <!-- ID & Gender -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Student / Staff ID
                                </label>
                                <input type="text" id="edit_employee_id" name="employee_id" class="form-input text-xs" placeholder="e.g. STU-1042">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Gender
                                </label>
                                <select id="edit_gender" name="gender" class="form-input text-xs">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Birthday & Status -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Birthday
                                </label>
                                <input type="date" id="edit_birthday" name="birthday" class="form-input text-xs">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="edit_status" name="status" required class="form-input text-xs">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                        </div>

                        <!-- Optional Password Change -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Reset Password <span class="text-[11px] font-normal text-gray-400">(leave blank to keep current)</span>
                            </label>
                            <input type="password" id="edit_password" name="password" minlength="8" class="form-input text-xs" placeholder="Enter new password if changing">
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Address
                            </label>
                            <input type="text" id="edit_address" name="address" class="form-input text-xs">
                        </div>

                        <!-- Bio -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Bio / Notes
                            </label>
                            <textarea id="edit_bio" name="bio" rows="2" class="form-input text-xs"></textarea>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2 bg-gray-50/50 dark:bg-gray-800/50">
                        <button type="button" onclick="closeEditUserModal()" class="btn-secondary">Cancel</button>
                        <button type="submit" id="saveEditUserBtn" class="btn-primary">
                            <i class="fa-solid fa-check text-xs"></i>
                            <span>Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end: Edit User Modal-->

    <!--begin: View User Details Modal-->
    <div id="view-user-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/60 transition-opacity" onclick="closeViewUserModal()"></div>

        <!-- Dialog -->
        <div class="relative flex items-center justify-center min-h-screen p-4 pointer-events-none">
            <div class="w-full max-w-2xl bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden pointer-events-auto">
                <!-- Header -->
                <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950 dark:text-blue-400 flex items-center justify-center">
                            <i class="fa-solid fa-id-badge text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">User Profile Details</h3>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Comprehensive employee workforce information</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeViewUserModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto">
                    <!-- Avatar & Primary Info -->
                    <div class="flex items-center gap-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                        <div id="view_avatar_container" class="relative">
                            <img id="view_avatar" src="" alt="Avatar" class="w-16 h-16 rounded-full object-cover border-2 border-primary-500/20 shadow-md">
                            <div id="view_avatar_placeholder" class="w-16 h-16 rounded-full bg-primary-50 dark:bg-primary-950 text-primary-600 dark:text-primary-400 flex items-center justify-center text-xl font-bold border border-primary-200 dark:border-primary-800">
                                U
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <h4 id="view_name" class="text-base font-extrabold text-gray-900 dark:text-white">-</h4>
                                <span id="view_status_badge" class="px-2 py-0.5 rounded-full text-[10px] font-bold">-</span>
                            </div>
                            <p id="view_username" class="text-xs text-gray-400 font-normal mt-0.5">@username</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span id="view_role_badge" class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-primary-50 text-primary-700 dark:bg-primary-950 dark:text-primary-300">-</span>
                                <span id="view_designation" class="text-xs text-gray-600 dark:text-gray-300 font-medium"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Status</span>
                            <p id="view_status_text" class="font-semibold text-gray-800 dark:text-gray-200 capitalize">-</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Student / Staff ID</span>
                            <p id="view_employee_id" class="font-mono font-semibold text-gray-800 dark:text-gray-200">-</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Email Address</span>
                            <p id="view_email" class="font-semibold text-gray-800 dark:text-gray-200">-</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Phone Number</span>
                            <p id="view_phone" class="font-semibold text-gray-800 dark:text-gray-200">-</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Gender</span>
                            <p id="view_gender" class="font-semibold text-gray-800 dark:text-gray-200">-</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Birthday</span>
                            <p id="view_birthday" class="font-semibold text-gray-800 dark:text-gray-200">-</p>
                        </div>
                    </div>

                    <!-- Address & Bio -->
                    <div class="space-y-3 text-xs">
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Address / Location</span>
                            <p id="view_address" class="text-gray-700 dark:text-gray-300">-</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Bio / Notes</span>
                            <p id="view_bio" class="text-gray-700 dark:text-gray-300">-</p>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-gray-400 pt-2 border-t border-gray-100 dark:border-gray-700">
                            <span>Joined on: <strong id="view_created_at" class="text-gray-600 dark:text-gray-300">-</strong></span>
                            <span>Last Active: <strong id="view_last_seen" class="text-gray-600 dark:text-gray-300">Recently</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2 bg-gray-50/50 dark:bg-gray-800/50">
                    <button type="button" onclick="closeViewUserModal()" class="btn-secondary">Close</button>
                    <button type="button" id="view_edit_button" class="btn-primary">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                        <span>Edit</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end: View User Details Modal-->
@endsection

@push('scripts')
    <script>
        let userTable;

        $(document).ready(function() {
            userTable = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [
                    { data: 'avatar', name: 'avatar', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
                    { data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'created_at', name: 'created_at', searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[5, 'desc']]
            });
        });

        // Live image preview helper
        function previewAvatar(input, previewId, placeholderId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result).removeClass('hidden');
                    $('#' + placeholderId).addClass('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // ==========================================
        // 1. CREATE USER MODAL WORKFLOW
        // ==========================================
        function openCreateUserModal() {
            $('#createUserForm')[0].reset();
            $('#create_avatar_preview').addClass('hidden').removeAttr('src');
            $('#create_avatar_placeholder').removeClass('hidden');
            document.getElementById('create-user-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeCreateUserModal() {
            document.getElementById('create-user-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function submitCreateUser(e) {
            e.preventDefault();
            const form = document.getElementById('createUserForm');
            const formData = new FormData(form);
            const btn = $('#saveCreateUserBtn');

            btn.prop('disabled', true).html('<i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Creating...');

            $.ajax({
                url: "{{ route('users.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-check text-xs"></i> <span>Create</span>');
                    if (res.success) {
                        toastr.success(res.message);
                        closeCreateUserModal();
                        userTable.ajax.reload(null, false);
                    } else {
                        toastr.error(res.message || 'Failed to create user.');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-check text-xs"></i> <span>Create</span>');
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error creating user.';
                    toastr.error(msg);
                }
            });
        }

        // ==========================================
        // 2. EDIT USER MODAL WORKFLOW
        // ==========================================
        function editUser(id) {
            const url = "{{ url('admin/users') }}/" + id + "/edit";
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.success && res.data) {
                        const d = res.data;
                        $('#edit_user_id').val(d.id);
                        $('#edit_first_name').val(d.first_name);
                        $('#edit_last_name').val(d.last_name || '');
                        $('#edit_email').val(d.email);
                        $('#edit_phone').val(d.phone || '');
                        $('#edit_role').val(d.role);
                        $('#edit_designation').val(d.designation || '');
                        $('#edit_employee_id').val(d.employee_id || '');
                        $('#edit_gender').val(d.gender || '');
                        $('#edit_status').val(d.status || 'active');
                        $('#edit_password').val('');
                        $('#edit_address').val(d.address || '');
                        $('#edit_bio').val(d.bio || '');

                        if (d.birthday) {
                            const bday = new Date(d.birthday);
                            if (!isNaN(bday.getTime())) {
                                $('#edit_birthday').val(bday.toISOString().split('T')[0]);
                            }
                        } else {
                            $('#edit_birthday').val('');
                        }

                        // Avatar
                        if (d.avatar) {
                            $('#edit_avatar_preview').attr('src', d.avatar).removeClass('hidden');
                            $('#edit_avatar_placeholder').addClass('hidden');
                        } else {
                            $('#edit_avatar_preview').addClass('hidden').removeAttr('src');
                            $('#edit_avatar_placeholder').removeClass('hidden');
                        }

                        document.getElementById('edit-user-modal').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON ? xhr.responseJSON.message : 'Failed to fetch user details.');
                }
            });
        }

        function closeEditUserModal() {
            document.getElementById('edit-user-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function submitEditUser(e) {
            e.preventDefault();
            const id = $('#edit_user_id').val();
            const form = document.getElementById('editUserForm');
            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            const btn = $('#saveEditUserBtn');
            btn.prop('disabled', true).html('<i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Updating...');

            $.ajax({
                url: "{{ url('admin/users') }}/" + id,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-check text-xs"></i> <span>Update</span>');
                    if (res.success) {
                        toastr.success(res.message);
                        closeEditUserModal();
                        userTable.ajax.reload(null, false);
                    } else {
                        toastr.error(res.message || 'Failed to update user.');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-check text-xs"></i> <span>Update</span>');
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error updating user.';
                    toastr.error(msg);
                }
            });
        }

        // ==========================================
        // 3. VIEW USER DETAILS MODAL WORKFLOW
        // ==========================================
        function viewUserDetails(id) {
            const url = "{{ url('admin/users') }}/" + id;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.success && res.data) {
                        const d = res.data;
                        const fullName = ((d.first_name || '') + ' ' + (d.last_name || '')).trim() || d.username || 'User';

                        $('#view_name').text(fullName);
                        $('#view_username').text('@' + (d.username || 'username'));
                        $('#view_designation').text(d.designation || 'Member');
                        $('#view_status_badge').text(d.status ? (d.status.charAt(0).toUpperCase() + d.status.slice(1)) : 'Active');
                        $('#view_employee_id').text(d.employee_id || 'N/A');
                        $('#view_email').text(d.email || 'N/A');
                        $('#view_phone').text(d.phone || 'N/A');
                        $('#view_gender').text(d.gender ? (d.gender.charAt(0).toUpperCase() + d.gender.slice(1)) : 'N/A');
                        $('#view_address').text(d.address || 'No address registered.');
                        $('#view_bio').text(d.bio || 'No bio provided.');

                        // Formatted Dates
                        if (d.birthday) {
                            const bday = new Date(d.birthday);
                            $('#view_birthday').text(bday.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }));
                        } else {
                            $('#view_birthday').text('N/A');
                        }

                        if (d.created_at) {
                            const joinDate = new Date(d.created_at);
                            $('#view_created_at').text(joinDate.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }));
                        }

                        // Role Badge
                        const role = (d.role || 'employee').toLowerCase();
                        $('#view_role_badge').text(role.charAt(0).toUpperCase() + role.slice(1));

                        // Status Badge & Text
                        const status = (d.status || 'active').toLowerCase();
                        $('#view_status_badge').text(status.charAt(0).toUpperCase() + status.slice(1));
                        $('#view_status_text').text(status.charAt(0).toUpperCase() + status.slice(1));
                        if (status === 'active') {
                            $('#view_status_badge').attr('class', 'px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300');
                        } else {
                            $('#view_status_badge').attr('class', 'px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300');
                        }

                        // Avatar
                        if (d.avatar) {
                            $('#view_avatar').attr('src', d.avatar).removeClass('hidden');
                            $('#view_avatar_placeholder').addClass('hidden');
                        } else {
                            const initial = (d.first_name || 'U').charAt(0).toUpperCase();
                            $('#view_avatar').addClass('hidden').removeAttr('src');
                            $('#view_avatar_placeholder').text(initial).removeClass('hidden');
                        }

                        // Wire "Edit User" button inside View modal
                        $('#view_edit_button').off('click').on('click', function() {
                            closeViewUserModal();
                            editUser(d.id);
                        });

                        document.getElementById('view-user-modal').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON ? xhr.responseJSON.message : 'Failed to fetch user details.');
                }
            });
        }

        function closeViewUserModal() {
            document.getElementById('view-user-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // ==========================================
        // 4. STATUS TOGGLE (SWEETALERT2 - 100% MEETING COMPATIBLE)
        // ==========================================
        function changeStatus(event, id) {
            event.preventDefault();
            Swal.fire({
                title: 'Change status?',
                text: 'Are you sure you want to toggle the status?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('users.status', ':id') }}'.replace(':id', id),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            toastr.success(res.message);
                            $('#users-table').DataTable().ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Failed to update status. Please try again.');
                            $('#users-table').DataTable().ajax.reload(null, false);
                        }
                    });
                } else {
                    // Reload to reset the toggle switch if cancelled
                    $('#users-table').DataTable().ajax.reload(null, false);
                }
            });
        }

        // ==========================================
        // 5. DELETE USER (SWEETALERT2 - 100% MEETING COMPATIBLE)
        // ==========================================
        function deleteRecord(event, id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('users.destroy', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $('#users-table').DataTable().ajax.reload(null, false);
                            } else {
                                toastr.error(response.message || 'Failed to delete user.');
                            }
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Failed to delete user. Please try again.');
                        }
                    });
                }
            });
        }
        window.deleteUser = deleteRecord;

        // Close any open modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCreateUserModal();
                closeEditUserModal();
                closeViewUserModal();
            }
        });
    </script>
@endpush
