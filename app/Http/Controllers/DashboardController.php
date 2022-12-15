<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\Sekolah;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\Pengumuman;
use App\Models\Timeline;
use App\Models\JadwalKegiatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Carbon;
use File;
use Alert;

class DashboardController extends Controller
{
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
    public function dashboard(){
        $dataPendaftar = Pendaftaran::select( DB::raw('count(*) as jmlpendaftar'),'tahun_masuk')
        ->groupBy('tahun_masuk')->get();
        $data = Pendaftaran::select('status_pendaftaran', DB::raw('count(*) as jumlah'),)
        ->groupBy('status_pendaftaran')->get();
        $pendaftar = Pendaftaran::all();
        $jmlpendaftar = Pendaftaran::all()->count();
        $dataUser = User::all();
        $timeline = Timeline::all()->sortBy('desc');
        $jmluser = User::all()->count();
        $jmlbayar = Pembayaran::where('status',true)->count();
        $jmlpendaftarperprodi =  Pendaftaran::select('pil1',  DB::raw('count(*) as jmldaftarprodi'),)
        ->groupBy('pil1')->get();
        $jmlpengumuman =  Pengumuman::select('hasil_seleksi', DB::raw('count(*) as jumlah'),)
        ->groupBy('hasil_seleksi')->get();
        $prodi = ProgramStudi::all();
        return view ('dashboard',['timeline' => $timeline,'viewDataUser' => $dataUser,'viewTotal'=>$data,'viewTahunini'=>$dataPendaftar,'pendaftar'=>$pendaftar,'jmlpengumuman'=>$jmlpengumuman,'jmlpendaftar'=>$jmlpendaftar,'jmlpendaftarprodi'=>$jmlpendaftarperprodi,'jmluser'=>$jmluser,'prodi'=>$prodi,'jmlbayar'=>$jmlbayar]);
    }
}
