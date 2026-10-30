@extends('base')

@section('title', 'Rol bewerken')

@section('content')
    <h1>Rol bewerken</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Rolnaam</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" required maxlength="255">
        </div>
        <button type="submit" class="btn btn-success">Opslaan</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Terug</a>
    </form>
@endsection
