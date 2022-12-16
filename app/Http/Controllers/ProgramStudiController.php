<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramStudi;
use Alert;

class ProgramStudiController extends Controller
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


    //data prodi kompliit
    public function dataprodi(){
        $viewData = ProgramStudi::all();
        return view ('prodi.data-studyProgram-admin',compact('viewData'));
    }

    public function simpanprodi(Request $a)
    {
        try{

            $kode=ProgramStudi::id();

            $fileft = $a->file('foto');
            if(file_exists($fileft)){
                $nama_fileft = "Prodi".time() . "-" . $fileft->getClientOriginalName();
                $namaFolderft = 'foto prodi';
                $fileft->move($namaFolderft,$nama_fileft);
                $path = $namaFolderft."/".$nama_fileft;
            } else {
                $path = null;
            }
            
            ProgramStudi::create([
                'id_prodi' => $kode,
                'nama_prodi' => $a->nama,
                'jenjang_prodi' => $a->jenjang,
                'foto_prodi' => $path,
        ]);
            return redirect('/data-prodi')->with('success', 'Data Tersimpan!!');
        } catch (\Exception $e){
            echo $e;
            //return redirect()->back()->with('error', 'Data Tidak Berhasil Disimpan!');
        }
    }

    public function updateprodi(Request $a, $id_prodi){
        //$dataUser = Pengguna::all();
        try{
            $fileft = $a->file('foto');
            if(file_exists($fileft)){
                $nama_fileft = "Prodi".time() . "-" . $fileft->getClientOriginalName();
                $namaFolderft = 'foto prodi';
                $fileft->move($namaFolderft,$nama_fileft);
                $path = $namaFolderft."/".$nama_fileft;
            } else {
                $path = $a->pathnya;
            }
            ProgramStudi::where("id", $id_prodi)->update([
                'nama_prodi' => $a->nama,
                'jenjang_prodi' => $a->jenjang,
                'foto_prodi' => $path,
        ]);
            return redirect('/data-prodi')->with('success', 'Data Terubah!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Diubah!');
        }
    }

    public function hapusprodi($id_prodi){
        //$dataUser = Pengguna::all();
        try{
            $data = ProgramStudi::find($id_prodi);
            $data->delete();
            return redirect('/data-prodi')->with('success', 'Data Terhapus!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus!');
        }
    }
}
