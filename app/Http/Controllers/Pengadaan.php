<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import library Session
use Illuminate\Support\Facades\Session;

//import library Storage
use Illuminate\Support\Facades\Storage;

//import lib JWT
use \Firebase\JWT\JWT;

//import Lib Respon
use Illuminate\Response;

use Illuminate\Support\Facades\Validator; //untuk memanggil library validate

use Illuminate\Contracts\Encryption\DecryptException;//memanggil fungsi enkripsi data

use App\M_Admin;

use App\M_Pengadaan;

use App\M_Suplier;

class Pengadaan extends Controller
{
    //
    public function index()
    {
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if($tokenDb > 0){
        $tampil['adm'] = M_Admin::where('token',$token)->first();
        $tampil ['dataDb'] = M_Pengadaan::where('status','1')->paginate(15);

        return view('pengadaan.list',$tampil);
      }else{
        return redirect('/masukAdmin')->with('gagal','Silahkan login terlebih dahulu');
      }
    }

    public function simpanPengadaan(Request $request){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if($tokenDb > 0){
        $this->validate ($request,
        [
          'nama_pengadaan'=>'required',
          'deskripsi'=>'required',
          'gambar'=>'required|image|mimes:jpg,png,jpeg,gif|max:10000',
          'anggaran'=>'required'
        ]);
        $path = $request->file('gambar')->store('public/gambar');
         if(M_Pengadaan::create([
           "nama_pengadaan"=>$request->nama_pengadaan,
           "deskripsi"=>$request->deskripsi,
           "gambar"=>$path,
           "anggaran"=>$request->anggaran
           ])){
             return redirect('/listPengadaan')->with('berhasil','Data berhasil disimpan');
        }else{
            return redirect('/listPengadaan')->with('gagal','Data Gagal disimpan');
        }
      }else{
          return redirect('/masukAdmin')->with('gagal','Silahkan login terlebih dahulu');
      }
    }

    public function hapusGambar($id){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb>0){
        $pengadaan = M_Pengadaan::where('id_pengadaan', $id)-> count();
        if($pengadaan > 0){
          $dataTerpilih = M_Pengadaan::where('id_pengadaan',$id)->first();

          if(Storage::delete($dataTerpilih->gambar)){

            if(M_Pengadaan::where('id_pengadaan', $id)->update(["gambar"=>""])){
              return redirect('/listPengadaan')->with('berhasil','Gambar berhasil dihapus');
            }else{
              return redirect('/listPengadaan')->with('gagal','Gambar gagal dihapus');
            }

          }else{
            return redirect('/listPengadaan')->with('gagal','Gambar gagal dihapus');
          }

        }else{
          return redirect('/listPengadaan')->with('gagal','Data Tidak ditemukan');
        }

      }else{
        return redirect('/masukAdmin')->with('gagal','Silahkan login terlebih dahulu');
      }

    }


    public function uploadGambar(Request $request){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if($tokenDb > 0){
        $this->validate ($request,
        [
          'gambar'=>'required|image|mimes:jpg,png,jpeg,gif|max:10000'
        ]);
        $path = $request->file('gambar')->store('public/gambar');
         if(M_Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
           "gambar"=>$path
           ])){
             return redirect('/listPengadaan')->with('berhasil','Data berhasil disimpan');
        }else{
            return redirect('/listPengadaan')->with('gagal','Data Gagal disimpan');
        }
      }else{
          return redirect('/masukAdmin')->with('gagal','Silahkan login terlebih dahulu');
      }
    }

    public function ubahPengadaan(Request $request){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if($tokenDb > 0){
        $this->validate ($request,
        [
          'ubahnama_pengadaan'=>'required',
          'ubahdeskripsi'=>'required',
          'ubahanggaran'=>'required'
        ]);

         if(M_Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
           "nama_pengadaan"=>$request->ubahnama_pengadaan,
           "deskripsi"=>$request->ubahdeskripsi,
           "anggaran"=>$request->ubahanggaran
           ])){
             return redirect('/listPengadaan')->with('berhasil','Data berhasil diubah');
        }else{
            return redirect('/listPengadaan')->with('gagal','Data Gagal diubah');
        }
      }else{
          return redirect('/masukAdmin')->with('gagal','Silahkan login terlebih dahulu');
      }
    }

    public function hapusPengadaan($id){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb>0){
        $pengadaan = M_Pengadaan::where('id_pengadaan', $id)-> count();
        if($pengadaan > 0){
          $dataTerpilih = M_Pengadaan::where('id_pengadaan',$id)->first();

          if(Storage::delete($dataTerpilih->gambar)){

            if(M_Pengadaan::where('id_pengadaan', $id)->delete()){
              return redirect('/listPengadaan')->with('berhasil','Gambar berhasil dihapus');
            }else{
              return redirect('/listPengadaan')->with('gagal','Data gagal dihapus');
            }

          }else{
            return redirect('/listPengadaan')->with('gagal','Data gagal dihapus');
          }

        }else{
          return redirect('/listPengadaan')->with('gagal','Data Tidak ditemukan');
        }

      }else{
        return redirect('/masukAdmin')->with('gagal','Silahkan login terlebih dahulu');
      }

    }

    public function listSuplier()
    {
      $token = Session::get('token');
      $tokenDb = M_Suplier::where('token',$token)->count();
      if($tokenDb > 0){

        $tampil ['sup'] = M_Suplier::where('token',$token)->first();
        $tampil ['dataDb'] = M_Pengadaan::where('status','1')->paginate(15);

        return view('login_sup.pengadaan',$tampil);
      }else{
        return redirect('/masukSuplier')->with('gagal','Silahkan login terlebih dahulu');
      }
    }

}
