<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import library Session
use Illuminate\Support\Facades\Session;

//import lib JWT
use \Firebase\JWT\JWT;

//import Lib Respon
use Illuminate\Response;

use Illuminate\Support\Facades\Validator; //untuk memanggil library validate

use Illuminate\Contracts\Encryption\DecryptException;//memanggil fungsi enkripsi data

//Memanggil Model M_Suplier
use App\M_Suplier;
use App\M_Admin;

class Suplier extends Controller
{
    //fungsi u menampilakn halaman login
    public function login(){
      return view('login_sup.login');
    }

    public function masukSuplier(Request $request){
      $this->validate($request,
      [
        'email'=>'required',
        'password'=>'required'
      ]);

      $cek = M_Suplier::where('email',$request->email)->count();


      $sup = M_Suplier::where('email',$request->email)->get();
      if($cek > 0){
        //email terdaftar
        foreach ($sup as $terdaftar) {
          if(decrypt($terdaftar->password) == $request->password){
            //jika password benar
            $key = env('APP_KEY' );
            $data = array(
                "id_supplier" => $terdaftar->id_supplier
            );
            $jwt = JWT::encode($data, $key);
              if(M_Suplier::where('id_supplier',$terdaftar->id_supplier)->update(
                [
                  'token' => $jwt
                ]
              )){
                  //berhasil update
                  Session::put('token',$jwt);
                  return redirect('/listSuplier');
              }else{
                return redirect('/login')->with('gagal','Token gagal diupdate');
              }

          }else{
            return redirect('/login')->with('gagal','Password Salah');
          }
        }

      }else{
        return redirect('/login')->with('gagal','Email Tidak Terdaftar');
      }
    }

    public function suplierKeluar(){

      $token = Session::get('token');
      if(M_Suplier::where('token',$token)->update(

        [
          'token' => 'keluar',
        ]
      )){
        session::put('token',"-");
        return redirect('/')->with('berhasil','Anda telah Logout');
      }else{
        return redirect('/login')->with('gagal','Anda gagal Logut, silahkan Login terlebihdahulu');
      }
    }

    public function dataSuplier(){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb > 0){
          $tampil['adm'] = M_Admin::where('token',$token)->first();
          $tampil['suplier']= M_Suplier::paginate(15);
          return view('admin.tampilSuplier',$tampil);
      }else{
        return redirect('/login')->with('gagal','Anda belum Login, silahkan Login terlebihdahulu');
      }
    }

    public function nonaktifSuplier($id){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb > 0){
        if(M_Suplier::where('id_supplier',$id)->update(
          [
          "status" => "0"
          ]
        )){
          return redirect('/dataSuplier')->with('berhasil','Data Suplier Berhasil diUpdate');
        }else{
          return redirect('/dataSuplier')->with('gagal','Data Suplier Gagal diUpdate');
        }
      }else{
        return redirect('/masukAdmin')->with('gagal','Anda belum Login, silahkan Login terlebihdahulu');
      }
    }

    public function aktifSuplier($id){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb > 0){
        if(M_Suplier::where('id_supplier',$id)->update(
          [
          "status" => "1"
          ]
        )){
          return redirect('/dataSuplier')->with('berhasil','Data Suplier Berhasil diUpdate');
        }else{
          return redirect('/dataSuplier')->with('gagal','Data Suplier Gagal diUpdate');
        }
      }else{
        return redirect('/masukAdmin')->with('gagal','Anda belum Login, silahkan Login terlebihdahulu');
      }
    }

    public function ubahPassword_sup(Request $request){
      $key = env('APP_KEY');
      $token = Session::get('token');
      $tokenDb = M_Suplier::where('token',$token)->count();
      if ($tokenDb > 0){
        $sup=M_Suplier::where('token',$token)->first();
        $decode = JWT::decode($token,$key,array('HS256'));
        $decode_array = (array) $decode;
          if(decrypt($sup->password)==$request->passwordlama){
            if(M_Suplier::where('id_supplier',$decode_array['id_supplier'])->update(
              [
              "password" => encrypt($request->password)
              ]
            )){
              return redirect('/login')->with('gagal','Password Berhasil diUbah');
            }else{
              return redirect('/listSuplier')->with('gagal','Password Gagal diUbah');
            }
        }else{
            return redirect('/listSuplier')->with('gagal','Password Lama Tidak Sesuai');
        }
      }else{
        return redirect('/login')->with('gagal','Anda belum Login, silahkan Login terlebihdahulu');
      }
    }

}
