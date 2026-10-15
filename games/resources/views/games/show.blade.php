@extends('base')

@section('title', '🎮 Game Details')

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>{{ $game->game_name }}</h3>
            <p><strong>Platform:</strong> {{ $game->platform }}</p>
            <p><strong>Genre:</strong> {{ $game->genre }}</p>
            <p><strong>Rating:</strong> {{ $game->rating }}/10</p>
        </div>
    </div>
    <br>
    <a href="/games" class="btn btn-secondary">Back to Overview</a>
@endsection