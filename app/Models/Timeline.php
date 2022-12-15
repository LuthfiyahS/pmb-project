<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;
    protected $table = "timeline";
    protected $primaryKey= "id";
    protected $fillable = ["user_id","status","pesan"];
    public $timestamps = false;

    public function user()
    {
         return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
