@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8">My Registrations</h2>

        <div class="grid gap-6">
            @forelse($registrations as $reg)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <img src="{{ Str::startsWith($reg->event->image, 'http') ? $reg->event->image : asset('storage/' . $reg->event->image) }}" 
                             class="w-24 h-24 rounded-xl object-cover border border-gray-100">
                        
                        <div>
                            <span class="text-xs font-bold text-purple-600 uppercase tracking-widest">{{ $reg->event->category->name }}</span>
                            <h3 class="text-xl font-bold text-gray-900">{{ $reg->event->title }}</h3>
                            <p class="text-sm text-gray-500">
                                <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($reg->event->start_date)->format('M d, Y • H:i') }}
                            </p>
                            <p class="text-sm text-gray-500 italic">Registered on {{ $reg->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <a href="{{ route('events.show', $reg->event) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-bold text-center hover:bg-gray-200">View Event</a>
                        
                        <form action="{{ route('events.cancel', $reg->event) }}" method="POST" onsubmit="return confirm('Cancel registration?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-600 hover:text-white transition">
                                Cancel Ticket
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100">
                    <p class="text-gray-400">You haven't registered for any events yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection