<!-- Modal -->
<div class="modal fade" id="pengadaanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="form">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengadaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/simpanPengadaan" method="post" role="form" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama Pengadaan</label>
          <input type="text" class="form-control" id="nama_pengadaan" name="nama_pengadaan" placeholder="Nama Pengadaan">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Deskripsi</label>
          <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsikan Pengadaan ini"></textarea>
        </div>
        <div class="form-group">
          <label for="gambar">Gambar</label>
          <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/jpeg, image/png, image/gif">
        </div>
        <div class="form-group">
          <label>Anggaran : <input type="" class="labelRp" disable style="border:none; background-color: white; color: black;"></label>
          <input type="text" class="form-control" id="anggaran" name="anggaran" placeholder="Jumlah Anggaran" onkeyup="uang()"></input>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
    </div>
  </div>
</div>
