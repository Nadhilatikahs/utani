<!-- //resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Usaha Tani - Dashboard</title>
  <!-- Custom fonts for this template-->
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  
  <!-- Custom styles for this template-->
  <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
  <!-- Include ApexCharts library -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
      <!-- //resources/views/layouts/sidebar.blade.php -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
  
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">Usaha Tani</div>
    </a>
   <!-- Nav Item - Dashboard -->
   <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data</span>
        </a>
  <!-- Nav Item - Dashboard -->
   <!-- master data -->
  <<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item active" href="{{ route('provinsis.index') }}">Provinsi</a>
                <a class="collapse-item active" href="{{ route('kabupatens.index') }}">Kabupaten</a>
                <a class="collapse-item active" href="{{ route('dinas.index') }}">Dinas</a>
                <a class="collapse-item active" href="{{ route('upts.index') }}">Unit Pelaksana Teknis</a>
                <a class="collapse-item active" href="{{ route('bpps.index') }}">Balai Penyuluh Pertanian</a>
                <a class="collapse-item active" href="{{ route('desas.index') }}">Desa</a>
                <a class="collapse-item active" href="{{ route('keltanis.index') }}">Kelompok Tani</a>
                <a class="collapse-item active" href="{{ route('anggotatanis.index') }}">Anggota Tani</a>
                <a class="collapse-item active" href="{{ route('lahans.index') }}">Lahan</a>
                <a class="collapse-item active" href="{{ route('komoditas.index') }}">Komoditas</a>
                <a class="collapse-item active" href="{{ route('bebans.index') }}">Beban</a>
                <a class="collapse-item active" href="{{ route('kategori.index') }}">Kategori</a>
            </div>
        </div>
  </li>
  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Transaksi</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item active" href="{{ route('tanams.index') }}">Tanam</a>
                <a class="collapse-item active" href="{{ route('bebantanam.index') }}">Beban Tanam </a>
                <a class="collapse-item active" href="{{ route('panen.index') }}"> Panen</a>
                <!--  -->
                <!-- <a class="collapse-item" href="{{ route('maps.map') }}">Pendapatan</a> -->
            </div>
        </div>
        
    </li>
  <!-- Heading -->
  <div class="sidebar-heading">
        Laporan
    </div>


    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan Biaya Pertanian</span></a>
    </li>
    
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('cluster.clusterbiaya') }}">
            <!--<i class="fa-regular fa-microchip-ai"></i>-->
            <i class="fas fa-fw fa-code"></i>
            <span>Cluster Biaya Pertanian</span></a>
    </li>
    
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('grafik/pilihtahunbatang/2024') }}">
            <!--<i class="fa-regular fa-microchip-ai"></i>-->
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Grafik Usaha Tani</span></a>
    </li>
    
     <li class="nav-item">
        <a class="nav-link" href="{{ url('grafik/viewJmlPenjualan/2024') }}">
            <!--<i class="fa-regular fa-microchip-ai"></i>-->
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Grafik Komoditas Tani</span></a>
    </li>
    
     <li class="nav-item">
        <a class="nav-link" href="{{ url('grafik/viewJmlPendapatanKelompokTani/2024') }}">
            <!--<i class="fa-regular fa-microchip-ai"></i>-->
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Grafik Kelompok Tani</span></a>
    </li>
    
  <!-- <li class="nav-item">
    <a class="nav-link" href="/profile">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Profile</span></a>
  </li> -->
  
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
  
  
</ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
  
      <!-- Main Content -->
      <div id="content">
  
        <!-- //resources/views/layouts/navbar.blade.php -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
  
  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>
  
  <!-- Topbar Search -->
  <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-primary" type="button">
          <i class="fas fa-search fa-sm"></i>
        </button>
      </div>
    </div>
  </form>
  
  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">
  
    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <li class="nav-item dropdown no-arrow d-sm-none">
      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
      </a>
      <!-- Dropdown - Messages -->
      <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
        <form class="form-inline mr-auto w-100 navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>
  
    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter">3+</span>
      </a>
      <!-- Dropdown - Alerts -->
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
          Alerts Center
        </h6>
        <a class="dropdown-item d-flex align-items-center" href="#">
          <div class="mr-3">
            <div class="icon-circle bg-primary">
              <i class="fas fa-file-alt text-white"></i>
            </div>
          </div>
          <div>
            <div class="small text-gray-500">December 12, 2019</div>
            <span class="font-weight-bold">A new monthly report is ready to download!</span>
          </div>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="#">
          <div class="mr-3">
            <div class="icon-circle bg-success">
              <i class="fas fa-donate text-white"></i>
            </div>
          </div>
          <div>
            <div class="small text-gray-500">December 7, 2019</div>
            $290.29 has been deposited into your account!
          </div>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="#">
          <div class="mr-3">
            <div class="icon-circle bg-warning">
              <i class="fas fa-exclamation-triangle text-white"></i>
            </div>
          </div>
          <div>
            <div class="small text-gray-500">December 2, 2019</div>
            Spending Alert: We've noticed unusually high spending for your account.
          </div>
        </a>
        <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
      </div>
    </li>
  
    <!-- Nav Item - Messages -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>
        <!-- Counter - Messages -->
        <span class="badge badge-danger badge-counter">7</span>
      </a>
      <!-- Dropdown - Messages -->
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
        <h6 class="dropdown-header">
          Message Center
        </h6>
        <a class="dropdown-item d-flex align-items-center" href="#">
          <div class="dropdown-list-image mr-3">
            <img class="rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile_1.svg" alt="...">
            <div class="status-indicator bg-success"></div>
          </div>
          <div class="font-weight-bold">
            <div class="text-truncate">Hi there! I am wondering if you can help me with a
              problem I've been having.</div>
            <div class="small text-gray-500">Emily Fowler 路 58m</div>
          </div>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="#">
          <div class="dropdown-list-image mr-3">
            <img class="rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile_2.svg" alt="...">
            <div class="status-indicator"></div>
          </div>
          <div>
            <div class="text-truncate">I have the photos that you ordered last month, how
              would you like them sent to you?</div>
            <div class="small text-gray-500">Jae Chun 路 1d</div>
          </div>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="#">
          <div class="dropdown-list-image mr-3">
            <img class="rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile_3.svg" alt="...">
            <div class="status-indicator bg-warning"></div>
          </div>
          <div>
            <div class="text-truncate">Last month's report looks great, I am very happy with
              the progress so far, keep up the good work!</div>
            <div class="small text-gray-500">Morgan Alvarez 路 2d</div>
          </div>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="#">
          <div class="dropdown-list-image mr-3">
            <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
            <div class="status-indicator bg-success"></div>
          </div>
          <div>
            <div class="text-truncate">Am I a good boy? The reason I ask is because someone
              told me that people say this to all dogs, even if they aren't good...</div>
            <div class="small text-gray-500">Chicken the Dog 路 2w</div>
          </div>
        </a>
        <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
      </div>
    </li>
  
    <div class="topbar-divider d-none d-sm-block"></div>
  
    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
          {{ auth()->user()->name }}
          <br>
          <small>{{ auth()->user()->level }}</small>
        </span>
        <img class="img-profile rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile.svg">
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="/profile">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profile
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          Settings
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
          Activity Log
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
      </div>
    </li>
  
  </ul>
  
</nav>

<!-- Begin Page Content -->
        <div class="container-fluid">
  
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"></h1>
          </div>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"></h1>

<div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h5 class="card-title fw-semibold mb-4">Grafik</h5>
                  <div class="card">

                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Kelompok Tani (Pendapatan-Seluruh Beban)</h6>
                        </div>

                        <!-- Card Body grafik -->
                        <div class="card-body">
                            
                            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                <div class="mb-3 mb-sm-0">
                                    <h5 class="card-title fw-semibold"><div id="x"></div></h5>
                                </div>
                                <div>
                                    <form action="#" method="GET">
                                    <select class="form-select" id="pilihan" name="pilihan">
                                         
                                            @foreach($daftartahun as $dft)
                                                <option value="{{$dft->tahun}}" {{ request('pilihan') == $dft->tahun ? 'selected' : '' }}>{{ $dft->tahun }}</option>
                                            @endforeach
                                        
                                    </select>
                                    <button type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                                            
                            <div id="grafik">

                            </div>
                        </div>
                        <!-- Akhir Card Body Grafik -->
                  </div>
                </div>
                
                
              </div>
            </div>
          </div>
        </div>

<?php
        if(isset($_GET['pilihan'])){
            ?>
                        <script>
                                            
                                                tahun = document.getElementById("pilihan").value; // Dapatkan nilai jenis grafik yang dipilih
                                                console.log(tahun);
                                                document.getElementById("x").innerHTML = "Tahun "+tahun;
                                                document.getElementById("grafik").innerHTML = "";
                                                fetchData(tahun);
                                            
                                        
                                            // number format
                                            function number_format(number, decimals, dec_point, thousands_sep) {
                                                    // *     example: number_format(1234.56, 2, ',', ' ');
                                                    // *     return: '1 234,56'
                                                    number = (number + '').replace(',', '').replace(' ', '');
                                                    var n = !isFinite(+number) ? 0 : +number,
                                                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                                                        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                                                        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                                                        s = '',
                                                        toFixedFix = function(n, prec) {
                                                        var k = Math.pow(10, prec);
                                                        return '' + Math.round(n * k) / k;
                                                        };
                                                    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                                                    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                                                    if (s[0].length > 3) {
                                                        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                                                    }
                                                    if ((s[1] || '').length < prec) {
                                                        s[1] = s[1] || '';
                                                        s[1] += new Array(prec - s[1].length + 1).join('0');
                                                    }
                                                    return s.join(dec);
                                                }
                                        
                                            // Fungsi untuk mengambil data dari server dengan AJAX
                                            function fetchData(tahun) {
                                              // Ganti URL dengan endpoint yang sesuai untuk mendapatkan data
                                              var url3 = "{{url('grafik/viewJmlPendapatanKelompokTaniJson')}}";
                                              var url4 = url3.concat("/",tahun);
                                              var url = url4;
                                            //   console.log(url);
                                              // Lakukan request AJAX
                                              fetch(url)
                                                // console.log(data);
                                                .then(response => response.json())
                                                .then(data => {
                                                  // Panggil fungsi untuk menggambar grafik dengan data yang diterima
                                                  drawChart(data.grafik);
                                                })
                                                .catch(error => {
                                                  console.error('Error fetching data:', error);
                                                });
                                            }
                                        
                                            // Fungsi untuk menggambar grafik menggunakan ApexCharts
                                            function drawChart(data) {
                                              // Ekstrak kategori (waktu) dan nilai total dari data
                                            //   console.log(data);
                                              var categories = data.map(item => item.nama_keltani);
                                              var values = data.map(item => parseInt(item.jml_penjualan));
                                        
                                            //   console.log(values);
                                              // Konfigurasi grafik
                                              var options = {
                                                series: values,
                                                chart: {
                                                  type: 'pie', // Jenis grafik sesuai dengan pilihan,
                                                  width: 500
                                                },
                                                labels: categories,
                                                tooltip: {
                                                    y: {
                                                        formatter: function(value) {
                                                            // Format yang akan ditampilkan pada tooltip
                                                            return "Rp " + number_format(value)
                                                        }
                                                    }
                                                }
                                                // Masukkan konfigurasi tambahan sesuai kebutuhan
                                              };
                                              
                                              // Hapus grafik sebelumnya jika ada
                                                // document.querySelector("#grafik").innerHTML = '';
                                        
                                              // Buat grafik dengan menggunakan ApexCharts
                                              var chart = new ApexCharts(document.querySelector("#grafik"), options);
                                        
                                              // Perbarui data series dan tampilkan grafik
                                            //   chart.updateSeries(series);
                                              chart.render();
                                            }
                                            
                                             // Event listener untuk select option
                                            // document.getElementById('pilihan').addEventListener('change', myFunction);
                                        
                                            // // Event listener untuk perubahan pada select option
                                            // document.getElementById('pilihan').addEventListener('change', function() {
                                            //   tahun = this.value; // Dapatkan nilai jenis grafik yang dipilih
                                            //   fetchData(tahun);
                                            // //   console.log(chartType) // Panggil fungsi fetchData dengan jenis grafik yang dipilih
                                            // });
                                        
                                            // Panggil fungsi fetchData untuk pertama kali saat halaman dimuat
                                            // fetchData('2024'); // Jenis grafik default
                                        </script>
            <?php
        }
?>


<!-- /.row -->

 </div>
        <!-- /.container-fluid -->
  
      </div>
      <!-- End of Main Content -->
      
      <!-- //resources/views/layouts/footer.blade.php -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright © Usaha Tani 2024</span>
    </div>
  </div>
</footer>

 </div>
    <!-- End of Content Wrapper -->
  
  </div>
  <!-- End of Page Wrapper -->
  
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
  <!-- Page level plugins -->
  <!--<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>-->
</body>
</html>
