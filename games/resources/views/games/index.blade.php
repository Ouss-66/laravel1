@extends('base')

@section('title', '🎮 Game Collection')

@section('content')
    @role('admin')
        <a href="/games/create" class="btn btn-success mb-3">Add Game</a>
    @endrole

    @php($sum = 0)

    <table class="table">
        <thead>
            <tr>
                <th>Game Name</th>
                <th>Platform</th>
                <th>Genre</th>
                <th>Rating</th>
                @role('admin')
                    <th>Edit</th>
                    <th>Delete</th>
                @endrole
                <th>Show</th>
            </tr>
        </thead>
        <tbody>
            @foreach($games as $game)
                @php($sum += $game->rating)
                <tr>
                    <td>{{ $game->game_name }}</td>
                    <td>{{ $game->platform }}</td>
                    <td>{{ $game->genre }}</td>
                    <td>{{ $game->rating }}</td>
                    
                    @role('admin')
                        <td>
                            <a href="/games/edit/{{ $game->id }}" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                        <td>
                            <form action="/games/destroy/{{ $game->id }}" method="post">
                                @csrf
                                <button onclick="return confirm('Weet je het zeker?')" class="btn btn-danger btn-sm" type="submit">Delete</button>
                            </form>
                        </td>
                    @endrole

                    <td>
                        <a href="/games/show/{{ $game->id }}" class="btn btn-info btn-sm">Show</a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Gemiddelde rating:</strong></td>
                <td><strong>{{ count($games) > 0 ? number_format($sum / count($games), 1) : 0 }}/10</strong></td>
                @role('admin')
                    <td></td>
                    <td></td>
                @endrole
                <td></td>
            </tr>
        </tbody>
    </table>
@endsection