<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permissions')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('role_has_permissions')->delete();

        collect(config('roles-and-permissions.permissions'))->each(function ($permissions, $permissionType) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permissionType . '-' . $permission]);
            }
        });

        collect(config('roles-and-permissions.roles'))->each(function ($rolePermissions, $role) {
            $role = Role::create(['name' => $role]);
            foreach ($rolePermissions as $permissionType => $permissions) {
                if ($permissions === '*') {
                    continue;
                }
                foreach ($permissions as $permission) {
                    #TODO caso permission === * aqui registrar todas com where like a key
                    $permission = Permission::where('name', $permissionType . '-' . $permission)->first();
                    $role->givePermissionTo($permission);
                    $permission->assignRole($role);
                }

            }
        });

    }
}