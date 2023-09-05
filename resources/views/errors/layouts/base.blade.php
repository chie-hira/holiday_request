<!DOCTYPE html>
<html lang="ja">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500&family=M+PLUS+Rounded+1c:wght@300;400;500&family=Zen+Kurenaido&family=Zen+Maru+Gothic:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .ZenMaruGothic {
            font-family: 'Zen Maru Gothic', sans-serif;
        }

        .ZenKurenaido {
            font-family: 'Zen Kurenaido', sans-serif;
        }
    </style>
</head>

<body>
    <section class="bg-white dark:bg-gray-900 ">
    <div class="container flex items-center min-h-screen px-6 py-12 mx-auto">
        <div>
            <p class="text-sm font-medium text-blue-500">@yield('title')</p>
            <h1 class="mt-3 text-2xl font-semibold text-gray-800 md:text-3xl">@yield('message')</h1>
            <p class="mt-4 text-gray-500 ">@yield('detail')</p>

            <div class="flex items-center mt-6 gap-x-3">
                <button class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                    @yield('link')
                </button>
            </div>
        </div>
    </div>
</section>
</body>

</html>
