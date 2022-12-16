<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
Use Illuminate\Support\Carbon;

class Pendaftaran extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'pendaftaran';
    protected $primaryKey = "id";
    protected $fillable = [
        'id_pendaftaran',
        'user_id',
        'nisn',
        'nik',
        'nama_siswa',
        'jenis_kelamin',
        'pas_foto',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',

        //kontak
        'email',
        'hp',

        //alamat
        'alamat',

        //data pendaftaran
        'gelombang',
        'tahun_masuk',
        'pil1',
        'pil2',

        //data ortu
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'nohp_ayah',
        'nohp_ibu',
        'penghasilan_ayah',
        'penghasilan_ibu',
        'berkas_ortu',

        //data nilai dan sekolah
        'sekolah',
        'smt1',
        'smt2',
        'smt3',
        'smt4',
        'smt5',
        'smt6',
        'berkas_siswa',
        'prestasi',

        'status_pendaftaran',
        'tgl_pendaftaran',
        'created_at'
    ];
  
    // // relasi provinsi
    // public function province()
    // {
    //     return $this->belongsTo(Province::class, 'provinsi_id');
    // }

    // // relasi kabupaten
    // public function regency()
    // {
    //     return $this->belongsTo(Regency::class, 'kabupaten_id');
    // }

    // // relasi kecamatan
    // public function district()
    // {
    //     return $this->belongsTo(District::class, 'kecamatan_id');
    // }

    // // relasi kelurahan
    // public function village()
    // {
    //     return $this->belongsTo(Village::class, 'kelurahan_id');
    // }

    public static function id()
    {
    	$kode = DB::table('pendaftaran')->count();
    	$addNol = '';
        $waktu = now()->format('Y');
    	$kode = str_replace($waktu,"", $kode);
    	$kode = (int) $kode + 1;
        $incrementKode = $kode;

    	if (strlen($kode) == 1) {
            $tgl = now()->format('j');
            if (strlen($tgl) == 1) {
                $addNol = "0".now()->format('j')."00";
            } elseif (strlen($tgl) == 2) {
                $addNol = now()->format('j')."00";
            } 
    	} elseif (strlen($kode) == 2) {
    		$addNol = now()->format('h')."0";
    	} elseif (strlen($kode) == 3) {
    		$addNol = "00";
        } elseif (strlen($kode) == 4) {
    		$addNol = "0";
        }
    	$kodeBaru = $waktu.$addNol.$incrementKode;
    	return $kodeBaru;
    }

    public function user()
    {
         return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

     public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function pengumuman()
    {
        return $this->hasMany(pengumuman::class);
    }

    public function skolah(){
        return $this->belongsTo(Sekolah::class,'sekolah');
    }

    public function jadwal(){
        return $this->belongsTo(JadwalKegiatan::class,'gelombang');
    }

    public function pilihan1(){
        return $this->belongsTo(ProgramStudi::class,'pil1');
    }

    public function pilihan2(){
        return $this->belongsTo(ProgramStudi::class,'pil2');
    }
}
