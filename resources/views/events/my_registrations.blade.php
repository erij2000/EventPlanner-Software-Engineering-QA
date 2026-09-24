@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6">
        
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight">My Passport</h2>
            <p class="text-gray-500">All your upcoming experiences in one place.</p>
        </div>

        <div class="space-y-8">
            @forelse($registrations as $event)
                <div class="relative bg-white rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row overflow-hidden group hover:shadow-xl transition-all duration-300">
                    
                    <div class="md:w-72 h-48 md:h-auto relative shrink-0">
                        <img src="{{ $event->image_url }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white px-3 py-1 rounded-lg text-[10px] font-black text-purple-600 uppercase">
                                {{ $event->category_badge }}
                            </span>
                        </div>
                    </div>

                    <div class="flex-1 p-8 relative">
                        <div class="hidden md:block absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-12 bg-gray-50 rounded-full border border-gray-100"></div>
                        
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                                <div class="space-y-2">
                                    <p class="flex items-center text-gray-500 text-sm">
                                        <i class="far fa-calendar-alt w-6 text-purple-500"></i>
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y') }}
                                    </p>
                                    <p class="flex items-center text-gray-500 text-sm">
                                        <i class="fas fa-map-marker-alt w-6 text-purple-500"></i>
                                        {{ $event->place }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Status</div>
                                <span class="bg-green-100 text-green-700 text-[10px] px-3 py-1 rounded-full font-bold uppercase">
                                    Confirmed
                                </span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-dashed border-gray-100 flex justify-between items-center">
                            <div class="flex items-center">
                                <i class="fas fa-qrcode text-3xl text-gray-300 mr-4"></i>
                                <span class="text-[10px] font-mono text-gray-400 uppercase">Ticket ID: #EV-{{ $event->id }}{{ auth()->id() }}</span>
                            </div>
                            <a href="{{ route('events.show', $event) }}" class="bg-gray-900 text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-purple-600 transition">
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-gray-200">
                    <i class="fas fa-ticket-alt text-5xl text-gray-200 mb-6"></i>
                    <h3 class="text-xl font-bold text-gray-900">No Tickets Found</h3>
                    <p class="text-gray-500 mb-8">You haven't registered for any events yet.</p>
                    <a href="{{ route('events.public') }}" class="bg-purple-600 text-white px-10 py-4 rounded-2xl font-black shadow-lg shadow-purple-100 hover:bg-purple-700 transition">
                        EXPLORE EVENTS
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection