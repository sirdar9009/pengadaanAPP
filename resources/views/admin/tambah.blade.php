<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="form" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="form">
    <div class="modal-content">

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Tambah Data Admin</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="/tambahAdmin" method="post" role="form">
          {{csrf_field()}}
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Alamat</label>
              <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat"></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Tambahkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
