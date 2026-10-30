@extends('base')

@section('title', '🔒 Beheer Permissies')

@section('content')
    <div class="container">
        <h1>Permissies Overzicht</h1>
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-success mb-3">Nieuwe permissie toevoegen</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($permissions->isEmpty())
            <p>Er zijn nog geen permissies.</p>
        @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Guard</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>
                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-primary btn-sm">Bewerken</a>
                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze permissie wilt verwijderen?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
@endsection