<!-- Modal -->
<div class="modal fade" id="ubah_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Ubah Data Admin</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="/ubahAdmin" method="post" role="form">
          {{csrf_field()}}
          <input type="hidden" name="id_admin" id="id_admin" class="form-control id_admin">

          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Nama</label>
              <input type="text" class="form-control nama" id="ub_nama" name="ub_nama" placeholder="Nama">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Email</label>
              <input type="email" class="form-control email" id="ub_email" name="ub_email" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Alamat</label>
              <textarea class="form-control alamat" id="ub_alamat" name="ub_alamat" placeholder="Masukan Alamat" name="alamat"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Ubah Data</button>
          </div>
        </form>
      </div>


    </div>
  </div>
</div>
