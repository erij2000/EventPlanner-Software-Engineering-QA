@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ isset($event) ? 'Edit Event' : 'Create New Event' }}</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ isset($event) ? route('admin.events.update', $event) : route('admin.events.store') }}">
                        @csrf
                        @if(isset($event)) @method('PUT') @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Event Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $event->title ?? old('title') }}" placeholder="e.g. Summer Music Festival" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ $event->description ?? old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Start Date</label>
                                <input type="datetime-local" name="start_date" class="form-control" 
                                       value="{{ isset($event) ? \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') : old('start_date') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">End Date</label>
                                <input type="datetime-local" name="end_date" class="form-control" 
                                       value="{{ isset($event) ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') : old('end_date') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Location / Place</label>
                                <input type="text" name="place" class="form-control" value="{{ $event->place ?? old('place') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Choose...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (isset($event) && $event->category_id == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Max Capacity</label>
                                <input type="number" name="capacity" class="form-control" value="{{ $event->capacity ?? old('capacity') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="{{ $event->price ?? old('price') }}" placeholder="0.00 for free">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary btn-lg shadow-sm">
                                {{ isset($event) ? 'Update Event' : 'Publish Event' }}
                            </button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-link text-muted">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection