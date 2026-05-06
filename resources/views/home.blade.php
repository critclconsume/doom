<?php
// Router — read ?page= param, default to beranda
$allowed_pages = ['beranda', 'proyek', 'lapor', 'panduan'];
$page = isset($_GET['page']) && in_array($_GET['page'], $allowed_pages)
    ? $_GET['page']
    : 'beranda';
?>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FasilitasKota — Dinas Pekerjaan Umum</title>
    @vite(['resources/css/style.css'])
</head>
<body>

    @include('layouts.navbar')

    <main class="main">
        @yield('content') 
    </main>

    @include('layouts.footer')

</body>
</html>
