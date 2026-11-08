@extends('backend.master')

@section('title')
    {{ config('app.name', 'Dashboard') }} || Dashboard
@endsection

@section('content')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                Dashboard
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Welcome to Kingdom Thinkers Academy Admin Dashboard.
            </p>
        </div>
    </div>
@endsection
