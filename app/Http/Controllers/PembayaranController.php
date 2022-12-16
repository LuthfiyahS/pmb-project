<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranController extends Controller
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
    

    //data pembayaran komplit
    public function datapembayaran(){
        $dataUser = Pengguna::all();
        $data = Pembayaran::all();
        $dataid = Pendaftaran::all();
        return view ('data-pembayaran-admin',['viewDataUser' => $dataUser,'viewData' => $data,'viewIdPendaftaran' => $dataid]);
    }

    public function simpanpembayaran(Request $a)
    {
        try{
        //$dataUser = Pengguna::all();
        $kode = Pembayaran::id();
        $file = $a->file('bukti');
        $kodependaftaran = $a->id_pendaftaran;
        $nama_file = "payment-".time() . "-" . $file->getClientOriginalName();
        $namaFolder = 'data pendaftar/'.$kodependaftaran;
        $file->move($namaFolder,$nama_file);
        $pathBukti = $namaFolder."/".$nama_file;
        Pembayaran::create([
            'id_pembayaran' => $kode,
            'bukti_pembayaran' => $pathBukti,
            'status_pembayaran'=> $a->status,
            'id_pendaftaran' =>$a->id_pendaftaran
        ]);
        Timeline::create([
            'id_user' => $a->userid,
            'status' => "Memperbaharui Pembayaran"
        ]);
        return redirect('/data-payment')->with('success', 'Data Tersimpan!!');
    } catch (\Exception $e){
        return redirect()->back()->with('error', 'Data Tidak Berhasil Disimpan!');
    }
    }
    public function updatepembayaran(Request $a, $id_pembayaran){
        //$dataUser = Pengguna::all();
        try{
            $file = $a->file('bukti');
            if(file_exists($file)){
                $kodependaftaran = $a->id_pendaftaran;
                $nama_file = "payment-".time() . "-" . $file->getClientOriginalName();
                $namaFolder = 'data pendaftar/'.$kodependaftaran;
                $file->move($namaFolder,$nama_file);
                $pathBukti = $namaFolder."/".$nama_file;
            } else {
                $pathBukti = $a->pathnya;
            }
            
            Pembayaran::where("id_pembayaran", "$id_pembayaran")->update([
                'bukti_pembayaran' => $pathBukti,
                'status_pembayaran'=> $a->status,
                'id_pendaftaran' =>$a->id_pendaftaran
            ]);
            Timeline::create([
                'id_user' => $a->userid,
                'status' => "Memperbaharui Pembayaran"
            ]);
            return redirect('/data-payment')->with('success', 'Data Terubah!!');
        

        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Diubah!');
        }
    }
    public function updatebuktipembayaran(Request $a){
        //$dataUser = Pengguna::all();
        try{
            $file = $a->file('pem');
            //if(file_exists($file)){
                $kodependaftaran = $a->id_pendaftaran;
                $nama_file = "payment-".time()."-".$file->getClientOriginalName();
                $namaFolder = 'data pendaftar/'.$kodependaftaran;
                $file->move($namaFolder,$nama_file);
                $pathBukti = $namaFolder."/".$nama_file;
            //} else {
              //  $pathBukti = $a->pathnya;
            //}
            $dataSaatini=Pembayaran::where("id_pendaftaran", "$a->id_pendaftaran")->get();
            foreach($dataSaatini as $x){
                if($x->id_pendaftaran==$a->id_pendaftaran){
                    Pembayaran::where("id_pembayaran", "$x->id_pembayaran")->update([
                        'bukti_pembayaran' => $pathBukti,
                        'status_pembayaran'=> "Dibayar",
                        'id_pendaftaran' =>$x->id_pendaftaran
                    ]);
                    Timeline::create([
                        'id_user' => $a->userid,
                        'status' => "Mengupload bukti pembayaran"
                    ]);
                }
            }
            
            return redirect('/detail-registration'.'/'.$a->id_pendaftaran)->with('success', 'Data Terubah!!');
        

        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Diubah!');
        }
    }

    public function hapuspembayaran($id_pembayaran){
        //$dataUser = Pengguna::all();
        try{
            $data = Pembayaran::find($id_pembayaran);
            $data->delete();
            return redirect('/data-payment')->with('success', 'Data Terhapus!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus!');
        }
    }

    public function verifikasipembayaran($id_pembayaran){
        //$dataUser = Pengguna::all();
        Pembayaran::where("id_pembayaran", "$id_pembayaran")->update([
            'status_pembayaran' => "Dibayar"
        ]);

        Timeline::create([
            'id_user' => $id_pembayaran,
            'status' => "Melakukan verifikasi pembayaran"
        ]);
        return redirect('/data-payment');
    }

    public function belumbayar($id_pembayaran){
        //$dataUser = Pengguna::all();
        Pembayaran::where("id_pembayaran", "$id_pembayaran")->update([
            'status_pembayaran' => "Belum Bayar"
        ]);

        Timeline::create([
            'id_user' => $id_pembayaran,
            'status' => "Mengganti status Pembayaran"
        ]);
        return redirect('/data-payment');
    }

    public function invalidbayar($id_pembayaran){
        //$dataUser = Pengguna::all();
        Pembayaran::where("id_pembayaran", "$id_pembayaran")->update([
            'status_pembayaran' => "Tidak Sah"
        ]);

        Timeline::create([
            'id_user' => $id_pembayaran,
            'status' => "Mengganti status Pembayaran"
        ]);
        return redirect('/data-payment');
    }
}
