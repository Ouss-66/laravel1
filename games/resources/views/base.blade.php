<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Game Collection</title>
</head>
<body>
    @auth
        @role('admin')
            <nav class="container mt-4" aria-label="Adminbeheer">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-primary btn-sm">Permissies</a>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-primary btn-sm">Rollen</a>
                <a href="{{ route('admin.role-permissions.index') }}" class="btn btn-outline-primary btn-sm">Rol-permissies</a>
                <a href="{{ route('admin.user-roles.index') }}" class="btn btn-outline-primary btn-sm">Gebruikers-rollen</a>
            </nav>
        @endrole
    @endauth
    <div class="container" style="margin:40px;">
        <h1 class="display-4">@yield('title')</h1>
        @yield('content')
    </div>
</body>
</html>