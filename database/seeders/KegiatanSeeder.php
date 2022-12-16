<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('jadwal_kegiatan')->insert([
            'id_kegiatan' => "JDW00001",
            'nama_kegiatan' => 'Gelombang 1 | REGULER',
            'jenis_kegiatan' =>  'Pendaftaran',
            'tgl_mulai' =>  now(),
            'tgl_akhir' => now()->addDays(30)->format('Y-m-d'),
        ]);
        DB::table('jadwal_kegiatan')->insert([
            'id_kegiatan' => "JDW00002",
            'nama_kegiatan' => 'Gelombang 1 | BEASISWA PRESTASI',
            'jenis_kegiatan' =>  'Pendaftaran',
            'tgl_mulai' =>  now(),
            'tgl_akhir' => now()->addDays(20)->format('Y-m-d'),
        ]);
        DB::table('jadwal_kegiatan')->insert([
            'id_kegiatan' => "JDW00003",
            'nama_kegiatan' => 'Gelombang 2',
            'jenis_kegiatan' =>  'REGULER',
            'tgl_mulai' =>  now()->addDays(31)->format('Y-m-d'),
            'tgl_akhir' => now()->addDays(60)->format('Y-m-d'),
        ]);
    }
}
