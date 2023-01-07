<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tweety') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen content">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->

            <main class="container mt-5">

                <div class="row">

                    <div class="col-lg-2">
                    @if(Request::path() !== 'profile')
                        @include('inc.left-side-bar')
                    @endif
                    </div>

                        {{ $slot }}

                    <div class="col-lg-3">
                    @if(Request::path() !== 'profile')
                        @include('inc.right-side-bar')
                    @endif
                    </div>

                </div>

            </main>
        </div>
    </body>
</html>
