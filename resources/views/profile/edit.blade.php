@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profile</h2>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        <label>Name</label>
        <input type="text" name="name" value="{{ $user->name }}">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}">
        <button type="submit">Update</button>
    </form>
</div>
@endsection
