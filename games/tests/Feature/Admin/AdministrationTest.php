<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdministrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_all_four_administration_pages(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.permissions.index'))
            ->assertOk();
        $this->get(route('admin.roles.index'))->assertOk();
        $this->get(route('admin.role-permissions.index'))->assertOk();
        $this->get(route('admin.user-roles.index'))->assertOk();
    }

    public function test_admin_can_manage_permissions_roles_and_their_assignments(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $this->post(route('admin.permissions.store'), ['name' => 'games.view'])
            ->assertRedirect(route('admin.permissions.index'));
        $permission = Permission::where('name', 'games.view')->firstOrFail();

        $this->put(route('admin.permissions.update', $permission), ['name' => 'games.read'])
            ->assertRedirect(route('admin.permissions.index'));
        $permission->refresh();
        $this->assertSame('games.read', $permission->name);

        $this->post(route('admin.roles.store'), ['name' => 'editor'])
            ->assertRedirect(route('admin.roles.index'));
        $role = Role::where('name', 'editor')->firstOrFail();

        $this->put(route('admin.roles.update', $role), ['name' => 'beheerder'])
            ->assertRedirect(route('admin.roles.index'));
        $role->refresh();
        $this->assertSame('beheerder', $role->name);

        $this->put(route('admin.roles.permissions.update', $role), [
            'permissions' => [$permission->id],
        ])->assertRedirect(route('admin.role-permissions.index'));
        $this->assertTrue($role->fresh()->hasPermissionTo($permission));

        $user = User::factory()->create();
        $this->put(route('admin.users.roles.update', $user), [
            'roles' => [$role->id],
        ])->assertRedirect(route('admin.user-roles.index'));
        $this->assertTrue($user->fresh()->hasRole($role));

        $this->put(route('admin.users.roles.update', $user), ['roles' => []])
            ->assertRedirect(route('admin.user-roles.index'));
        $this->assertFalse($user->fresh()->hasRole($role));

        $this->delete(route('admin.permissions.destroy', $permission))
            ->assertRedirect(route('admin.permissions.index'));
        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);

        $this->delete(route('admin.roles.destroy', $role))
            ->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    public function test_non_admin_users_cannot_access_administration_pages(): void
    {
        $role = Role::create(['name' => 'klant', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs($user)
            ->get(route('admin.permissions.index'))
            ->assertForbidden();
    }

    private function createAdmin(): User
    {
        $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }
}
