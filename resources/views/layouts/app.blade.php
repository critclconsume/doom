<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'FasilitasKota - Dinas Pekerjaan Umum')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Admin CSS (only loaded on admin pages later) -->
    @if(request()->is('admin/*'))
        <link rel="stylesheet" href="{{ asset('resources/css/admin.css') }}">
    @endif

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/css/style.css'])
</head>
<body>

    @include('layouts.navbar')

    <main class="main">
        @yield('content')
    </main>

</body>
</html>