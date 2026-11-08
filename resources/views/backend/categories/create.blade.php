@extends('backend.master')

@section('title')
    {{ config('app.name') }} || Create Category
@endsection

@section('content')
    <!--begin: Page Header-->
    <div class="page-header">
        <!--begin: Page Title-->
        <div class="page-title">
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
                <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
                <a href="{{ route('category.index') }}" class="breadcrumb-link">Categories</a>
                <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-active">Create Category</span>
            </nav>
            <p class="page-description">
                Create a new reflection prompt category.
            </p>
        </div>
        <!--end: Page Title-->
        <!--begin: Actions-->
        <div class="page-actions">
            <a href="{{ route('category.index') }}" class="btn-primary">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Back</span>
            </a>
        </div>
        <!--end: Actions-->
    </div>
    <!--end: Page Header-->

    <!--begin: Card-->
    <div class="card">
        <form action="{{ route('category.store') }}" method="POST">
            @csrf
            <!-- begin:form-fields -->
            <div class="grid grid-cols-12 gap-5">
                <!-- begin:name -->
                <div class="col-span-12 flex flex-col gap-1.5">
                    <label for="name" class="form-label">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="form-input @error('name') is-invalid @enderror" placeholder="e.g. Release, Clarity, Healing"
                        required>
                    @error('name')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- end:name -->

                <!-- begin:slug -->
                <div class="col-span-12 flex flex-col gap-1.5">
                    <label for="slug" class="form-label">Slug <span class="text-xs text-gray-400 font-normal">(Auto-generated)</span></label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                        class="form-input bg-gray-50 dark:bg-gray-800/60 text-gray-500 cursor-not-allowed @error('slug') is-invalid @enderror"
                        placeholder="Auto-generated from name" readonly>
                    @error('slug')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- end:slug -->
            </div>
            <!-- end:form-fields -->

            <!-- begin:form-actions -->
            <div class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('category.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Save</span>
                </button>
            </div>
            <!-- end:form-actions -->
        </form>
    </div>
    <!--end: Card-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#name').on('input', function() {
                const slug = $(this).val()
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/[\s-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('#slug').val(slug);
            });
        });
    </script>
@endpush
