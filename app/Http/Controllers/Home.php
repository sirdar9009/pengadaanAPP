<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import library Session
use Illuminate\Support\Facades\Session;

use App\M_Suplier;
use App\M_Pengadaan;

class Home extends Controller
{
    //fungsi index
    public function index()
    {
      //echo "fungsi index home";
      $token = Session::get('token');
      $tokenDb = M_Suplier::where('token',$token)-> count();
          if ($tokenDb>0){
            $data['token']= $token;
          }else{
            $data['token']="kosong";
          }
          $data['pengadaan']=M_Pengadaan::where('status','1')->paginate(15);
      return view('utama.home',$data);

    }
}
