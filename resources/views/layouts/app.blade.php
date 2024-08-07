<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- <title>{{ __('AppName') }}</title> --}}

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500&family=Courgette&family=M+PLUS+Rounded+1c:wght@300;400;500&family=Zen+Kurenaido&family=Zen+Maru+Gothic:wght@300;400;500&display=swap"
        rel="stylesheet">

    <link rel="apple-touch-icon" type="image/png" href="{{ asset('/image/icons8-peace-pigeon-50.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/image/icons8-peace-pigeon-50.png') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .Courgette {
            font-family: 'Courgette', cursive;
        }

        .ZenMaruGothic {
            font-family: 'Zen Maru Gothic', sans-serif;
        }

        .ZenKurenaido {
            font-family: 'Zen Kurenaido', sans-serif;
        }
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        @include('layouts.navigation')

        <!-- Page Heading -->
        {{-- <header class="bg-gray-50 shadow">
                <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header> --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
