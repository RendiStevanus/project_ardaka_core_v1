<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // roles
        $roles = [
            'super-admin',
            'admin',
            'user',

        ];

        // create roles
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // permissions
        $resources = [
            'dashboard',

            // Super-admin
            'user',
            'role',
            'permission',


        ];
        $actions = ['create', 'read', 'update', 'delete'];

        // create all permissions
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action}_{$resource}"]);
            }
        }

        Permission::firstOrCreate(['name' => 'read_activity_log', 'guard_name' => 'web']);

        // Mapping role → permissions
        $rolePermissions = [
            'super-admin' => Permission::pluck('name')->toArray(), // semua permission
            'admin' => Permission::whereNotIn('name', [
                'create_user',
                'read_user',
                'update_user',
                'delete_user',

                'create_role',
                'read_role',
                'update_role',
                'delete_role',

                'create_permission',
                'read_permission',
                'update_permission',
                'delete_permission',
            ])->pluck('name')->toArray(),

            'user' => Permission::whereIn('name', [
                'read_dashboard',
            ])->get(),
        ];

        // Assign permissions ke roles
        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::where('name', $roleName)->first();
            $role?->syncPermissions($perms);
        }
    }
}
