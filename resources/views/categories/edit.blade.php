@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Category</h2>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $category->name }}" class="form-control mb-2" required>
        <textarea name="description" class="form-control mb-2">{{ $category->description }}</textarea>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
