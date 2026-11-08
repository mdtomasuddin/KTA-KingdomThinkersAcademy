@extends('frontend.dynamicPage.layout')

@section('title', ($title ?? 'Document') . ' - ' . ($appName ?? config('app.name', 'Dashboard')))

@section('content')
<article class="legal-card">
    <header class="page-header">
        <div class="badge-wrapper">
            <span class="type-badge">
                Official Document
            </span>
            @if(!empty($updatedAt))
            <span class="updated-badge">
                Last Updated: {{ $updatedAt }}
            </span>
            @endif
        </div>
        <h1 class="page-title">{{ $title ?? 'Document' }}</h1>
        <p class="app-subtext">Official published document for <strong>{{ $appName ?? config('app.name', 'Dashboard') }}</strong>.</p>
    </header>

    <div class="legal-content">
        {!! $body !!}
    </div>

    @php
        $supportEmail = 'support@' . strtolower(str_replace([' ', '-'], '', $appName ?? config('app.name', 'Dashboard'))) . '.com';
    @endphp

    <div class="support-box">
        <h4>Need Help or Have Questions?</h4>
        <p>If you have any questions regarding this document or wish to exercise your data privacy rights, please contact our support team at <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>.</p>
    </div>
</article>
@endsection
