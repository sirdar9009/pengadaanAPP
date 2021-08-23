<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import library Session
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator; //untuk memanggil library validate

use Illuminate\Contracts\Encryption\DecryptException;//memanggil fungsi enkripsi data

use App\M_Suplier; //Memanggil Model M_Suplier

class Registrasi extends Controller
{
    //fungsi untuk ambil view registrasi
    public function index()
    {

      $token = Session::get('token');
      $tokenDb = M_Suplier::where('token',$token)-> count();
          if ($tokenDb>0){
            $data['token']= $token;
          }else{
            $data['token']="kosong";
          }

      return view('registrasi.registrasi',$data);
    }

    //fungsi untuk menyimpan data dari view ke database
    public function regis(Request $request)
    {
      //validasi bawaan laravel untuk validasi inputan form tidak boleh kosong
      $this->validate($request,
        [
          'nama_usaha'=>'required',
          'email'=>'required',
          'alamat'=>'required',
          'npwp'=>'required',
          'password'=>'required'
        ]
      );
      //menggunakan Model di laravel menggunakan "::"
      //fungsi untuk menyimpan inputan di view ke database
      if (M_Suplier::create(
        [
          'nama_usaha'=>$request->nama_usaha,
          'email'=>$request->email,
          'alamat'=>$request->alamat,
          'no_npwp'=>$request->npwp,
          'password'=>encrypt($request->password)
        ]
      )){
        return redirect('/registrasi')->with('berhasil','Data berhasil disimpan');

      }else{
        return redirect('/registrasi')->with('gagal','Terjadi kesalahan, Data gagal disimpan');
      }

    }
}
