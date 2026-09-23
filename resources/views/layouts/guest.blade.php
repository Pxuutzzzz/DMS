<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Single Sign-On - Universitas 'Aisyiyah Yogyakarta</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                background-color: #F4F6F8;
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">
        
        <div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-lg border border-gray-200 p-6 sm:p-8">
            {{ $slot }}
        </div>

    </body>
</html>
