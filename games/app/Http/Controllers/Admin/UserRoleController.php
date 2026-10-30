<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('name')->get();
        $roles = Role::where('guard_name', 'web')->orderBy('name')->get();

        return view('admin.user-roles.index', compact('users', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => [
                'integer',
                'distinct',
                Rule::exists('roles', 'id')->where('guard_name', 'web'),
            ],
        ]);

        $roles = Role::where('guard_name', 'web')
            ->whereIn('id', $validated['roles'] ?? [])
            ->get();

        $user->syncRoles($roles);

        return redirect()->route('admin.user-roles.index')->with('success', "Rollen voor {$user->name} bijgewerkt!");
    }
}
