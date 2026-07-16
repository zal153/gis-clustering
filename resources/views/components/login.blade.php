<!DOCTYPE html>
<html lang="id" class="scroll-smooth group" data-layout="modern" data-content-width="fluid" data-bs-theme="light"
    data-sidebar-colors="light" data-sidebar="large" data-nav-type="default" dir="ltr" data-colors="default"
    data-profile-sidebar>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'GIS Pemetaan PKH Desa Campor Barat' }} | {{ $page ?? 'SIG Pemetaan PKH Desa Campor Barat' }}</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/favicon-B-3ALmIB.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/bootstrap.rtl-B-QkKLS3.css') }}" rel="stylesheet" type="text/css" disabled>
    <!-- App CSS -->
    <link href="{{ asset('assets/app.rtl-Jqq4Msv0.css') }}" rel="stylesheet" type="text/css" disabled>
    <!-- Admin Bundle JS & CSS -->
    <script type="module" crossorigin src="{{ asset('assets/admin.bundle-CBXoUBAg.js') }}"></script>
    <link rel="stylesheet" crossorigin href="{{ asset('assets/admin-Bly6avC4.css') }}">
</head>

<body class="sidebar-hidden">

    {{ $slot }}

</body>

</html>
