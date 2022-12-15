<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileUsers;
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

class PendaftaranController extends Controller
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

    //data pendaftaran kompliit
    public function datapendaftaran(){
        $dataUser = ProfileUsers::all();
        $data = Pendaftaran::all();
        $datapembayaran = Pembayaran::all();
        return view ('pendaftaran.data-pendaftaran-admin',['viewDataPembayaran' => $datapembayaran, 'viewDataUser' => $dataUser,'viewData' => $data]);
    }

    public function inputpendaftaran(){
        $dataUser = ProfileUsers::all();
        $dataprod = ProgramStudi::all();
        $datenow = date('Y-m-d');
        $dataJadwal = JadwalKegiatan::where("tgl_mulai","<","$datenow")->where("tgl_akhir",">","$datenow")->where("jenis_kegiatan","Pendaftaran")->get();
        $dataSekolah = Sekolah::all();
        return view ('pendaftaran.data-pendaftaran-input-admin',['viewDataJadwal' => $dataJadwal,'viewDataUser' => $dataUser,'viewSekolah' => $dataSekolah,'viewProdi' => $dataprod]);
    }

    public function simpanpendaftaran(Request $a)
    {
        try{
        $dataUser = ProfileUsers::all();
        $message = [
            'nisn.required' => 'NISN must be filled',
            'nik.required' => 'NIK must be filled',
            'nama.required' => 'Name must be filled',
            'jk.required' => 'Gender must be filled',
            'foto.required' => 'Photo cannot be empty',
            'tempatlahir.required' => 'Birthplace must be filled',
            'tanggallahir.required' => 'Date of birth must be filled',
            'agama.required' => 'Religion must be filled',
            'alamat.required' => 'Address must be filled',
            'email.required' => 'Email must be filled',
            'nohp.required' => 'Mobile phone must be filled',
            'gelombang.required' => 'Batch must be filled',
            'pil1.required' => 'Prodi choice must be filled',
            'pil2.required' => 'Prodi choice must be filled',
            'ayah.required' => 'Father`s name must be filled',
            'ibu.required' => 'Mother`s name must be filled',
            'pekerjaanayah.required' => 'Father`s occupation must be filled',
            'pekerjaanibu.required' => 'Mother`s occupation must be filled',
            'noayah.required' => 'Father`s phone number must be filled',
            'noibu.required' => 'Mother`s phone number must be filled',
            'gaji.required' => 'PaySlip must be filled',
            'tanggungan.required' => 'Family dependents must be filled',
            'ftgaji.required' => 'PaySlip cannot be empty',
            'ftkk.required' => 'Family card cannot be empty',
            'id_sekolah.required' => 'School name must be filled',
            'jurusan.required' => 'Major must be filled',
            'smt1.required' => 'Semester 1 must be filled',
            'smt2.required' => 'Semester 2 must be filled',
            'smt3.required' => 'Semester 3 must be filled',
            'smt4.required' => 'Semester 4 must be filled',
            'smt5.required' => 'Semester 5 must be filled',
            'ftraport.required' => 'Raport cannot be empty',
        ];

        $cekValidasi = $a->validate([
            //'id_pendaftaran' => 'required',
            //'id_user' => 'required',
            'nisn' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'jk' => 'required',
            'foto' => 'required',
            'tempatlahir' => 'required',
            'tanggallahir' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'nohp' => 'required',
            'gelombang' => 'required',
            'pil1' => 'required',
            'pil2' => 'required',
            'ayah' => 'required',
            'ibu' => 'required',
            'pekerjaanayah' => 'required',
            'pekerjaanibu' => 'required',
            'noayah' => 'required',
            'noibu' => 'required',
            'gaji' => 'required',
            'tanggungan' => 'required',
            'ftgaji' => 'required',
            'ftkk' => 'required',
            'id_sekolah' => 'required',
            'jurusan' => 'required',
            'smt1' => 'required',
            'smt2' => 'required',
            'smt3' => 'required',
            'smt4' => 'required',
            'smt5' => 'required',
            'ftraport' => 'required'
        ], $message);

        $kodependaftaran = Pendaftaran::id();

        $file = $a->file('foto');
        $nama_file = "Pasfoto".time() . "-" . $file->getClientOriginalName();
        $namaFolder = 'data pendaftar/'.$kodependaftaran;
        $file->move($namaFolder,$nama_file);
        $pathFoto = $namaFolder."/".$nama_file;

        $fileftgaji = $a->file('ftgaji');
        $nama_fileftgaji = "Slipgaji".time() . "-" . $fileftgaji->getClientOriginalName();
        $namaFolderftgaji = 'data pendaftar/'.$kodependaftaran;
        $fileftgaji->move($namaFolderftgaji,$nama_fileftgaji);
        $pathGaji = $namaFolderftgaji."/".$nama_fileftgaji;

        $fileftkk = $a->file('ftkk');
        $nama_fileftkk = "KartuKeluarga".time() . "-" . $fileftkk->getClientOriginalName();
        $namaFolderftkk = 'data pendaftar/'.$kodependaftaran;
        $fileftkk->move($namaFolderftkk,$nama_fileftkk);
        $pathKK = $namaFolderftkk."/".$nama_fileftkk;

        $fileftraport = $a->file('ftraport');
        $nama_fileftraport = "Pasfoto".time() . "-" . $fileftraport->getClientOriginalName();
        $namaFolderftraport = 'data pendaftar/'.$kodependaftaran;
        $fileftraport->move($namaFolderftraport,$nama_fileftraport);
        $pathRaport = $namaFolderftraport."/".$nama_fileftraport;

        $fileftprestasi = $a->file('ftprestasi');
        if(file_exists($fileftprestasi)){
            $nama_fileftprestasi = "Prestasi".time() . "-" . $fileftprestasi->getClientOriginalName();
            $namaFolderftprestasi = 'data pendaftar/'.$kodependaftaran;
            $fileftprestasi->move($namaFolderftprestasi,$nama_fileftprestasi);
            $pathPrestasi = $namaFolderftprestasi."/".$nama_fileftprestasi;
        } else {
            $pathPrestasi = null;
        }

        $fileftijazah = $a->file('ftijazah');
        if(file_exists($fileftijazah)){
            $nama_fileftijazah = "Ijazah".time() . "-" . $fileftijazah->getClientOriginalName();
            $namaFolderftijazah = 'data pendaftar/'.$kodependaftaran;
            $fileftijazah->move($namaFolderftijazah,$nama_fileftijazah);
            $pathIjazah = $namaFolderftijazah."/".$nama_fileftijazah;
        } else {
            $pathIjazah = null;
        }

        Pendaftaran::create([
            'id_pendaftaran' => $kodependaftaran,
            'id_user' => $a->id_user,
            'nisn' => $a->nisn,
            'nik' => $a->nik,
            'nama_siswa' => $a->nama,
            'jenis_kelamin' => $a->jk,
            'pas_foto' => $pathFoto,
            'tempat_lahir' => $a->tempatlahir,
            'tanggal_lahir' => $a->tanggallahir,
            'agama' => $a->agama,
            'alamat' => $a->alamat,
            'email' => $a->email,
            'nohp' => $a->nohp,
            'gelombang' => $a->gelombang,
            'tahun_masuk' => '2022',
            'pil1' => $a->pil1,
            'pil2' => $a->pil2,
            'nama_ayah' => $a->ayah,
            'nama_ibu' => $a->ibu,
            'pekerjaan_ayah' => $a->pekerjaanayah,
            'pekerjaan_ibu' => $a->pekerjaanibu,
            'nohp_ayah' => $a->noayah,
            'nohp_ibu' => $a->noibu,
            'gaji' => $a->gaji,
            'tanggungan' => $a->tanggungan,
            'slip_gaji' =>  $pathGaji,
            'kk' => $pathKK,
            'id_Sekolah' => $a->id_sekolah,
            'jurusan' => $a->jurusan,
            'smt1' => $a->smt1,
            'smt2' => $a->smt2,
            'smt3' => $a->smt3,
            'smt4' => $a->smt4,
            'smt5' => $a->smt5,
            'nilairaport' => $pathRaport,
            'ijazah' => $pathIjazah,
            'prestasi' => $pathPrestasi,
            'status_pendaftaran' => 'Belum Terverifikasi'

        ]);

        //tambah insert
        $kodepembayaran = Pembayaran::id();
        Pembayaran::create([
            'id_pembayaran' => $kodepembayaran,
            //'bukti_pembayaran' => "NULL",
            'status_pembayaran'=> "Belum Bayar",
            'id_pendaftaran' =>$kodependaftaran
        ]);

        $kodepengumuman = Pengumuman::id();
        Pengumuman::create([
            'id_pengumuman' => $kodepengumuman,
            'id_pendaftaran' => $kodependaftaran,
            'hasil_seleksi' => "Belum Seleksi",
            'prodi_penerima' => "Belum Tersedia",
        ]);

        Timeline::create([
            'id_user' => $a->id_user,
            'status' => "Melakukan pendaftaran penerimaan mahasiswa baru"
        ]);

        $rolenow = User::find($a->id);
        return redirect('/data-registration')->with('success', 'Data Tersimpan!!');
    } catch (\Exception $e){
        return redirect()->back()->with('error', 'Data Tidak Berhasil Tersimpan!');
    }
        //if ($rolenow->role=="Administrator"){
            //return redirect('/data-registration')->with('berhasil','data berhasil disimpan');
        //}
        //elseif($rolenow->role=="Calon Mahasiswa"){

        //return redirect('/detail-registration'.'/'.$a->kodependaftaran)->with('berhasil','data berhasil disimpan');
        //}
    }

    public function verifikasistatuspendaftaran($id_pendaftaran){
        //$dataUser = ProfileUsers::all();
        Pendaftaran::where("id_pendaftaran", "$id_pendaftaran")->update([
            'status_pendaftaran' => "Terverifikasi"
        ]);
        Timeline::create([
            'id_user' => $id_pendaftaran,
            'status' => "di verifikasi"
        ]);
        return redirect('/data-registration');
    }

    public function notverifikasistatuspendaftaran($id_pendaftaran){
        //$dataUser = ProfileUsers::all();
        Pendaftaran::where("id_pendaftaran", "$id_pendaftaran")->update([
            'status_pendaftaran' => "Belum Terverifikasi"
        ]);
        Timeline::create([
            'id_user' => $id_pendaftaran,
            'status' => "belum di verifikasi"
        ]);
        return redirect('/data-registration');
    }

    public function invalidstatuspendaftaran($id_pendaftaran){
        //$dataUser = ProfileUsers::all();
        Pendaftaran::where("id_pendaftaran", "$id_pendaftaran")->update([
            'status_pendaftaran' => "Tidak Sah"
        ]);
        Timeline::create([
            'id_user' => $id_pendaftaran,
            'status' => "tidak sah"
        ]);
        return redirect('/data-registration');
    }


    public function editpendaftaran($id_pendaftaran)
    {
        $dataUser = ProfileUsers::all();
        $dataprod = ProgramStudi::all();
        $dataSekolah = Sekolah::all();
        $datenow = date('Y-m-d');
        $dataJadwal = JadwalKegiatan::where("tgl_mulai","<","$datenow")->where("tgl_akhir",">","$datenow")->where("jenis_kegiatan","Pendaftaran")->get();
        $data = Pendaftaran::where("id_pendaftaran",$id_pendaftaran)->first();
        return view('pendaftaran.data-pendaftaran-edit-admin', ['viewDataJadwal' => $dataJadwal,'viewDataUser' => $dataUser,'viewData' => $data,'viewSekolah' => $dataSekolah,'viewProdi' => $dataprod]);
    }

    public function updatependaftaran(Request $a, $id_pendaftaran){

        try{
        $dataUser = ProfileUsers::all();
        $message = [
            'nisn.required' => 'NISN must be filled',
            'nik.required' => 'NIK must be filled',
            'nama.required' => 'Name must be filled',
            'jk.required' => 'Gender must be filled',
            'foto.required' => 'Photo cannot be empty',
            'tempatlahir.required' => 'Birthplace must be filled',
            'tanggallahir.required' => 'Date of birth must be filled',
            'agama.required' => 'Religion must be filled',
            'alamat.required' => 'Address must be filled',
            'email.required' => 'Email must be filled',
            'nohp.required' => 'Mobile phone must be filled',
            'gelombang.required' => 'Batch must be filled',
            'pil1.required' => 'Prodi choice must be filled',
            'pil2.required' => 'Prodi choice must be filled',
            'ayah.required' => 'Father`s name must be filled',
            'ibu.required' => 'Mother`s name must be filled',
            'pekerjaanayah.required' => 'Father`s occupation must be filled',
            'pekerjaanibu.required' => 'Mother`s occupation must be filled',
            'noayah.required' => 'Father`s phone number must be filled',
            'noibu.required' => 'Mother`s phone number must be filled',
            'gaji.required' => 'PaySlip must be filled',
            'tanggungan.required' => 'Family dependents must be filled',
            'ftgaji.required' => 'PaySlip cannot be empty',
            'ftkk.required' => 'Family card cannot be empty',
            'id_sekolah.required' => 'School name must be filled',
            'jurusan.required' => 'Major must be filled',
            'smt1.required' => 'Semester 1 must be filled',
            'smt2.required' => 'Semester 2 must be filled',
            'smt3.required' => 'Semester 3 must be filled',
            'smt4.required' => 'Semester 4 must be filled',
            'smt5.required' => 'Semester 5 must be filled',
            'ftraport.required' => 'Raport cannot be empty'
        ];

        $cekValidasi = $a->validate([
            'nisn' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'jk' => 'required',
            'foto' => 'required',
            'tempatlahir' => 'required',
            'tanggallahir' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'nohp' => 'required',
            'gelombang' => 'required',
            'pil1' => 'required',
            'pil2' => 'required',
            'ayah' => 'required',
            'ibu' => 'required',
            'pekerjaanayah' => 'required',
            'pekerjaanibu' => 'required',
            'noayah' => 'required',
            'noibu' => 'required',
            'gaji' => 'required',
            'tanggungan' => 'required',
            'ftgaji' => 'required',
            'ftkk' => 'required',
            'id_sekolah' => 'required',
            'jurusan' => 'required',
            'smt1' => 'required',
            'smt2' => 'required',
            'smt3' => 'required',
            'smt4' => 'required',
            'smt5' => 'required',
            'ftraport' => 'required'
        ], $message);

        $kodependaftaran = Pendaftaran::id();

        $file = $a->file('foto');
        if(file_exists($file)){
            $nama_file = "Pasfoto".time() . "-" . $file->getClientOriginalName();
            $namaFolder = 'data pendaftar/'.$kodependaftaran;
            $file->move($namaFolder,$nama_file);
            $pathFoto = $namaFolder."/".$nama_file;
        } else {
            $pathFoto = $a->pathFoto;
        }

        $fileftgaji = $a->file('ftgaji');
        if(file_exists($fileftgaji)){
            $nama_fileftgaji = "Slipgaji".time() . "-" . $fileftgaji->getClientOriginalName();
            $namaFolderftgaji = 'data pendaftar/'.$kodependaftaran;
            $fileftgaji->move($namaFolderftgaji,$nama_fileftgaji);
            $pathGaji = $namaFolderftgaji."/".$nama_fileftgaji;
        } else {
            $pathGaji = $a->pathGaji;
        }

        $fileftkk = $a->file('ftkk');
        if(file_exists($fileftkk)){
            $nama_fileftkk = "KartuKeluarga".time() . "-" . $fileftkk->getClientOriginalName();
            $namaFolderftkk = 'data pendaftar/'.$kodependaftaran;
            $fileftkk->move($namaFolderftkk,$nama_fileftkk);
            $pathKK = $namaFolderftkk."/".$nama_fileftkk;
        } else {
            $pathKK = $a->pathKk;
        }

        $fileftraport = $a->file('ftraport');
        if(file_exists($fileftraport)){
            $nama_fileftraport = "Raport".time() . "-" . $fileftraport->getClientOriginalName();
            $namaFolderftraport = 'data pendaftar/'.$kodependaftaran;
            $fileftraport->move($namaFolderftraport,$nama_fileftraport);
            $pathRaport = $namaFolderftraport."/".$nama_fileftraport;
        } else {
            $pathRaport = $a->pathRaport;
        }

        $fileftprestasi = $a->file('ftprestasi');
        if(file_exists($fileftprestasi)){
            $nama_fileftprestasi = "Prestasi".time() . "-" . $fileftprestasi->getClientOriginalName();
            $namaFolderftprestasi = 'data pendaftar/'.$kodependaftaran;
            $fileftprestasi->move($namaFolderftprestasi,$nama_fileftprestasi);
            $pathPrestasi = $namaFolderftprestasi."/".$nama_fileftprestasi;
        } else {
            $pathPrestasi = $a->pathPrestasi;
        }

        $fileftijazah = $a->file('ftijazah');
        if(file_exists($fileftijazah)){
            $nama_fileftijazah = "Ijazah".time() . "-" . $fileftijazah->getClientOriginalName();
            $namaFolderftijazah = 'data pendaftar/'.$kodependaftaran;
            $fileftijazah->move($namaFolderftijazah,$nama_fileftijazah);
            $pathIjazah = $namaFolderftijazah."/".$nama_fileftijazah;
        } else {
            $pathIjazah = $a->pathIjazah;
        }

        Pendaftaran::where("id_pendaftaran", "$id_pendaftaran")->update([
            'nisn' => $a->nisn,
            'nik' => $a->nik,
            'nama_siswa' => $a->nama,
            'jenis_kelamin' => $a->jk,
            'pas_foto' => $pathFoto,
            'tempat_lahir' => $a->tempatlahir,
            'tanggal_lahir' => $a->tanggallahir,
            'agama' => $a->agama,
            'alamat' => $a->alamat,
            'email' => $a->email,
            'nohp' => $a->nohp,
            'gelombang' => $a->gelombang,
            'tahun_masuk' => '2021',
            'pil1' => $a->pil1,
            'pil2' => $a->pil2,
            'nama_ayah' => $a->ayah,
            'nama_ibu' => $a->ibu,
            'pekerjaan_ayah' => $a->pekerjaanayah,
            'pekerjaan_ibu' => $a->pekerjaanibu,
            'nohp_ayah' => $a->noayah,
            'nohp_ibu' => $a->noibu,
            'gaji' => $a->gaji,
            'tanggungan' => $a->tanggungan,
            'slip_gaji' =>  $pathGaji,
            'kk' => $pathKK,
            'id_Sekolah' => $a->id_sekolah,
            'jurusan' => $a->jurusan,
            'smt1' => $a->smt1,
            'smt2' => $a->smt2,
            'smt3' => $a->smt3,
            'smt4' => $a->smt4,
            'smt5' => $a->smt5,
            'nilairaport' => $pathRaport,
            'ijazah' => $pathIjazah,
            'prestasi' => $pathPrestasi
        ]);
        Timeline::create([
            'id_user' => $a->userid,
            'status' => "Mengedit Pendaftaran"
        ]);
        return redirect('/data-registration')->with('success', 'Data Terubah!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Diubah!');
        }
    }

    public function hapuspendaftaran($id_pendaftaran){
        //$dataUser = ProfileUsers::all();
        try{
            $data = Pendaftaran::find($id_pendaftaran);
            File::delete($data->foto);
            File::delete($data->slip_gaji);
            File::delete($data->kk);
            File::delete($data->nilai_raport);
            File::delete($data->ijazah);
            File::delete($data->prestasi);
            $data->delete();
            $dataPembayaran = Pembayaran::where("id_pendaftaran",$id_pendaftaran)->get();
            foreach($dataPembayaran as $x){
                if($x->id_pendaftaran==$id_pendaftaran){
                    $dataPembayaranhapus = Pembayaran::find($x->id_pembayaran);
                    File::delete($dataPembayaranhapus->bukti_pembayaran);
                    $dataPembayaranhapus->delete();
                }
            }
            $dataPengumuman = Pengumuman::where("id_pendaftaran",$id_pendaftaran)->get();
            foreach($dataPengumuman as $x){
                if($x->id_pendaftaran==$id_pendaftaran){
                    $dataPengumumanhapus = Pengumuman::find($x->id_pengumuman);
                    $dataPengumumanhapus->delete();
                }
            }
            return redirect('/data-registration')->with('success', 'Data Terhapus!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus!');
        }
    }

    public function detailpendaftaran($id_pendaftaran)
    {
        $dataUser = ProfileUsers::all();
        $dataprod = ProgramStudi::all();
        $dataSekolah = Sekolah::all();
        $datPembayaran = Pembayaran::where("id_pendaftaran",$id_pendaftaran)->first();
        $no=1;
        
        $data = Pendaftaran::where("id_pendaftaran",$id_pendaftaran)->first();
        $datapembayaran = Pendaftaran::where("id_pendaftaran", $id_pendaftaran)->get();
        return view('pendaftaran.data-pendaftaran-detail', ['viewDataUser' => $dataUser,'viewDataPembayaran' => $datPembayaran,'viewDataPembayaran' => $datapembayaran,'viewData' => $data,'viewSekolah' => $dataSekolah,'viewProdi' => $dataprod]);
    }

    public function kartupendaftaran($id_pendaftaran)
    {
        $dataUser = ProfileUsers::all();
        $dataprod = ProgramStudi::all();
        $dataSekolah = Sekolah::all();
        $data = Pendaftaran::find($id_pendaftaran);
        return view('pendaftaran.data-pendaftaran-kartu-admin', ['viewDataUser' => $dataUser,'viewData' => $data,'viewSekolah' => $dataSekolah,'viewProdi' => $dataprod]);
    }
}
