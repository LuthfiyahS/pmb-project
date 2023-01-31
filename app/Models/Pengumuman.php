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
    	$data = DB::table('pembayaran')->orderby('id_pendaftaran','DESC')->first();
		$kodeakhir5 = substr($data->id_pendaftaran,-3);
		$kodeku= (int)$kodeakhir5;
		$addNol = '';
		$kodetb = 'TAG';
		//$kode = str_replace($kodetb,"", $kode);
		$kode = (int)$kodeku + 1;
		$incrementKode = $kode;


		if (strlen($kode) == 1) {
			$addNol = "000";
		} elseif (strlen($kode) == 2) {
			$addNol = "00";
		} elseif (strlen($kode) == 3) {
			$addNol = "0";
		} elseif (strlen($kode) == 4) {
			$addNol = "";
		}
		$kodeBaru = 'ANN'.now()->format('y').$addNol.$incrementKode;
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
         return $this->belongsTo(User::class, 'user_id');
    }
}
