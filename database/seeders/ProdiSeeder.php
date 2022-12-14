<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;
use DateTime;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create ProgramStudi
        ProgramStudi::create([
            'id_prodi' => 'PRD001',
            'nama_prodi' => 'TEKNOLOGI REKAYASA MANUFAKTUR',
            'created_at' => now()
        ]);

        ProgramStudi::create([
            'id_prodi' => 'PRD002',
            'nama_prodi' => 'TEKNOLOGI REKAYASA MEKATRONIKA',
            'created_at' => now()
        ]);
        ProgramStudi::create([
            'id_prodi' => 'PRD003',
            'nama_prodi' => 'TEKNOLOGI REKAYASA PERANGKAT LUNAK',
            'created_at' => now()
        ]);

        ProgramStudi::create([
            'id_prodi' => 'PRD004',
            'nama_prodi' => 'TEKNOLOGI LISTRIK',
            'created_at' => now()
        ]);
        
    }
}
