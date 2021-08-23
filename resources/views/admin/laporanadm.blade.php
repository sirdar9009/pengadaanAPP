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

          <!-- /.col -->

          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pengajuan Masuk</h3>

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
                <table class="table table-hover table-bordered table-striped text-nowrap">
                  <thead class="thead-dark">
                    <tr class="text-center">
                      <th>Nama Pengadaan</th>
                      <th>Gambar</th>
                      <th>Anggaran Pengadaan (IDR)</th>
                      <th>Anggaran Pengajuan (IDR)</th>
                      <th>Proposal</th>
                      <th>Nama Suplier</th>
                      <th>Email</th>
                      <th>Alamat</th>
                      <th>Laporan</th>
                      <th>Status Pengajuan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pengajuan as $p)
                    <tr class="text-center">
                      <td>{{$p['nama_pengadaan']}}</td>
                      <td style="width:15%;">  <img class="img-rounded img-responsive" style="width:70%;" src="{{asset(Storage::url($p['gambar']))}}"></td>
                      <td><span class="tag tag-success">Rp. {{number_format($p['anggaran_pengadaan'],0,",",".")}}</span></td>
                      <td><span class="tag tag-success">Rp. {{number_format($p['anggaran_pengajuan'],0,",",".")}}</span></td>
                      <td><a class="btn btn-primary" href="{{asset(Storage::url($p['proposal']))}}" target="_blank">Lihat Detail</a></td>
                      <td>{{$p['nama_suplier']}}</td>
                      <td>{{$p['email']}}</td>
                      <td>{{$p['alamat']}}</td>
                      <td>
                        @if($p['status'] == 2)
                        <a href="{{asset(Storage::url($p['laporan']))}}" class="btn btn-success" target="_blank"><i class="fa fa-eye"></i> Lihat Laporan</a>
                        @endif
                      </td>
                      <td>
                        @if($p['status'] == 2)
                        Laporan Sedang Ditinjau<hr>
                        <a href="/selesaiPengajuan/{{$p['id_pengajuan']}}" class="btn btn-primary konfirmasi"><i class="fas fa-check"></i> Diterima</a>
                        <a href="/tolakPoposal/{{$p['id_laporan']}}" class="btn btn-danger konfirmasi"><i class="fas fa-times"></i> Ditolak</a>
                        @endif
                      </td>
                      @endforeach
                    </tr>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('adminLTE/dist/js/demo.js')}}"></script> -->
<script type="text/javascript">
$(document).on("click",".konfirmasi", function(event){
  event.preventDefault();
  const url = $(this).attr('href');

  var answer = window.confirm("Apakah kamu yakin ingin memproses data ini?");
  if (answer){
    window.location.href = url;
  }else{

  }
});

</script>

</body>
</html>
