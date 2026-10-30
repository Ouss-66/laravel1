@extends('base')

@section('title', 'Rollen aan gebruikers koppelen')

@section('content')
    <h1>Rollen aan gebruikers koppelen</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($users->isEmpty())
        <p>Er zijn nog geen gebruikers.</p>
    @elseif($roles->isEmpty())
        <p>Maak eerst een rol aan om deze aan gebruikers te koppelen.</p>
    @else
        @foreach($users as $user)
            <section class="card mb-4">
                <div class="card-header">
                    <strong>{{ $user->name }}</strong>
                    <span class="text-muted">({{ $user->email }})</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.roles.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach($roles as $role)
                                <div class="col-md-4 mb-2">
                                    <label>
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked($user->roles->contains('id', $role->id))>
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Rollen opslaan</button>
                    </form>
                </div>
            </section>
        @endforeach
    @endif
@endsection
