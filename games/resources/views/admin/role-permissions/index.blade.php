@extends('base')

@section('title', 'Permissies aan rollen koppelen')

@section('content')
    <h1>Permissies aan rollen koppelen</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($roles->isEmpty())
        <p>Maak eerst een rol aan om permissies te kunnen koppelen.</p>
    @elseif($permissions->isEmpty())
        <p>Maak eerst permissies aan om deze aan rollen te koppelen.</p>
    @else
        @foreach($roles as $role)
            <section class="card mb-4">
                <div class="card-header"><strong>{{ $role->name }}</strong></div>
                <div class="card-body">
                    <form action="{{ route('admin.roles.permissions.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked($role->permissions->contains('id', $permission->id))>
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Permissies opslaan</button>
                    </form>
                </div>
            </section>
        @endforeach
    @endif
@endsection
