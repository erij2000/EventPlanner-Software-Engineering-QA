@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid md:grid-cols-3 gap-6">
        <a href="{{ route('admin.events.index') }}"
           class="bg-white shadow p-6 rounded hover:shadow-lg">
            📅 Manage Events
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="bg-white shadow p-6 rounded hover:shadow-lg">
            🗂 Manage Categories
        </a>

        <a href="{{ route('admin.registrations') }}"
           class="bg-white shadow p-6 rounded hover:shadow-lg">
            👥 All Registrations
        </a>
    </div>
</div>
@endsection
