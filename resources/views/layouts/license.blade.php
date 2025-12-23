<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>License Status | {{ setting('site_name', config('app.name')) }}</title>

    @if (setting('site_favicon'))
        <link rel="icon" href="{{ Storage::url(setting('site_favicon')) }}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ asset('assets/logo/icon.png') }}" type="image/x-icon">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <link rel="preload" as="style" href="{{ asset('build/assets/app-e1ec02d3.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-e1ec02d3.css') }}" />
    <link rel="modulepreload" href="{{ asset('build/assets/app-37a11075.js') }}" />
    <script type="module" src="{{ asset('build/assets/app-37a11075.js') }}"></script> --}}
</head>

<body class="font-sans antialiased bg-gray-50">
    <div id="app" class="min-h-screen">
        @yield('content')
    </div>

    @yield('scripts')
</body>

</html>
