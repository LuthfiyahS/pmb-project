<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengumumanController extends Controller
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

            return $next($request);
        });
    }

    //data pengumuman kompliit
    public function datapengumuman()
    {
        $dataUser = Pengguna::all();
        $data = Pengumuman::all();
        $dataid = Pendaftaran::all();
        $dataprod = Prodi::all();
        return view ('data-pengumuman-admin',['viewDataUser' => $dataUser,'viewData' => $data,'viewIdPendaftaran' => $dataid,'viewProdi' => $dataprod]);
    }

    public function lihatpengumuman(Request $a)
    {
        $dataUser = Pengguna::all();
        $dataditemukan = Pengumuman::where("id_pendaftaran", $a->id_pendaftaran)->LIMIT(1);
        $data = Pengumuman::all();
        $dataid = Pendaftaran::find($a->id_pendaftaran);
        $dataprod = Prodi::all();
        $dataskl = Sekolah::all();
        return view ('data-pengumuman-view',['viewDataUser' => $dataUser,'viewData' => $data,'viewIdPendaftaran' => $dataid,'viewProdi' => $dataprod,'viewID' => $dataditemukan,'viewSekolah' => $dataskl]);
    }


    public function simpanpengumuman(Request $a)
    {
        try{
        //$dataUser = Pengguna::all();
            $kode = Pengumuman::id();
            Pengumuman::create([
                'id_pengumuman' => $kode,
                'id_pendaftaran' => $a->id_pendaftaran,
                'hasil_seleksi' => $a->hasil,
                'prodi_penerima' => $a->penerima,
                'nilai_interview' => $a->interview,
                'nilai_test' => $a->test
            ]);
            Timeline::create([
                'id_user' => $a->userid,
                'status' => "Membuat pengumuman"
            ]);
            return redirect('/data-announcement')->with('success', 'Data Tersimpan!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Disimpan!');
        }
    }

    public function updatepengumuman(Request $a, $id_pengumuman){
        //$dataUser = Pengguna::all();
        try{
            Pengumuman::where("id_pengumuman", "$id_pengumuman")->update([
                'id_pendaftaran' => $a->id_pendaftaran,
                'hasil_seleksi' => $a->hasil,
                'prodi_penerima' => $a->prodi,
                'nilai_interview' => $a->interview,
                'nilai_test' => $a->test,
            ]);
            if($a->hasil =="LULUS" || $a->hasil =="TIDAK LULUS"){
                Pendaftaran::where("id_pendaftaran", "$a->id_pendaftaran")->update([
                    "status_pendaftaran"=>"Selesai"
                ]);
            }
            Timeline::create([
                'id_user' => $a->userid,
                'status' => "Mengupdate pengumuman"
            ]);
            return redirect('/data-announcement')->with('success', 'Data Terubah!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Diubah!');
        }
    }
    

    public function hapuspengumuman($id_pengumuman){
        //$dataUser = Pengguna::all();
        try{
            $data = Pengumuman::find($id_pengumuman);
            $data->delete();
            return redirect('/data-announcement')->with('success', 'Data Terhapus!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus!');
        }
    }
}
