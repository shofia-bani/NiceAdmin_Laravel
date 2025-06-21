<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <link href="{{ asset('niceadmin-assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('niceadmin-assets/css/style.css') }}" rel="stylesheet">
    </head>

    <body>
        @include('layouts.header')
        @include('layouts.sidebar')
        <main id="main" class="main">
            @yield('content')
        </main>
        <script src="{{ asset('niceadmin-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('niceadmin-assets/js/main.js') }}"></script>
    </body>
</html>