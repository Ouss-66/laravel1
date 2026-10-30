@extends('base')

@section('title', 'Rollen beheren')

@section('content')
    <h1>Rollen overzicht</h1>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-success mb-3">Nieuwe rol toevoegen</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($roles->isEmpty())
        <p>Er zijn nog geen rollen.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Guard</th>
                    <th>Aantal permissies</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->guard_name }}</td>
                        <td>{{ $role->permissions_count }}</td>
                        <td>
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary btn-sm">Bewerken</a>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze rol wilt verwijderen?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection