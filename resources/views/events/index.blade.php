@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Manage Events</h2>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary px-4 shadow-sm">
            <i class="fas fa-plus"></i> Add New Event
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Capacity</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $event->title }}</td>
                        <td><span class="badge bg-info text-dark">{{ $event->category->name }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</td>
                        <td>{{ $event->capacity }} spots</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-outline-warning btn-sm mx-1">Edit</a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection