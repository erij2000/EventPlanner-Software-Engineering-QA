@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('events.public') }}" class="text-purple-600 hover:text-purple-800 font-medium flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Events
            </a>
        </div>

        <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
            <div class="relative h-96 w-full">
                <img src="{{ $event->image ?? 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=80' }}" 
                     alt="{{ $event->title }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-8 left-8">
                    <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">
                        {{ $event->category->name }}
                    </span>
                    <h1 class="text-4xl font-extrabold text-white">{{ $event->title }}</h1>
                </div>
            </div>

            <div class="p-8 lg:p-12">
                <div class="grid lg:grid-cols-3 gap-12">
                    
                    <div class="lg:col-span-2">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">About this event</h3>
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line text-lg mb-8">
                            {{ $event->description }}
                        </p>

                        <div class="border-t border-gray-100 pt-8">
                            <h4 class="text-lg font-bold text-gray-900 mb-6">Event Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                                <div class="flex items-start gap-4">
                                    <div class="bg-purple-100 p-3 rounded-lg text-purple-600">
                                        <i class="far fa-calendar-alt fa-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-500 uppercase">Date and Time</p>
                                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}</p>
                                        <p class="text-gray-600 text-sm">{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="bg-blue-100 p-3 rounded-lg text-blue-600">
                                        <i class="fas fa-map-marker-alt fa-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-500 uppercase">Location</p>
                                        <p class="text-gray-900">{{ $event->place }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 sticky top-8">
                            <div class="mb-6">
                                <p class="text-gray-500 text-sm font-medium">Ticket Price</p>
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free' }}
                                </p>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Remaining Slots:</span>
                                    <span class="font-bold text-gray-900">{{ $event->capacity }} tickets</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php $percent = ($event->capacity / 100) * 100; // Replace with actual total if available @endphp
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: 70%"></div>
                                </div>
                            </div>

                            @auth
                                @if(!$event->users->contains(auth()->id()) && $event->capacity > 0)
                                    <form method="POST" action="{{ route('events.register', $event) }}">
                                        @csrf
                                        <button type="submit" class="w-full bg-purple-600 text-white font-bold py-4 rounded-xl hover:bg-purple-700 transition shadow-lg shadow-purple-200">
                                            Register for this event
                                        </button>
                                    </form>
                                @elseif($event->users->contains(auth()->id()))
                                    <div class="bg-green-100 text-green-700 p-4 rounded-xl text-center font-bold">
                                        <i class="fas fa-check-circle mr-2"></i> Already Registered
                                    </div>
                                @else
                                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-center font-bold">
                                        Sold Out
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-center bg-gray-900 text-white font-bold py-4 rounded-xl hover:bg-black transition">
                                    Login to Register
                                </a>
                            @endauth

                            <p class="text-center text-xs text-gray-400 mt-4 italic">
                                Secure registration via our platform
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection