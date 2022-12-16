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
            'jenjang_prodi' => 'Diploma 4',
            'foto_prodi' => 'foto prodi/Prodi1671193438-mesin.jpg',
            'created_at' => now()
        ]);

        ProgramStudi::create([
            'id_prodi' => 'PRD002',
            'nama_prodi' => 'TEKNOLOGI REKAYASA MEKATRONIKA',
            'jenjang_prodi' => 'Diploma 4',
            'foto_prodi' => 'foto prodi/Prodi1671193459-mekatronika.jpeg',
            'created_at' => now()
        ]);
        ProgramStudi::create([
            'id_prodi' => 'PRD003',
            'nama_prodi' => 'TEKNOLOGI REKAYASA PERANGKAT LUNAK',
            'jenjang_prodi' => 'Diploma 4',
            'foto_prodi' => 'foto prodi/Prodi1671193502-trpl.jpg',
            'created_at' => now()
        ]);

        ProgramStudi::create([
            'id_prodi' => 'PRD004',
            'nama_prodi' => 'TEKNOLOGI LISTRIK',
            'jenjang_prodi' => 'Diploma 3',
            'foto_prodi' => 'foto prodi/Prodi1671193482-listrik.jpg',
            'created_at' => now()
        ]);
        
    }
}
