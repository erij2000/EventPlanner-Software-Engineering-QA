@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">My Dashboard</h1>

<a href="{{ route('my.registrations') }}" class="text-purple-600 underline">
    My registrations
</a>
@endsection
