<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body.auth-page {
                margin: 0;
                padding: 0;
                min-height: 100vh;
                background: #FAF7F2;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        </style>
    </head>
    <body class="font-sans antialiased auth-page">
        {{ $slot }}
    </body>
</html>