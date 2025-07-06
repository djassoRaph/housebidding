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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

        <style>
            .gallery-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 16px;
                justify-content: center;
            }

            .gallery-square {
                width: 100%;
                aspect-ratio: 1 / 1;
                overflow: hidden;
                display: block;
                border-radius: 6px;
            }

            .gallery-square img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
                transition: transform 0.3s ease;
            }

            @media (hover: hover) {
                .gallery-square:hover img {
                    transform: scale(1.05);
                    cursor: zoom-in;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="pb-20">
                @yield('content')
                {{ $slot ?? '' }}
            </main>
            <footer class="text-center py-4 text-sm text-gray-600">
            <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const lightbox = GLightbox({
                        selector: '.glightbox',
                        touchNavigation: true,
                        loop: true,
                        closeButton: true, // ✅ force enable
                        openEffect: 'zoom',
                        closeEffect: 'fade',
                        slideEffect: 'slide'
                    });
                });

            </script>

                <a href="{{ url('/mentions-legales') }}" class="underline">Mentions légales</a> |
                <a href="{{ url('/conditions') }}" class="underline">Conditions d'utilisation</a>
                <div>Contact : {{ config('mail.owner_address') }}</div>
            </footer>
        </div>
    </body>
</html>
