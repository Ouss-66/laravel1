@extends('base')

@section('title', 'Permissie bewerken')

@section('content')
    <h1>Permissie bewerken</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Permissie naam</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $permission->name) }}" required maxlength="255">
        </div>
        <button type="submit" class="btn btn-success">Opslaan</button>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Terug</a>
    </form>
@endsection
