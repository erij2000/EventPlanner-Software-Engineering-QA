@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Registrations</h2>

    <ul class="list-group">
        @foreach($registrations as $event)
            <li class="list-group-item">
                {{ $event->title }} - {{ $event->start_date }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
