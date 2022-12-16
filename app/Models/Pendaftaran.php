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

        'status',
        'tgl_pendaftaran'
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

    public function pilihan1(){
        return $this->belongsTo(ProgramStudi::class,'pil1');
    }

    public function pilihan2(){
        return $this->belongsTo(ProgramStudi::class,'pil2');
    }
}
