<!DOCTYPE html>
<html lang="en" class="scroll-smooth group" data-layout="modern" data-content-width="fluid" data-bs-theme="light"
    data-sidebar-colors="light" data-sidebar="large" data-nav-type="default" dir="ltr" data-colors="default"
    data-profile-sidebar>

<head>
    <script>
        sessionStorage.setItem('data-layout', 'modern');
    </script>
    <!-- Basic Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Informasi Geografis Pemetaan PKH Desa Campor Barat</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="SIG Pemetaan PKH Desa Campor Barat">
    <meta name="description" content="Sistem Informasi Geografis Pemetaan Penerima PKH Desa Campor Barat Menggunakan Metode K-Means Clustering.">
    <meta name="author" content="SIG Pemetaan PKH">
    <meta name="robots" content="index, follow">

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/favicon-B-3ALmIB.ico') }}">

    <!-- CSS Assets -->
    <link href="{{ asset('assets/bootstrap.rtl-B-QkKLS3.css') }}" rel="stylesheet" type="text/css" disabled>
    <link href="{{ asset('assets/app.rtl-Jqq4Msv0.css') }}" rel="stylesheet" type="text/css" disabled>

    <!-- JS Assets -->
    <script type="module" crossorigin src="{{ asset('assets/src/index-DUABbF3Z.js') }}"></script>
    <link rel="modulepreload" crossorigin href="{{ asset('assets/admin.bundle-CBXoUBAg.js') }}">
    <link rel="modulepreload" crossorigin href="{{ asset('assets/swiper-bundle-DukfsYTx.js') }}">
    <link rel="modulepreload" crossorigin href="{{ asset('assets/main-B7Jkv9i9.js') }}">
    <link rel="modulepreload" crossorigin href="{{ asset('assets/progress-circle.init-4QKN7iib.js') }}">
    <link rel="modulepreload" crossorigin href="{{ asset('assets/apexcharts.esm-UDOVVTaL.js') }}">

    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin-Bly6avC4.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/swiper-bundle-PpNm7Js3.css') }}">

    @stack("style")
</head>

<body class="sidebar-hidden">
    <x-header></x-header>

    <x-sidebar></x-sidebar>
    <div id="sidebar-backdrop" class="sidebar-backdrop"></div>

    <div class="min-vh-100 position-relative">
        {{ $slot }}
    </div>

    <!-- Script Footer -->
    <script src="{{ asset('assets/libs/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dayjs/plugin/quarterOfYear.js') }}"></script>

    @stack("script")
</body>

</html>
