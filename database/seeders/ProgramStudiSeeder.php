<?php

namespace Database\Seeders;

use App\Models\MasterProgramStudi;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode' => '77201',
                'nama' => 'Teologi',
                'jenjang' => 'S1',
                'akreditasi' => 'Baik',
            ],
            [
                'kode' => '86213',
                'nama' => 'Pendidikan Agama Kristen',
                'jenjang' => 'S1',
                'akreditasi' => 'Baik',
            ]
        ];

        foreach ($data as $item) {
            MasterProgramStudi::updateOrCreate(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}
