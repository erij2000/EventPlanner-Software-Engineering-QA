@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Category</h2>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf

        <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
        <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
