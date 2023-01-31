<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProgramStudi extends Model
{
    use HasFactory;
    protected $table = "program_studi";
    protected $primaryKey= "id";
    protected $fillable = ["id_prodi","nama_prodi","jenjang_prodi","foto_prodi"];
    public $timestamps = false;
    public $incrementing = false;

    public static function id()
    {
    	$kode = DB::table('program_kursus')->max('id');
    	$addNol = '';
    	$kode = str_replace("KRS", "", $kode);
    	$kode = (int) $kode + 1;
        $incrementKode = $kode;

    	if (strlen($kode) == 1) {
    		$addNol = "00";
    	} elseif (strlen($kode) == 2) {
    		$addNol = "0";
        }
    	$kodeBaru = "KRS".$addNol.$incrementKode;
    	return $kodeBaru;
    }

    public function pengumuman()
    {
    return $this->belongsTo(Pengumuman::class);
    }
    
    public function pendaftaran(){
        return $this->hasMany(Pendaftaran::class);
    }
}
