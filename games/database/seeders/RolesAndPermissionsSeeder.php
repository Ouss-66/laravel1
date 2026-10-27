<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionNames = [
            'product bekijken',
            'product bestellen',
            'product invoeren',
            'product aanpassen',
            'product verwijderen',
            'bestellingen bekijken',
        ];

        $permissions = collect($permissionNames)
            ->map(fn (string $name) => Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]));

        $customer = Role::firstOrCreate([
            'name' => 'klant',
            'guard_name' => 'web',
        ]);
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $customer->syncPermissions([
            'product bekijken',
            'product bestellen',
        ]);
        $admin->syncPermissions($permissions);

        User::query()
            ->where(function ($query): void {
                $query->where('email', 'like', '%@klant.nl')
                    ->orWhere('email', 'test@example.com');
            })
            ->each(fn (User $user) => $user->syncRoles($customer));

        User::query()
            ->where('email', 'like', '%@admin.nl')
            ->each(fn (User $user) => $user->syncRoles($admin));
    }
}
