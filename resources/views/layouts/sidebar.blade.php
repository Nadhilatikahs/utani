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
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
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
                <a class="collapse-item active" href="{{ url('coa') }}">COA</a>
                <a class="collapse-item active" href="{{ url('jenis-transaksi') }}">Jenis Transaksi</a>
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
            </div>
        </div>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Arus Kas
    </div>

    {{-- arus kas lama --}}
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('aruskas.index') }}">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Arus Kas</span>
        </a>
    </li> --}}

    {{-- arus kas baru --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ url('transaksi') }}">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Transaksi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="journal.php">
            <i class="fas fa-fw fa-book"></i>
            <span>Jurnal Umum</span>
        </a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan Biaya Pertanian</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('cluster.clusterbiaya') }}">
            <i class="fas fa-fw fa-code"></i>
            <span>Cluster Biaya Pertanian</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('grafik/pilihtahunbatang/2024') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Grafik Usaha Tani</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('grafik/viewJmlPenjualan/2024') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Grafik Komoditas Tani</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('grafik/viewJmlPendapatanKelompokTani/2024') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Grafik Kelompok Tani</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
