<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EventPlanner') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        {{-- Bootstrap 5 for Admin/Forms --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        {{-- Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            :root {
                --primary-purple: #7c3aed; /* EventPlanner Purple */
            }
            body { 
                background-color: #f9fafb; 
                font-family: 'Figtree', sans-serif;
            }
            /* Custom styles to match Figma */
            .btn-primary { background-color: var(--primary-purple); border-color: var(--primary-purple); }
            .btn-primary:hover { background-color: #6d28d9; border-color: #6d28d9; }
            .text-purple { color: var(--primary-purple); }
            .card { border-radius: 1rem; border: none; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
            .form-control, .form-select { border-radius: 0.5rem; padding: 0.6rem 1rem; border: 1px solid #e5e7eb; }
            .nav-link-custom { font-weight: 500; color: #4b5563; transition: color 0.2s; }
            .nav-link-custom:hover { color: var(--primary-purple); }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endisset

            <main>
                @yield('content')
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>