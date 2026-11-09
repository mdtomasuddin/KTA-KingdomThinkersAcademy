@extends('backend.master')

@section('title')
    {{ config('app.name') }} || Category Management
@endsection

@section('content')
    <!--begin: Page Header-->
    <div class="page-header">
        <!--begin: Page Title-->
        <div class="page-title">
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
                <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-active">Categories</span>
            </nav>
            <p class="page-description">
                Category Management: View, search, create, and manage all prompt categories with instant modal workflows.
            </p>
        </div>
        <!--end: Page Title-->

        <!--begin: Actions-->
        <div class="page-actions">
            <button type="button" onclick="openCreateCategoryModal()" class="btn-primary">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add Category</span>
            </button>
        </div>
        <!--end: Actions-->
    </div>
    <!--end: Page Header-->

    <!--begin: Table Card-->
    <div class="card p-5">
        <div class="table-responsive">
            <table id="categories-table" class="table-hover w-full text-left text-sm text-gray-600 dark:text-gray-300">
                <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-center w-12">#</th>
                        <th scope="col" class="px-4 py-3">Name</th>
                        <th scope="col" class="px-4 py-3">Slug</th>
                        <th scope="col" class="px-4 py-3 text-center">Status</th>
                        <th scope="col" class="px-4 py-3">Created At</th>
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

    <!--begin: Create Category Modal-->
    <div id="create-category-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/60 transition-opacity" onclick="closeCreateCategoryModal()"></div>

        <!-- Dialog -->
        <div class="relative flex items-center justify-center min-h-screen p-4 pointer-events-none">
            <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden pointer-events-auto">
                <form id="createCategoryForm" onsubmit="submitCreateCategory(event)">
                    @csrf
                    <!-- Header -->
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 dark:bg-primary-950 dark:text-primary-400 flex items-center justify-center">
                                <i class="fa-solid fa-folder-plus text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Add New Category</h3>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Create a new reflection prompt category</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeCreateCategoryModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fa-solid fa-xmark text-base"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                        <!-- Name Field -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="create_name" name="name" required class="form-input text-xs" placeholder="e.g. Release, Clarity, Healing">
                        </div>

                        <!-- Slug Field -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Slug <span class="text-[11px] font-normal text-gray-400">(Auto-generated)</span>
                            </label>
                            <input type="text" id="create_slug" name="slug" class="form-input text-xs bg-gray-50 dark:bg-gray-800/60 text-gray-500 cursor-not-allowed" placeholder="Auto-generated from name" readonly>
                        </div>

                        <!-- Status Field -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="create_status" name="status" required class="form-input text-xs">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2 bg-gray-50/50 dark:bg-gray-800/50">
                        <button type="button" onclick="closeCreateCategoryModal()" class="btn-secondary">Cancel</button>
                        <button type="submit" id="saveCreateCategoryBtn" class="btn-primary">
                            <i class="fa-solid fa-check text-xs"></i>
                            <span>Create</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end: Create Category Modal-->

    <!--begin: Edit Category Modal-->
    <div id="edit-category-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/60 transition-opacity" onclick="closeEditCategoryModal()"></div>

        <!-- Dialog -->
        <div class="relative flex items-center justify-center min-h-screen p-4 pointer-events-none">
            <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden pointer-events-auto">
                <form id="editCategoryForm" onsubmit="submitEditCategory(event)">
                    @csrf
                    <input type="hidden" id="edit_category_id" name="id">

                    <!-- Header -->
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400 flex items-center justify-center">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Category</h3>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Update category name, slug, and status</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeEditCategoryModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fa-solid fa-xmark text-base"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                        <!-- Name Field -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_name" name="name" required class="form-input text-xs">
                        </div>

                        <!-- Slug Field -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Slug <span class="text-[11px] font-normal text-gray-400">(Auto-generated)</span>
                            </label>
                            <input type="text" id="edit_slug" name="slug" class="form-input text-xs bg-gray-50 dark:bg-gray-800/60 text-gray-500 cursor-not-allowed" readonly>
                        </div>

                        <!-- Status Field -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_status" name="status" required class="form-input text-xs">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2 bg-gray-50/50 dark:bg-gray-800/50">
                        <button type="button" onclick="closeEditCategoryModal()" class="btn-secondary">Cancel</button>
                        <button type="submit" id="saveEditCategoryBtn" class="btn-primary">
                            <i class="fa-solid fa-check text-xs"></i>
                            <span>Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end: Edit Category Modal-->

    <!--begin: View Category Details Modal-->
    <div id="view-category-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/60 transition-opacity" onclick="closeViewCategoryModal()"></div>

        <!-- Dialog -->
        <div class="relative flex items-center justify-center min-h-screen p-4 pointer-events-none">
            <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden pointer-events-auto">
                <!-- Header -->
                <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950 dark:text-blue-400 flex items-center justify-center">
                            <i class="fa-solid fa-folder-open text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Category Details</h3>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Comprehensive category information</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeViewCategoryModal()" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                    <!-- Title & Status Header -->
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
                        <div>
                            <h4 id="view_name" class="text-base font-extrabold text-gray-900 dark:text-white">-</h4>
                            <p class="text-xs text-gray-400 font-mono mt-0.5">Slug: <span id="view_slug" class="font-semibold text-gray-700 dark:text-gray-300">-</span></p>
                        </div>
                        <span id="view_status_badge" class="px-2.5 py-0.5 rounded-full text-[11px] font-bold">-</span>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Category ID</span>
                            <p id="view_category_id" class="font-mono font-semibold text-gray-800 dark:text-gray-200">-</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Status</span>
                            <p id="view_status_text" class="font-semibold text-gray-800 dark:text-gray-200 capitalize">-</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Created At</span>
                            <p id="view_created_at" class="font-semibold text-gray-800 dark:text-gray-200">-</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Last Updated</span>
                            <p id="view_updated_at" class="font-semibold text-gray-800 dark:text-gray-200">-</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2 bg-gray-50/50 dark:bg-gray-800/50">
                    <button type="button" onclick="closeViewCategoryModal()" class="btn-secondary">Close</button>
                    <button type="button" id="view_edit_button" class="btn-primary">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                        <span>Edit</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end: View Category Details Modal-->
@endsection

@push('scripts')
    <script>
        let categoryTable;

        $(document).ready(function() {
            categoryTable = $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('category.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'name', name: 'name' },
                    { data: 'slug', name: 'slug' },
                    { data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'created_at', name: 'created_at', searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[4, 'desc']],
                language: {
                    paginate: {
                        previous: '<i class="fa-solid fa-chevron-left"></i>',
                        next: '<i class="fa-solid fa-chevron-right"></i>'
                    }
                }
            });

            // Auto slug generation for Create Modal
            $('#create_name').on('input', function() {
                const slug = $(this).val()
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/[\s-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('#create_slug').val(slug);
            });

            // Auto slug generation for Edit Modal
            $('#edit_name').on('input', function() {
                const slug = $(this).val()
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/[\s-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('#edit_slug').val(slug);
            });
        });

        // ==========================================
        // 1. CREATE CATEGORY MODAL WORKFLOW
        // ==========================================
        function openCreateCategoryModal() {
            $('#createCategoryForm')[0].reset();
            $('#create_slug').val('');
            $('#create_status').val('active');
            document.getElementById('create-category-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeCreateCategoryModal() {
            document.getElementById('create-category-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function submitCreateCategory(e) {
            e.preventDefault();
            const form = document.getElementById('createCategoryForm');
            const formData = new FormData(form);
            const btn = $('#saveCreateCategoryBtn');

            btn.prop('disabled', true).html('<i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Creating...');

            $.ajax({
                url: "{{ route('category.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-check text-xs"></i> <span>Create</span>');
                    if (res.success) {
                        toastr.success(res.message);
                        closeCreateCategoryModal();
                        categoryTable.ajax.reload(null, false);
                    } else {
                        toastr.error(res.message || 'Failed to create category.');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-check text-xs"></i> <span>Create</span>');
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error creating category.';
                    toastr.error(msg);
                }
            });
        }

        // ==========================================
        // 2. EDIT CATEGORY MODAL WORKFLOW
        // ==========================================
        function editCategory(id) {
            const url = "{{ route('category.edit', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.success && res.data) {
                        const d = res.data;
                        $('#edit_category_id').val(d.id);
                        $('#edit_name').val(d.name || '');
                        $('#edit_slug').val(d.slug || '');
                        $('#edit_status').val(d.status || 'active');

                        document.getElementById('edit-category-modal').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON ? xhr.responseJSON.message : 'Failed to fetch category details.');
                }
            });
        }

        function closeEditCategoryModal() {
            document.getElementById('edit-category-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function submitEditCategory(e) {
            e.preventDefault();
            const id = $('#edit_category_id').val();
            const form = document.getElementById('editCategoryForm');
            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            const btn = $('#saveEditCategoryBtn');
            btn.prop('disabled', true).html('<i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Updating...');

            const updateUrl = "{{ route('category.update', ':id') }}".replace(':id', id);

            $.ajax({
                url: updateUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-check text-xs"></i> <span>Update</span>');
                    if (res.success) {
                        toastr.success(res.message);
                        closeEditCategoryModal();
                        categoryTable.ajax.reload(null, false);
                    } else {
                        toastr.error(res.message || 'Failed to update category.');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-check text-xs"></i> <span>Update</span>');
                    const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error updating category.';
                    toastr.error(msg);
                }
            });
        }

        // ==========================================
        // 3. VIEW CATEGORY DETAILS MODAL WORKFLOW
        // ==========================================
        function viewCategoryDetails(id) {
            const url = "{{ route('category.show', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.success && res.data) {
                        const d = res.data;

                        $('#view_category_id').text('#' + d.id);
                        $('#view_name').text(d.name || '-');
                        $('#view_slug').text(d.slug || '-');

                        // Status Badge
                        const status = (d.status || 'active').toLowerCase();
                        $('#view_status_text').text(status.charAt(0).toUpperCase() + status.slice(1));
                        if (status === 'active') {
                            $('#view_status_badge').text('Active')
                                .attr('class', 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300');
                        } else {
                            $('#view_status_badge').text('Inactive')
                                .attr('class', 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300');
                        }

                        // Dates
                        if (d.created_at) {
                            const cDate = new Date(d.created_at);
                            $('#view_created_at').text(cDate.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }));
                        } else {
                            $('#view_created_at').text('N/A');
                        }

                        if (d.updated_at) {
                            const uDate = new Date(d.updated_at);
                            $('#view_updated_at').text(uDate.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }));
                        } else {
                            $('#view_updated_at').text('N/A');
                        }

                        // Wire "Edit" button inside View modal
                        $('#view_edit_button').off('click').on('click', function() {
                            closeViewCategoryModal();
                            editCategory(d.id);
                        });

                        document.getElementById('view-category-modal').classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON ? xhr.responseJSON.message : 'Failed to fetch category details.');
                }
            });
        }

        function closeViewCategoryModal() {
            document.getElementById('view-category-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // ==========================================
        // 4. STATUS TOGGLE (SWEETALERT2)
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
                        url: '{{ route('category.status', ':id') }}'.replace(':id', id),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            toastr.success(res.message);
                            categoryTable.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Failed to update status. Please try again.');
                            categoryTable.ajax.reload(null, false);
                        }
                    });
                } else {
                    categoryTable.ajax.reload(null, false);
                }
            });
        }

        // ==========================================
        // 5. DELETE CATEGORY (SWEETALERT2)
        // ==========================================
        function deleteRecord(event, id) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'This category will be permanently deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('category.destroy', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                categoryTable.ajax.reload(null, false);
                            } else {
                                toastr.error(response.message || 'Failed to delete category.');
                            }
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Failed to delete category. Please try again.');
                        }
                    });
                }
            });
        }

        // Close any open modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCreateCategoryModal();
                closeEditCategoryModal();
                closeViewCategoryModal();
            }
        });
    </script>
@endpush
