<!-- Modal -->
<div class="modal fade" id="ubahModal">
  <div class="modal-dialog" role="form">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ubah Data Pengadaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/ubahPengadaan" method="post" role="form" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="id_pengadaan" id="id_pengadaan" class="id_pengadaan">
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama Pengadaan</label>
          <input type="text" class="form-control nama_pengadaan" id="ubahnama_pengadaan" name="ubahnama_pengadaan" placeholder="Nama Pengadaan">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Deskripsi</label>
          <textarea class="form-control deskripsi" id="ubahdeskripsi" name="ubahdeskripsi" placeholder="Deskripsikan Pengadaan ini"></textarea>
        </div>

        <div class="form-group">
          <label>Anggaran : <input type="" class="labelRp" disable style="border:none; background-color: white; color: black;"></label>
          <input type="text" class="form-control anggaran" id="ubahanggaran" name="ubahanggaran" placeholder="Jumlah Anggaran" onkeyup="uang2()"></input>
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
