<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    protected $table = "sekolah";
    protected $primaryKey= "npsn";
    protected $fillable = ["npsn","nama_sekolah","alamat","kota"];
    public $timestamps = false;
    public $incrementing = false;

    public function pendaftaran(){
        return $this->hasMany(Pendaftaran::class);
    }
    
}
