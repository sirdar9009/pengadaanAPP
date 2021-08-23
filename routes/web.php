<?php

Route::get('/','Home@index');

//route registrasi
Route::get('/registrasi','Registrasi@index');

//route simpan data registrasi
Route::post('/regis','Registrasi@regis');

//Bagian Suplier
//route halaman login Suplier
Route::get('/login','Suplier@login');
Route::post('/masukSuplier','Suplier@masukSuplier');
//route halaman logout Suplier
Route::get('/suplierKeluar','Suplier@suplierKeluar');
//List Pengadaan di Halaman suplier
Route::get('/listSuplier','Pengadaan@listSuplier');
//Membuat pengajuan
Route::post('/buatPengajuan','Pengajuan@buatPengajuan');
//Menampilkan Riwayat Pengajuan Suplier
Route::get('/riwayatPengajuan','Pengajuan@riwayatPengajuan');
//Membuat Laporan pengajuan
Route::post('/laporanPengajuan','Pengajuan@laporanPengajuan');
//Menampilkan Pengajuan Selesai di Suplier
Route::get('/PengajuanSelesai','Pengajuan@PengajuanSelesai');
//Mengubah Password Suplier
Route::post('/ubahPassword_sup','Suplier@ubahPassword_sup');


//Bagian Admin
//route halaman login Admin
Route::get('/masukAdmin','Admin@index');
//route halaman login Admin
Route::post('/loginAdmin','Admin@loginAdmin');
//route halaman daftar Pengajuan suplier
Route::get('/pengajuan','Pengajuan@pengajuan');
//route halaman logout Admin
Route::get('/keluarAdmin','Admin@keluarAdmin');


//route Menampilkan List Admin
Route::get('/listAdmin','Admin@listAdmin');
//route Simpan input Admin
Route::post('/tambahAdmin','Admin@tambahAdmin');
//route update data Admin
Route::post('/ubahAdmin','Admin@ubahAdmin');
//route hapus data Admin
Route::get('/hapusAdmin/{id}','Admin@hapusAdmin');



Route::get('/listPengadaan','Pengadaan@index');

Route::post('/simpanPengadaan','Pengadaan@simpanPengadaan');

Route::get('/hapusGambar/{id}','Pengadaan@hapusGambar');

Route::post('/uploadGambar','Pengadaan@uploadGambar');

Route::post('/ubahPengadaan','Pengadaan@ubahPengadaan');

Route::get('/hapusPengadaan/{id}','Pengadaan@hapusPengadaan');

//route Proses Setujui data Pengajuan Suplier oleh Admin
Route::get('/terimaPengajuan/{id}','Pengajuan@terimaPengajuan');
//route Proses Hapus data Pengajuan Suplier oleh Admin
Route::get('/tolakPengajuan/{id}','Pengajuan@tolakPengajuan');
//route Lihat Laporan yang diupload Suplier oleh Admin
Route::get('/bukaLaporan','Pengajuan@bukaLaporan');
//route Proses Menyelesaikan Laporan Pengajuan Suplier oleh Admin
Route::get('/selesaiPengajuan/{id}','Pengajuan@selesaiPengajuan');
//route Proses Hapus-tolak data laporan Suplier oleh Admin
Route::get('/tolakPoposal/{id}','Pengajuan@tolakPoposal');
//Route Menampilkan Data Suplier di Hal admin
Route::get('/dataSuplier','Suplier@dataSuplier');
//Route Menonaktifkann Data Suplier di Hal admin
Route::get('/nonaktifSuplier/{id}','Suplier@nonaktifSuplier');
//Route Mengaktifkann Data Suplier di Hal admin
Route::get('/aktifSuplier/{id}','Suplier@aktifSuplier');
//Mengubah Password Admin
Route::post('/ubahPassword_adm','Admin@ubahPassword_adm');
