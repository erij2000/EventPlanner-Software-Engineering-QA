<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EventPlanner</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <!-- NAVBAR -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-purple-600 hover:text-purple-700 transition">
                EventPlanner
            </a>

            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="hover:text-purple-600 transition">Home</a>
                <a href="{{ route('events.public') }}" class="hover:text-purple-600 transition">Next Public Events</a>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="font-semibold hover:text-purple-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('my.registrations') }}" class="font-semibold hover:text-purple-600 transition">Mes inscriptions</a>
                    @endif

                    <!-- Dropdown user -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="ml-4 px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 transition">
                            {{ Auth::user()->name }}
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded border">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hover:text-purple-600 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-6 py-6 text-center text-sm">
            © {{ date('Y') }} EventPlanner – All rights reserved
        </div>
    </footer>

</body>
</html>
