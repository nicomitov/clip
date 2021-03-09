<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="login-page">
    @include('layouts._nav')

    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-12 ml-sm-auto px-4 mt-md-5">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
