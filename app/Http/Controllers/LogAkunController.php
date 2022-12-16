<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfileUsers;
use App\Models\Timeline;
use File;
use Alert;


class LogAkunController extends Controller
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

    //profil
    public function dataprofil(){
        $dataUser = ProfileUsers::all();
        $kode = User::all();
        return view ('profil',['viewDataUser' => $dataUser,'viewData' => $dataUser,'id'=>$kode]);
    }

    //
    public function editprofil(Request $a){
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

            ProfileUsers::where("Id_user", $a->id)->update([
                'Foto' => $pathFoto,
                'Tempat_lahir' => $a->tempat,
                'Tanggal_lahir' => $a->tanggal,
                'Gender' => $a->jk,
                'No_Hp' => $a->hp,
                'Alamat' => $a->alamat,
                'Instagram' => $a->ig
            ]);

            Timeline::create([
                'id_user' => $a->userid,
                'status' => "Mengedit profilnya"
            ]);
            return redirect('/profile')->with("toastr-success",'data berhasil disimpan');

    }

    public function editakun(Request $a){
        $dataUser = ProfileUsers::all();
        $message = [
            //'name.required' => 'Nama tidak boleh kosong',
           // 'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ];

        $cekValidasi = $a->validate([
           // 'name' => 'required|min:3|max:255|unique:users',
            //'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:255'
        ], $message);

        $cekValidasi['password'] = Hash::make($cekValidasi['password']);
        //ProfileUsers::where("Id_user", $a->Id_user)->update([
           // 'Nama' => $a->nama,
            //'Email' => $a->email,
        //]);
        User::where("id", $a->id)->update([
            //'nama' => $a->nama,
            //'email' => $a->email,
            'password' => $cekValidasi['password']
        ]);
        Timeline::create([
            'id_user' => $a->userid,
            'status' => "Mengedit kata sandinya"
        ]);
        return redirect('/profile')->with("toastr-success",'data berhasil disimpan');
    }
}
