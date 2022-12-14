<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sekolah;
use DateTime;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create ProgramStudi
        Sekolah::create([
            'npsn' => '2303241',
            'nama_sekolah' => 'SMAN 3 Purwakarta',
            'alamat' => 'Purwakarta',
            'kota' => 'Purwakarta',
            'created_at' => now()
        ]);

        
    }
}
