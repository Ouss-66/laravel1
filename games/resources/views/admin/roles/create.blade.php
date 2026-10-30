@extends('base')

@section('title', 'Rol toevoegen')

@section('content')
    <h1>Nieuwe rol toevoegen</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Rolnaam</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required maxlength="255" placeholder="Bijv. redacteur">
        </div>
        <button type="submit" class="btn btn-success">Opslaan</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Terug</a>
    </form>
@endsection
