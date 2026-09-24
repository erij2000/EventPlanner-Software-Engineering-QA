<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-black tracking-tighter flex items-center group">
                    <span class="text-purple-600 group-hover:text-purple-700 transition">Event</span>
                    <span class="text-gray-900">Planner</span>
                </a>

                <div class="hidden space-x-6 sm:-my-px sm:ml-12 sm:flex">
                    <x-nav-link :href="route('events.public')" :active="request()->routeIs('events.public')" class="text-gray-600 hover:text-purple-600 font-medium transition">
                        Explore Events
                    </x-nav-link>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-gray-600 hover:text-purple-600 font-medium">
                                <i class="fas fa-chart-line mr-2 text-xs"></i>Admin Dashboard
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('my.registrations')" :active="request()->routeIs('my.registrations')" class="text-gray-600 hover:text-purple-600 font-medium">
                                <i class="fas fa-ticket-alt mr-2 text-xs"></i>My Tickets
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-semibold text-gray-700 bg-gray-50 px-4 py-2 rounded-xl hover:bg-gray-100 transition border border-gray-100">
                                <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-2">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                {{ Auth::user()->name }}
                                <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-purple-50 hover:text-purple-700">
                                <i class="far fa-user-circle mr-2"></i>Profile Settings
                            </x-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Sign Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-600 font-bold px-4">Login</a>
                    <a href="{{ route('register') }}" class="bg-purple-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-purple-700 shadow-lg shadow-purple-100 transition transform active:scale-95">
                        Get Started
                    </a>
                @endauth
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-purple-600 hover:bg-purple-50 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-50 border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('events.public')" :active="request()->routeIs('events.public')">
                Explore Events
            </x-responsive-nav-link>
        </div>
        
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4 py-2 bg-white">
                    <div class="font-bold text-base text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if(auth()->user()->role === 'admin')
                        <x-responsive-nav-link :href="route('admin.dashboard')">Admin Dashboard</x-responsive-nav-link>
                    @else
                        <x-responsive-nav-link :href="route('my.registrations')">My Tickets</x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                            Sign Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-4 border-t border-gray-200 px-4 space-y-2">
                <a href="{{ route('login') }}" class="block w-full text-center py-2 text-gray-600 font-bold">Login</a>
                <a href="{{ route('register') }}" class="block w-full text-center py-3 bg-purple-600 text-white rounded-xl font-bold">Get Started</a>
            </div>
        @endauth
    </div>
</nav>