<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ $theme ?? 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Builder360 ERP CRM')</title>

    @vite(['resources/css/enterprise.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body
    class="b360-classic"
    x-data="builderShell"
    x-bind:class="navigationClasses"
    x-on:keydown.escape.window="handleEscape"
    x-on:resize.window="handleResize"
>
    @include('partials.brij-loader')
    <div class="b360-shell">
        @include('builder360.classic.partials.sidebar', ['shell' => $shell])
        <button type="button" class="b360-nav-backdrop" x-on:click="closeNavigation" aria-label="Close navigation" tabindex="-1"></button>

        <div class="b360-main">
            @include('builder360.classic.partials.topbar', ['shell' => $shell])

            <main class="b360-content">
                @include('builder360.classic.partials.flash')
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
