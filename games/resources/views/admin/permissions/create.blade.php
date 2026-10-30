@extends('base')

@section('title', '➕ Permissie Toevoegen')

@section('content')
    <div class="container">
        <h1>Nieuwe Permissie Toevoegen</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Permissie Naam</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required maxlength="255" placeholder="Bijv. product invoeren">
            </div>
            <button type="submit" class="btn btn-success">Opslaan</button>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Terug</a>
        </form>
    </div>
@endsection