<!-- Modal -->
<div class="modal fade" id="ubahPasswordSup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
        <form action="/ubahPassword_sup" method="post" role="form">
          {{csrf_field()}}
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputPassword1">Password Lama</label>
              <input type="password" class="form-control" name="passwordlama" id="passwordlama" placeholder="Masukan Password Lama Anda">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password Baru</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Masukan Password Baru">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Ubah Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
