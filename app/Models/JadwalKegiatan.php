<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKegiatan extends Model
{
    use HasFactory;
    protected $table = "jadwal_kegiatan";
    protected $primaryKey= "id";
    protected $fillable = ["id_kegiatan","nama_kegiatan","jenis_kegiatan","tgl_mulai","tgl_akhir"];
    public $timestamps = false;
}
