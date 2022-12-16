<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class JadwalKegiatan extends Model
{
    use HasFactory;
    protected $table = "jadwal_kegiatan";
    protected $primaryKey= "id";
    protected $fillable = ["id_kegiatan","nama_kegiatan","jenis_kegiatan","tgl_mulai","tgl_akhir"];
    public $timestamps = false;

    public static function id()
    {
    	$kode = DB::table('program_studi')->max('id');
    	$addNol = '';
    	$kode = str_replace("PRD", "", $kode);
    	$kode = (int) $kode + 1;
        $incrementKode = $kode;

    	if (strlen($kode) == 1) {
    		$addNol = "00";
    	} elseif (strlen($kode) == 2) {
    		$addNol = "0";
        }
    	$kodeBaru = "PRD".$addNol.$incrementKode;
    	return $kodeBaru;
    }
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
