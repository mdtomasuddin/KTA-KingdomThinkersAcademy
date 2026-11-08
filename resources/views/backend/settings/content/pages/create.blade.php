@extends('backend.master')

@section('title')
    {{ config('app.name') }} || Create Page
@endsection

@section('content')
    <!--begin: Page Header-->
    <div class="page-header">
        <!--begin: Page Title-->
        <div class="page-title">
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
                <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
                <a href="{{ route('pages.index') }}" class="breadcrumb-link">Dynamic Pages</a>
                <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-active">Create Page</span>
            </nav>
            <p class="page-description">
                Create a new dynamic page by filling out the details below.
            </p>
        </div>
        <!--end: Page Title-->
        <!--begin: Actions-->
        <div class="page-actions">
            <a href="{{ route('pages.index') }}" class="btn-primary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Pages</span>
            </a>
        </div>
        <!--end: Actions-->
    </div>
    <!--end: Page Header-->

    <!--begin: Card-->
    <div class="card">
        <form action="{{ route('pages.store') }}" method="POST">
            @csrf
            <!-- begin:form-fields -->
            <div class="grid grid-cols-12 gap-5">
                <!-- begin:title -->
                <div class="col-span-12 md:col-span-6 flex flex-col gap-1.5">
                    <label for="title" class="form-label"> Title <span class="text-red-500">*</span> </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="form-input @error('title') is-invalid @enderror" placeholder="Enter page title" required>
                    @error('title')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- end:title -->

                <!-- begin:slug -->
                <div class="col-span-12 md:col-span-6 flex flex-col gap-1.5">
                    <label for="slug" class="form-label"> Slug </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                        class="form-input bg-gray-100 dark:bg-gray-800/50 cursor-not-allowed @error('slug') is-invalid @enderror"
                        placeholder="Auto-generated from title" readonly>
                    @error('slug')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- end:slug -->

                <!-- begin:content -->
                <div class="col-span-12 flex flex-col gap-1.5">
                    <label for="summernote" class="form-label"> Content <span class="text-red-500">*</span> </label>
                    <textarea class="form-input @error('content') is-invalid @enderror" id="summernote" name="content"
                        placeholder="Enter page content...">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- end:content -->
            </div>
            <!-- end:form-fields -->

            <!--begin: Form Actions-->
            <div class="form-actions mt-6">
                <a href="{{ route('pages.index') }}" class="btn-cancel"> Cancel </a>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk text-xs"></i> <span>Create</span>
                </button>
            </div>
            <!--end: Form Actions-->
        </form>
    </div>
    <!--end: Card-->

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    height: 350
                });

                // Slugify helper
                function slugify(text) {
                    return text.toString().toLowerCase().trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                }

                // Slug updates automatically depending on title
                $('#title').on('keyup input change', function() {
                    $('#slug').val(slugify($(this).val()));
                });
            });
        </script>
    @endpush
@endsection
