@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Discover Events</h2>
                <p class="text-gray-500 mt-2 text-lg">Find the best experiences near you.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('events.public') }}" class="bg-white p-6 rounded-2xl shadow-sm mb-10 flex flex-wrap gap-4 items-center border border-gray-100">
            <div class="flex-1 min-w-[300px] relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" placeholder="Search events..." value="{{ request('search') }}"
                       class="w-full pl-11 pr-4 py-3 border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 transition">
            </div>
            
            <div class="min-w-[200px]">
                <select name="category" class="w-full py-3 border-gray-200 rounded-xl focus:ring-purple-500 transition font-medium text-gray-700">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-purple-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-purple-700 transition shadow-lg shadow-purple-100 active:scale-95">
                Filter
            </button>
        </form>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($events as $event)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                
                <div class="relative h-60 overflow-hidden">
                    <img src="{{ $event->image_url }}" 
                         alt="{{ $event->title }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-purple-600 shadow-sm border border-purple-50">
                            {{ $event->category_badge }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-purple-600 transition">
                            <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                        </h3>
                        <div class="text-right">
                            <span class="block text-purple-600 font-black text-xl">
                                {{ $event->price > 0 ? '$' . number_format($event->price, 2) : 'FREE' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-500 space-y-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-500">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($event->start_date)->format('D, M d • H:i') }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="font-medium">{{ $event->place }}</span>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex justify-between text-xs font-bold mb-2">
                            <span class="text-gray-400 uppercase tracking-wider">Availability</span>
                            <span class="{{ $event->capacity < 10 ? 'text-red-500' : 'text-gray-600' }}">
                                {{ $event->capacity }} tickets left
                            </span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-purple-600 h-full rounded-full" style="width: {{ max(10, min(100, ($event->capacity / 100) * 100)) }}%"></div>
                        </div>
                    </div>

                    @auth
                        @if($event->users->contains(auth()->id()))
                            <div class="w-full py-4 rounded-2xl bg-green-50 text-green-600 font-bold border border-green-100 flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i> Already Registered
                            </div>
                        @elseif($event->capacity > 0)
                            <form method="POST" action="{{ route('events.register', $event) }}">
                                @csrf
                                <button class="w-full py-4 rounded-2xl bg-purple-600 text-white font-black hover:bg-purple-700 transition transform active:scale-95 shadow-xl shadow-purple-100 tracking-wide">
                                    REGISTER NOW
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full py-4 rounded-2xl bg-gray-100 text-gray-400 font-bold cursor-not-allowed">
                                SOLD OUT
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block text-center w-full py-4 rounded-2xl bg-gray-900 text-white font-bold hover:bg-black transition shadow-lg shadow-gray-200">
                            LOGIN TO REGISTER
                        </a>
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">No events found matching your criteria.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-16 flex justify-center">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection