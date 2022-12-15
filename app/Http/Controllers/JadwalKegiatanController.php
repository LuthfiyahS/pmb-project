<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JadwalKegiatan;
use Alert;

class JadwalKegiatanController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(function($request,$next){
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('error')) {
                Alert::error(session('error'));
            }
            
            if (session('warning')) {
                Alert::warning(session('warning'));
            }
            return $next($request);
        });
    }

    //data kegiatan kompliit
    public function datajadwal(){
        $datenow = date('Y-m-d');
        $viewData = JadwalKegiatan::all();
        return view ('jadwalkegiatan.data-jadwal',compact('viewData','datenow'));
    }

    public function simpanjadwal(Request $a)
    {
        try {
            $kode=JadwalKegiatan::id();
            JadwalKegiatan::create([
                'id_kegiatan' => $kode,
                'nama_kegiatan' => $a->nama,
                'jenis_kegiatan' => $a->jenis,
                'tgl_mulai' => $a->mulai,
                'tgl_akhir' => $a->selesai
            ]);
            return redirect('/data-jadwal')->with('success', 'Data Tersimpan!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Disimpan!');
        }
    }
    public function updatejadwal(Request $a, $id){
    try{
        JadwalKegiatan::where("id", $id)->update([
            'nama_kegiatan' => $a->nama,
            'jenis_kegiatan' => $a->jenis,
            'tgl_mulai' => $a->mulai,
            'tgl_akhir' => $a->selesai
        ]);
        return redirect('/data-jadwal')->with('success', 'Data Terubah!!');
    } catch (\Exception $e){
        return redirect()->back()->with('error', 'Data Tidak Berhasil Diubah!');
        }
    }

    public function hapusjadwal($id){
    try{
        $data = JadwalKegiatan::find($id);
        $data->delete();
        return redirect('/data-jadwal')->with('success', 'Data Terhapus!!');
    } catch (\Exception $e){
        return redirect()->back()->with('error', 'Data Tidak Terhapus!');
    }
    }
}
