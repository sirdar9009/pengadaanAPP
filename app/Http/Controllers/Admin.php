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

//memanggil model admin
use App\M_Admin;

class Admin extends Controller
{
    //menampilkan halaman login admin
    public function index(){

      return view('admin.login');
    }

    public function loginAdmin(Request $request){
      $this->validate($request,
      [
        'email' => 'required',
        'password' => 'required'
      ]
    );
    $cek = M_Admin::where('email',$request->email)->count();


    $adm = M_Admin::where('email',$request->email)->get();
    if($cek > 0){
      foreach($adm as $ada){
        if(decrypt($ada->password) == $request->password){
          $key = env('APP_KEY');
          $data = array(
            "id_admin" => $ada->id_admin,
          );
          $jwt = JWT::encode($data,$key);
          M_Admin::where('id_admin',$ada->id_admin)->update([
            "token"=> $jwt,
          ]);
          session::put('token',$jwt);

          return redirect('/pengajuan')->with('berhasil','selamat datang');

        }else{
          return redirect('/masukAdmin')->with('gagal','password anda salah');
        }
      }

    }else{
      return redirect('/masukAdmin')->with('gagal','Password Salah');
    }

    }

    public function keluarAdmin(){
      $token = Session::get('token');
      if (M_Admin::where('token',$token)->update(
        [
          'token'=> 'keluar',
        ]
      )){
        session::put('token',"");
        return redirect('/masukAdmin')->with('berhasil','Anda sudah berhasil Logut');
      }else{
        return redirect('/masukAdmin')->with('gagal','Anda gagal Logut, silahkan Login terlebihdahulu');
      }
    }

    public function listAdmin(){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb > 0){
          $data['adm'] = M_Admin::where('token',$token)->first();
          $data['admin']= M_Admin::where('status','1')->paginate(15);
          return view('admin.list',$data);
      }else{
        return redirect('/masukAdmin')->with('gagal','Anda belum Login, silahkan Login terlebihdahulu');
      }
    }

    public function tambahAdmin(Request $request){
      $this->validate ($request,
      [
        'nama'	=> 'required',
        'email'		=> 'required',
        'alamat' => 'required',
        'password' => 'required'
      ]);
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb > 0){
        if (M_Admin::create([
          "nama" => $request->nama,
          "email"=> $request->email,
          "alamat"=> $request->alamat,
          "password"=> Encrypt($request->password)
          ])){
              return redirect('/listAdmin')->with('berhasil','Data berhasil disimpan');
        }else{
            return redirect('/listAdmin')->with('gagal','Data gagal disimpan');
        }
      }else{
        return redirect('/masukAdmin')->with('gagal','Silahkan Login terlebih dahulu');
      }
    }

    public function ubahAdmin(Request $request){
      $this->validate ($request,
      [
        'ub_nama'	=> 'required',
        'ub_email'		=> 'required',
        'ub_alamat' => 'required'
      ]);
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb > 0){
        if (M_Admin::where('id_admin',$request->id_admin)->update([
          "nama" => $request->ub_nama,
          "email"=> $request->ub_email,
          "alamat"=> $request->ub_alamat
          ])){
              return redirect('/listAdmin')->with('berhasil','Data berhasil diubah');
        }else{
            return redirect('/listAdmin')->with('gagal','Data gagal diubah');
        }
      }else{
        return redirect('/masukAdmin')->with('gagal','Silahkan Login terlebih dahulu');
      }
    }

    public function hapusAdmin($id){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb > 0){
        if (M_Admin::where('id_admin',$id)->delete()){
              return redirect('/listAdmin')->with('berhasil','Data berhasil dihapus');
        }else{
            return redirect('/listAdmin')->with('gagal','Data gagal dihapus');
        }
      }else{
        return redirect('/masukAdmin')->with('gagal','Silahkan Login terlebih dahulu');
      }
    }

    public function ubahPassword_adm(Request $request){
      $key = env('APP_KEY');
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb > 0){
        $adm=M_Admin::where('token',$token)->first();
        $decode = JWT::decode($token,$key,array('HS256'));
        $decode_array = (array) $decode;
          if(decrypt($adm->password)==$request->passwordlama){
            if(M_Admin::where('id_admin',$decode_array['id_admin'])->update(
              [
              "password" => encrypt($request->password)
              ]
            )){
              return redirect('/masukAdmin')->with('gagal','Password Berhasil diUbah');
            }else{
              return redirect('/pengajuan')->with('gagal','Password Gagal diUbah');
            }
        }else{
            return redirect('/pengajuan')->with('gagal','Password Lama Tidak Sesuai');
        }
      }else{
        return redirect('/masukAdmin')->with('gagal','Anda belum Login, silahkan Login terlebihdahulu');
      }
    }



}
