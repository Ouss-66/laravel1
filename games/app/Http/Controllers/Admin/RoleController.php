<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'web')->withCount('permissions')->orderBy('name')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->where('guard_name', 'web')],
        ]);

        Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Rol succesvol aangemaakt!');
    }

    public function edit(Role $role)
    {
        abort_unless($role->guard_name === 'web', 404);

        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        abort_unless($role->guard_name === 'web', 404);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->where('guard_name', 'web')->ignore($role->id),
            ],
        ]);

        $role->update(['name' => $validated['name']]);

        return redirect()->route('admin.roles.index')->with('success', 'Rol bijgewerkt!');
    }

    public function destroy(Role $role)
    {
        abort_unless($role->guard_name === 'web', 404);

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Rol verwijderd!');
    }
}
