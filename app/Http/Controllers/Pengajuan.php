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
use App\M_Pengajuan;
use App\M_Suplier;
use App\M_Pengadaan;
use App\M_Laporan;

class Pengajuan extends Controller
{
    //menampilkan halaman list Pengajuan di Admin
    public function pengajuan(){
      $key = env('APP_KEY');
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
        if ($tokenDb>0){
          $pengajuan = M_Pengajuan::where('status','1')->paginate(15);
          $dataP = array();
          foreach($pengajuan as $p){
            $pengadaan = M_Pengadaan::where('id_pengadaan',$p->id_pengadaan)->first();
            $sup = M_Suplier::where('id_supplier',$p->id_suplier)->first();
            $dataP[] = array(
              "id_pengajuan" => $p->id_pengajuan,
              "gambar" => $pengadaan->gambar,
              "nama_pengadaan" => $pengadaan->nama_pengadaan,
              "anggaran_pengadaan" => $pengadaan->anggaran,
              "anggaran_pengajuan" => $p->anggaran,
              "proposal" => $p->proposal,
              "nama_suplier" => $sup->nama_usaha,
              "email" => $sup->email,
              "alamat" => $sup->alamat,
              "status" => $p->status
            );
          }
          $data['adm'] = M_Admin::where('token',$token)->first();

          $data['pengajuan'] = $dataP;
          return view('pengajuan.list',$data);
        }else{
            return redirect('/masukAdmin')->with('gagal','Silahkan Login sebagai Admin dahulu');
        }
    }


    public function buatPengajuan(Request $request){
      $token = Session::get('token');
      $tokenDb = M_Suplier::where('token',$token)->count();
      $key = env('APP_KEY');
      $decode = JWT::decode($token,$key,array('HS256'));
      $decode_array = (array) $decode;

      if($tokenDb > 0){
        $this->validate ($request,
        [
          'id_pengadaan'=>'required',
          'proposal'=>'required|mimes:pdf|max:10000',
          'anggaran'=>'required'
        ]);
        $cekPengajuan = M_Pengajuan::where('id_suplier',$decode_array['id_supplier'])->where('id_pengadaan',$request->id_pengadaan)->count();
        if ($cekPengajuan == 0){

          $path = $request->file('proposal')->store('public/proposal');
           if(M_Pengajuan::create([
             "id_pengadaan"=>$request->id_pengadaan,
             "id_suplier"=>$decode_array['id_supplier'],
             "proposal"=>$path,
             "anggaran"=>$request->anggaran
             ])){
               return redirect('/listSuplier')->with('berhasil','Pengajuan Anda Berhasil Dibuat, Mohon Tunggu validasi dari Admin');
          }else{
              return redirect('/listSuplier')->with('gagal','Pengajuan Gagal, Silahkan Menghubungi Admin atau Buat Pengjuan Ulang');
          }


        }else{
          return redirect('/listSuplier')->with('gagal','Anda sudah Pernah Mengajukan Pengadaan ini');
        }
      }else{
          return redirect('/login')->with('gagal','Silahkan login terlebih dahulu');
      }
    }

    public function terimaPengajuan($id){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
        if ($tokenDb>0){
          if(M_Pengajuan::where('id_pengajuan',$id)->update(
            [
              "status"=>"2"
            ]
          )){
              return redirect('/pengajuan')->with('berhasil','Status Pengajuan Berhasil diubah');
          }else{
            return redirect('/pengajuan')->with('gagal','Status Pengajuan gagal diubah');
          }
        }else{
          return redirect('/masukAdmin')->with('gagal','Silahkan Login sebagai Admin dahulu');
        }

    }

    public function tolakPengajuan($id){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
        if ($tokenDb>0){
          if(M_Pengajuan::where('id_pengajuan',$id)->update(
            [
              "status"=>"0"
            ]
          )){
              return redirect('/pengajuan')->with('berhasil','Status Pengajuan Berhasil diubah');
          }else{
            return redirect('/pengajuan')->with('gagal','Status Pengajuan gagal diubah');
          }
        }else{
          return redirect('/masukAdmin')->with('gagal','Silahkan Login sebagai Admin dahulu');
        }

    }

    public function riwayatPengajuan(){
      $token = Session::get('token');
      $tokenDb = M_Suplier::where('token',$token)->count();
      $key = env('APP_KEY');
      $decode = JWT::decode($token,$key,array('HS256'));
      $decode_array = (array) $decode;

      if($tokenDb > 0){
        $pengajuan = M_Pengajuan::where('id_suplier',$decode_array['id_supplier'])->get();
        $dataArr=array();
        foreach($pengajuan as $p){
          $pengadaan = M_Pengadaan::where('id_pengadaan',$p->id_pengadaan)->first();
          $sup = M_Suplier::where('id_supplier',$decode_array['id_supplier'])->first();
          $lapCount = M_Laporan::where('id_pengajuan',$p->id_pengajuan)->count();
          $lap = M_Laporan::where('id_pengajuan',$p->id_pengajuan)->first();
          if($lapCount>0){
            $lapLink = $lap->laporan;
          }else{
            $lapLink = "";
          }

          $dataArr[]=array(
            "id_pengajuan" => $p->id_pengajuan,
            "gambar" => $pengadaan->gambar,
            "nama_pengadaan" => $pengadaan->nama_pengadaan,
            "anggaran_pengadaan" => $pengadaan->anggaran,
            "anggaran_pengajuan" => $p->anggaran,
            "proposal" => $p->proposal,
            "nama_suplier" => $sup->nama_usaha,
            "email" => $sup->email,
            "alamat" => $sup->alamat,
            "status" => $p->status,
            "laporan" => $lapLink
          );
        }
        $tampil['adm'] = M_Admin::where('token',$token)->first();

        $data['sup'] = M_Suplier::where('token',$token)->first();
        $data['pengajuan']=$dataArr;
        return view('login_sup.pengajuan_riwayat',$data);

      }else{
        return redirect('/login')->with('gagal','Silahkan login terlebih dahulu');
      }

    }

    public function PengajuanSelesai(){
      $token = Session::get('token');
      $tokenDb = M_Suplier::where('token',$token)->count();
      $key = env('APP_KEY');
      $decode = JWT::decode($token,$key,array('HS256'));
      $decode_array = (array) $decode;

      if($tokenDb > 0){
        $pengajuan = M_Pengajuan::where('id_suplier',$decode_array['id_supplier'])->where('status','3')->get();
        $dataArr=array();
        foreach($pengajuan as $p){
          $pengadaan = M_Pengadaan::where('id_pengadaan',$p->id_pengadaan)->first();
          $sup = M_Suplier::where('id_supplier',$decode_array['id_supplier'])->first();
          $lapCount = M_Laporan::where('id_pengajuan',$p->id_pengajuan)->count();
          $lap = M_Laporan::where('id_pengajuan',$p->id_pengajuan)->first();
          if($lapCount>0){
            $lapLink = $lap->laporan;
          }else{
            $lapLink = "";
          }

          $dataArr[]=array(
            "id_pengajuan" => $p->id_pengajuan,
            "gambar" => $pengadaan->gambar,
            "nama_pengadaan" => $pengadaan->nama_pengadaan,
            "anggaran_pengadaan" => $pengadaan->anggaran,
            "anggaran_pengajuan" => $p->anggaran,
            "proposal" => $p->proposal,
            "nama_suplier" => $sup->nama_usaha,
            "email" => $sup->email,
            "alamat" => $sup->alamat,
            "status" => $p->status,
            "laporan" => $lapLink
          );
        }
        $data['sup'] = M_Suplier::where('token',$token)->first();
        $data['pengajuan']=$dataArr;
        return view('login_sup.pengajuan_selesai',$data);

      }else{
        return redirect('/login')->with('gagal','Silahkan login terlebih dahulu');
      }

    }

    public function laporanPengajuan(Request $request){
      $token = Session::get('token');
      $tokenDb = M_Suplier::where('token',$token)->count();
      $key = env('APP_KEY');
      $decode = JWT::decode($token,$key,array('HS256'));
      $decode_array = (array) $decode;

      if($tokenDb > 0){
        $this->validate ($request,
        [
          'id_pengajuan'=>'required',
          'laporan'=>'required|mimes:pdf|max:10000'
        ]);
        $cekLaporan = M_Laporan::where('id_suplier',$decode_array['id_supplier'])->where('id_pengajuan',$request->id_pengajuan)->count();
        if ($cekLaporan == 0){

          $path = $request->file('laporan')->store('public/laporan');
           if(M_Laporan::create([
             "id_pengajuan"=>$request->id_pengajuan,
             "id_suplier"=>$decode_array['id_supplier'],
             "laporan"=>$path
             ])){
               return redirect('/riwayatPengajuan')->with('berhasil','Laporan Berhasil Diupload');
          }else{
              return redirect('/riwayatPengajuan')->with('gagal','Laporan Gagal Diupload');
          }


        }else{
          return redirect('/riwayatPengajuan')->with('gagal','Anda sudah Pernah Mengupload Laporan ini');
        }
      }else{
          return redirect('/login')->with('gagal','Silahkan login terlebih dahulu');
      }
    }

    //menampilkan Laporan Pengajuan di Admin
    public function bukaLaporan(){
      $key = env('APP_KEY');
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
        if ($tokenDb>0){
          $pengajuan = M_Pengajuan::where('status','2')->paginate(15);
          $dataP = array();
          foreach($pengajuan as $p){
            $pengadaan = M_Pengadaan::where('id_pengadaan',$p->id_pengadaan)->first();
            $sup = M_Suplier::where('id_supplier',$p->id_suplier)->first();
            $c_laporan = M_Laporan::where('id_pengajuan',$p->id_pengajuan)->count();
            $laporan = M_Laporan::where('id_pengajuan',$p->id_pengajuan)->first();

            if($c_laporan>0){
              $dataP[] = array(
                "id_pengajuan" => $p->id_pengajuan,
                "gambar" => $pengadaan->gambar,
                "nama_pengadaan" => $pengadaan->nama_pengadaan,
                "anggaran_pengadaan" => $pengadaan->anggaran,
                "anggaran_pengajuan" => $p->anggaran,
                "proposal" => $p->proposal,
                "nama_suplier" => $sup->nama_usaha,
                "email" => $sup->email,
                "alamat" => $sup->alamat,
                "status" => $p->status,
                "laporan" => $laporan->laporan,
                "id_laporan" => $laporan->id_laporan
              );
            }else{

            }

          }
          $data['adm'] = M_Admin::where('token',$token)->first();
          $data['pengajuan'] = $dataP;
          return view('admin.laporanadm',$data);
        }else{
            return redirect('/masukAdmin')->with('gagal','Silahkan Login sebagai Admin dahulu');
        }
    }

    public function selesaiPengajuan($id){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
        if ($tokenDb>0){
          if(M_Pengajuan::where('id_pengajuan',$id)->update(
            [
              "status"=>"3"
            ]
          )){
              return redirect('/bukaLaporan')->with('berhasil','Status Pengajuan Berhasil Diselesaikn');
          }else{
            return redirect('/bukaLaporan')->with('gagal','Status Pengajuan gagal diubah/Belum Diselesaikan');
          }
        }else{
          return redirect('/masukAdmin')->with('gagal','Silahkan Login sebagai Admin dahulu');
        }

    }

    public function tolakPoposal($id){
      $token = Session::get('token');
      $tokenDb = M_Admin::where('token',$token)->count();
      if ($tokenDb>0){
        $proposal = M_Laporan::where('id_laporan', $id)-> count();
        if($proposal > 0){
          $dataTerpilih = M_Laporan::where('id_laporan',$id)->first();

          if(Storage::delete($dataTerpilih->laporan)){

            if(M_Laporan::where('id_laporan', $id)->delete()){
              return redirect('/bukaLaporan')->with('berhasil','Proposal Laporan berhasil ditolak');
            }else{
              return redirect('/bukaLaporan')->with('gagal','Proposal Laporan gagal ditolak');
            }

          }else{
            return redirect('/bukaLaporan')->with('gagal','Proposal Laporan gagal ditolak');
          }

        }else{
          return redirect('/bukaLaporan')->with('gagal','Data Tidak ditemukan');
        }

      }else{
        return redirect('/masukAdmin')->with('gagal','Silahkan login terlebih dahulu');
      }

    }

}
