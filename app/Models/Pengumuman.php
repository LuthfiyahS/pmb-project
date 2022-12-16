<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = "pengumuman";
    protected $fillable = ["id_pengumuman","user_id","id_pendaftaran","hasil_seleksi","prodi_penerima","nilai_interview","nilai_test","status"];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey= "id";

    public static function id()
    {
    	$kode = DB::table('pengumuman')->max('id_pengumuman');
    	$addNol = '';
    	$kode = str_replace("ANN", "", $kode);
    	$kode = (int) $kode + 1;
        $incrementKode = $kode;

    	if (strlen($kode) == 1) {
    		$addNol = "00";
    	} elseif (strlen($kode) == 2) {
    		$addNol = "0";
    	} 
    	$kodeBaru = "ANN".$addNol.$incrementKode;
    	return $kodeBaru;
    }

	public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
 	}
     public function prodi()
     {
         return $this->belongsTo(ProgramStudi::class, 'prodi_penerima');
      }
    public function user()
    {
         return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
