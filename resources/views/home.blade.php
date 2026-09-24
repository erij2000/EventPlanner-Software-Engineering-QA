@extends('layouts.app')

@section('content')
<section class="grid md:grid-cols-2 gap-10 items-center mt-10 px-4 md:px-10">
    <!-- Texte -->
    <div>
        <h1 class="text-4xl font-bold mb-4">
            Plan & Discover <span class="text-purple-600">Amazing Events</span>
        </h1>

        <p class="text-gray-600 mb-6">
            Discover public events, reserve your seat and manage your events easily.
        </p>

        <a href="{{ route('events.public') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded text-lg transition">
            Explore Events
        </a>
    </div>

    <!-- Image -->
    <div class="flex justify-center md:justify-end">
        <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1"
             class="rounded-lg shadow-lg w-full md:w-4/5"
             alt="event">
    </div>
</section>
@endsection
