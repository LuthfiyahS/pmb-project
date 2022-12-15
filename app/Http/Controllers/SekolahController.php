<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sekolah;
use Alert;
class SekolahController extends Controller
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

    //data sekolah kompliit
    public function datasekolah(){
        $viewData = Sekolah::all();
        return view ('sekolah.data-school-admin',compact('viewData'));
    }

    public function simpansekolah(Request $a)
    {
        //$dataUser = Pengguna::all();
        try {
            Sekolah::create([
                'npsn' => $a->id,
                'nama_sekolah' => $a->nama,
                'alamat' => $a->Address,
                'kota' => $a->kota

            ]);
            return redirect('/data-sekolah')->with('success', 'Data Tersimpan!!');
        } catch (\Exception $e){
            echo $e;
            //return redirect()->back()->with('error', 'Data Tidak Berhasil Disimpan!');
        }
    }
    public function updatesekolah(Request $a, $NPSN){
        //$dataUser = Pengguna::all();
    try{
        Sekolah::where("NPSN", "$NPSN")->update([
            'nama_sekolah' => $a->nama,
            'alamat' => $a->Address,
            'kota' => $a->kota
        ]);
        return redirect('/data-sekolah')->with('success', 'Data Terubah!!');
    } catch (\Exception $e){
        return redirect()->back()->with('error', 'Data Tidak Berhasil Diubah!');
        }
    }

    public function hapussekolah($NPSN){
        //$dataUser = Pengguna::all();
    try{
        $dataSekolah = Sekolah::find($NPSN);
        $dataSekolah->delete();
        return redirect('/data-sekolah')->with('success', 'Data Terhapus!!');
    } catch (\Exception $e){
        return redirect()->back()->with('error', 'Data Tidak Terhapus!');
    }
    }
}
