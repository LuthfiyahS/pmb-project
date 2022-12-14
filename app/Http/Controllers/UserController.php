<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ProfileUsers;
use App\Models\Timeline;

class UserController extends Controller
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

    //data user
    public function datauser(){
        $dataUser = User::all();
        $kode = ProfileUsers::id();
        return view ('user.data-user-admin',compact('dataUser','kode'));
    }

    public function simpanuser(Request $a)
    {
        //dd('Regist Berhasil');
        //return redirect('/data-user')->with('berhasil','data berhasil disimpanI');
    try{
        $a->password = Hash::make($a->password);
        $usersid=ProfileUsers::id();
        User::create([
            'name' => $a->nama,
            'email' => $a->email,
            'password' => $a->password,
            'role' => $a->level,
            'user_id'=>$usersid,
        ]);
    	$file = $a->file('foto');
            if(file_exists($file)){
                $nama_file = time() . "-" . $file->getClientOriginalName();
                $namaFolder = 'foto profil';
                $file->move($namaFolder,$nama_file);
                $pathFoto = $namaFolder."/".$nama_file;
            } else {
                $pathFoto = $a->pathFoto;
            }
        ProfileUsers::create([
            'user_id' => $usersid,
            'nama' => $a->nama,
            'email' => $a->email,
            'tanggal_lahir' => "2000-01-01",
            'gender' => $a->gender,
            'no_hp' => $a->nohp,
            'foto' => $pathFoto
        ]);
        Timeline::create([
            'user_id' => $a->userid,
            'status' => "Membuat user baru"
        ]);
        return redirect('/data-user')->with('success', 'Data Tersimpan!');
    }catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Tersimpan!');
    }
    }

    public function edituser($user_id)
    {
        $dataUser = ProfileUsers::all();
        $dataUserbyId = ProfileUsers::find($user_id);
        return view('user.data-user-detail',['viewDataUser' => $dataUser,'viewData'=>$dataUserbyId]);
    }


    public function updateuser($nim,Request $a)
    {
     try{
        $dataUser = ProfileUsers::all();
            $message = [
                'tempat.required' => 'Tempat lahir tidak boleh kosong',
                'tanggal.required' => 'Tanggal lahir tidak boleh kosong',
                'jk.required' => 'Jenis Kelamin harus dipilih',
                'hp.required' => 'Family card cannot be empty',
                'alamat.required' => 'School name must be filled',
                'ig.required' => 'Major must be filled',
            ];

            $cekValidasi = $a->validate([
                'tempat' => 'required',
                'tanggal' => 'required',
                'jk' => 'required',
                'hp' => 'required',
                'alamat' => 'required',
                'ig' => 'required'
            ], $message);

            $file = $a->file('foto');
            if(file_exists($file)){
                $nama_file = time() . "-" . $file->getClientOriginalName();
                $namaFolder = 'foto profil';
                $file->move($namaFolder,$nama_file);
                $pathFoto = $namaFolder."/".$nama_file;
            } else {
                $pathFoto = $a->pathFoto;
            }

            ProfileUsers::where("user_id", $a->id)->update([
                'foto' => $pathFoto,
                'tempat_lahir' => $a->tempat,
                'tanggal_lahir' => $a->tanggal,
                'gender' => $a->jk,
                'no_hp' => $a->hp,
                'alamat' => $a->alamat,
                'instagram' => $a->ig
            ]);
            Timeline::create([
                'user_id' => $a->userid,
                'status' => "Mengedit User"
            ]);
            return redirect('/data-user')->with("success",'Data Berhasil Diubah');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Diubah!');
        }
    }

    public function hapususer($user_id){
        //$dataUser = ProfileUsers::all();
    try{
        $dataProfileUsers = ProfileUsers::find($user_id);
        $id=$dataProfileUsers['Email'];
        $dataUser = User::where('email',$id);
        $dataProfileUsers->delete();
        $dataUser->delete();
        return redirect('/data-user')->with("success",'Data Berhasil Dihapus');
    }catch (\Exception $e){
        return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus!');
    }
    }
}
