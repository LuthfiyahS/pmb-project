<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = "pengumuman";
    protected $fillable = ["id_pengumuman","user_id","id_pendaftaran","hasil_seleksi","prodi_penerima","nilai_interview","nilai_test"];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey= "id";

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
