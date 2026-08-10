<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            ]);

        $superAdmin->assignRole('super-admin');

        $camaba = User::factory(5)->create();

        foreach ($camaba as $camaba) {
            $camaba->assignRole('calon-mahasiswa');
        }
    }
}
