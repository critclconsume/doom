<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>FasilitasKota — @yield('title', 'Dinas Pekerjaan Umum')</title>
 @vite(['<resources/css/style.css'])
</head>
<body>

  @include('layouts.navbar')

  <main class="main">
    @yield('content')
  </main>

  @include('layouts.footer')

</body>
</html>
