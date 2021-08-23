<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_Suplier extends Model
{
    //
    protected $table = 'tbl_suplier';
    protected $primaryKey = 'id_supplier';
    protected $fillable = ['id_supplier','nama_usaha','email','alamat','no_npwp','password','status','token'];
}
