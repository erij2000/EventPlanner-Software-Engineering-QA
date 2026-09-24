@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6">
        
        <div class="mb-10 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black text-gray-900 uppercase">My Tickets</h2>
                <p class="text-gray-500">Manage your upcoming event experiences.</p>
            </div>
            <a href="{{ route('events.public') }}" class="bg-white border border-gray-200 px-6 py-2 rounded-xl text-sm font-bold text-purple-600 hover:bg-purple-50 transition">
                Find More Events
            </a>
        </div>

        <div class="space-y-6">
            @forelse($registrations as $reg)
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row group transition-all hover:shadow-md">
                    
                    <div class="md:w-64 h-48 md:h-auto shrink-0 relative">
                        <img src="{{ $reg->event->image_url }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-purple-600 text-white text-[10px] font-black px-3 py-1 rounded-lg uppercase">
                                {{ $reg->event->category->name }}
                            </span>
                        </div>
                    </div>

                    <div class="flex-1 p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-purple-600 transition">{{ $reg->event->title }}</h3>
                                <span class="bg-green-100 text-green-700 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-tighter">Confirmed</span>
                            </div>
                            
                            <div class="mt-4 space-y-2 text-gray-500">
                                <p class="flex items-center text-sm">
                                    <i class="far fa-calendar-alt w-6 text-purple-500"></i> 
                                    {{ \Carbon\Carbon::parse($reg->event->start_date)->format('D, M d • H:i') }}
                                </p>
                                <p class="flex items-center text-sm">
                                    <i class="fas fa-map-marker-alt w-6 text-purple-500"></i> 
                                    {{ $reg->event->place }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-dashed border-gray-100 flex justify-between items-center">
                            <span class="text-[10px] font-mono text-gray-400">TICKET REF: #{{ $reg->id }}</span>
                            
                            <div class="flex gap-4 items-center">
                                <a href="{{ route('events.show', $reg->event) }}" class="text-sm font-bold text-gray-600 hover:text-purple-600">Info</a>
                                
                                <form action="{{ route('events.cancel', $reg->event) }}" method="POST" onsubmit="return confirm('Cancel this registration?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 text-red-600 px-4 py-2 rounded-xl text-xs font-black hover:bg-red-600 hover:text-white transition uppercase">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-24 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                    <i class="fas fa-ticket-alt text-5xl text-gray-200 mb-6"></i>
                    <p class="text-gray-400 text-lg mb-8">You have no active tickets.</p>
                    <a href="{{ route('events.public') }}" class="bg-purple-600 text-white px-10 py-4 rounded-2xl font-black shadow-lg shadow-purple-100">EXPLORE EVENTS</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection