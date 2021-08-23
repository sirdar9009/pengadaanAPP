<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengadaan</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminLTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminLTE/dist/css/adminlte.min.css')}}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('adminLTE/plugins/toastr/toastr.min.css')}}">


</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->




      <!-- Notifications Dropdown Menu -->
      @include('parsial.usersetting')

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="{{('adminLTE/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">HALAMAN ADMIN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      @include('admin.usermenu')



      <!-- Sidebar Menu -->
      @include('parsial.sidemenu')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengajuan Masuk</h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        </div>
        <div class="row">
          <div class="col-12">
            <div class="text-right mb-2">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>Tambah</button>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Admin</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($admin as $tampil)
                    <tr>
                      <td>{{$tampil->nama}}</td>
                      <td>{{$tampil->email}}</td>
                      <td>{{$tampil->alamat}}</td>
                      <td>
                          <button type="button" class="btn btn-secondary ubah" data-toggle="modal" data-target="#ubah_modal"
                          data-id_admin="{{$tampil->id_admin}}"
                          data-nama="{{$tampil->nama}}"
                          data-email="{{$tampil->email}}"
                          data-alamat="{{$tampil->alamat}}"
                          ><i class="fas fa-edit"></i>Ubah
                          </button>
                          <a class="konfirmasi" href="/hapusAdmin/{{$tampil->id_admin}}">
                          <button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i>Hapus</button>
                          </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('parsial.footer')
  @include('admin.tambah')
  @include('admin.ubah')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Toastr -->
<script src="{{asset('adminLTE/plugins/toastr/toastr.min.js')}}"></script>

<!-- jQuery -->
<script src="{{asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('adminLTE/dist/js/demo.js')}}"></script> -->

<!-- ALERT -->

<!-- SweetAlert2 -->
<script src="{{asset('adminLTE/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    @if (\Session::has('berhasil'))
      Toast.fire({
        icon: 'success',
        title: '{{Session::get('berhasil')}}'
      })
    @endif
    @if(\Session::has('gagal'))
      Toast.fire({
        icon: 'error',
        title: '{{Session::get('gagal')}}'
      })
    @endif
    @if(count($errors) > 0)
      Toast.fire({
        icon: 'error',
        title: '<ul>@foreach($errors -> all() as $error )<li>{{$error}}</li>@endforeach</ul>'
      })
    @endif
  });

  $(document).on("click",".ubah", function(){
    var id_admin = $(this).data('id_admin');
    var nama = $(this).data('nama');
    var email = $(this).data('email');
    var alamat = $(this).data('alamat');

    $(".id_admin").val(id_admin);
    $(".nama").val(nama);
    $(".email").val(email);
    $(".alamat").val(alamat);
  });

  $(document).on("click",".konfirmasi", function(event){
    event.preventDefault();
    const url = $(this).attr('href');

    var answer = window.confirm("Apakah kamu yakin ingin menghapus data ini?");
    if (answer){
      window.location.href = url;
    }else{

    }
  });
</script>


</body>
</html>
