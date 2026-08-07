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
            'admin-pmb',
            'pimpinan',
            'keuangan',
            'calon-mahasiswa',
        ];

        // create roles
        foreach ($roles as $roleName){
            Role::firstOrCreate(['name' => $roleName]);
        }
        
        // permissions
        $resources = [
            'user',
            'role',
            'permission',
            'dashboard',

            'master_program_studi',
            'master_tahun_akademik',
            'master_gelombang',
            'master_jalur_masuk',
            'master_agama',
            'master_wilayah',
            'master_pengaturan',

            'pmb_pendaftaran',
            'pmb_berkas',
            'pmb_pembayaran',
            'pmb_verifikasi',
            'pmb_seleksi',
            'pmb_jadwal_tes',
            'pmb_penilaian',
            'pmb_kelulusan',
            'pmb_registrasi_ulang',
            'pmb_generate_nim',

            'laporan',
        ];
        $actions = ['read', 'create', 'update', 'delete', 'export'];

        // create all permissions
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action}_{$resource}"]);
            }
        }

        Permission::firstOrCreate(['name' => 'reset_user']);

        // Mapping role → permissions
        $rolePermissions = [
            'super-admin' => Permission::pluck('name')->toArray(), // semua permission
            'admin-pmb' => Permission::whereNotIn('name', [
                'create_user',
                'read_user',
                'update_user',
                'delete_user',
                'reset_user',
                'export_user',

                'create_role',
                'read_role',
                'update_role',
                'delete_role',
                'reset_role',
                'export_role',

                'create_permission',
                'read_permission',
                'update_permission',
                'delete_permission',
                'reset_permission',
                'export_permission',
            ])->pluck('name')->toArray(),
        ];

        // Assign permissions ke roles
        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::where('name', $roleName)->first();
            $role?->syncPermissions($perms);
        }
    }
}
