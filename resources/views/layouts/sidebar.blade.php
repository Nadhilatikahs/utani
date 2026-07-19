<!-- //resources/views/layouts/sidebar.blade.php -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-seedling fa-2x"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Usaha Tani</div>
    </a>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
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
            <div class="collapse-inner py-2 rounded">
                <a class="collapse-item" href="{{ route('provinsis.index') }}"><i class="fas fa-map-marked-alt mr-2"></i>Provinsi</a>
                <a class="collapse-item" href="{{ route('kabupatens.index') }}"><i class="fas fa-city mr-2"></i>Kabupaten</a>
                <a class="collapse-item" href="{{ route('dinas.index') }}"><i class="fas fa-building mr-2"></i>Dinas</a>
                <a class="collapse-item" href="{{ route('upts.index') }}"><i class="fas fa-sitemap mr-2"></i>Unit Pelaksana Teknis</a>
                <a class="collapse-item" href="{{ route('bpps.index') }}"><i class="fas fa-hands-helping mr-2"></i>Balai Penyuluh Pertanian</a>
                <a class="collapse-item" href="{{ route('desas.index') }}"><i class="fas fa-home mr-2"></i>Desa</a>
                <a class="collapse-item" href="{{ route('keltanis.index') }}"><i class="fas fa-users mr-2"></i>Kelompok Tani</a>
                <a class="collapse-item" href="{{ route('anggotatanis.index') }}"><i class="fas fa-user-friends mr-2"></i>Anggota Tani</a>
                <a class="collapse-item" href="{{ route('lahans.index') }}"><i class="fas fa-tractor mr-2"></i>Lahan</a>
                <a class="collapse-item" href="{{ route('komoditas.index') }}"><i class="fas fa-leaf mr-2"></i>Komoditas</a>
                <a class="collapse-item" href="{{ route('bebans.index') }}"><i class="fas fa-coins mr-2"></i>Beban</a>
                <a class="collapse-item" href="{{ route('kategori.index') }}"><i class="fas fa-tags mr-2"></i>Kategori</a>
                <a class="collapse-item" href="{{ url('coa') }}"><i class="fas fa-chart-line mr-2"></i>COA</a>
                <a class="collapse-item" href="{{ url('jenis-transaksi') }}"><i class="fas fa-exchange-alt mr-2"></i>Jenis Transaksi</a>
                <a class="collapse-item" href="{{ url('detail-jenis-transaksi') }}"><i class="fas fa-list-alt mr-2"></i>Detail Jenis Transaksi</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-seedling"></i>
            <span>Kegiatan Produksi</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="collapse-inner py-2 rounded">
                <a class="collapse-item" href="{{ route('tanams.index') }}"><i class="fas fa-seedling mr-2"></i>Tanam</a>
                <a class="collapse-item" href="{{ route('bebantanam.index') }}"><i class="fas fa-money-bill-wave mr-2"></i>Beban Produksi</a>
                <a class="collapse-item" href="{{ route('panen.index') }}"><i class="fas fa-basketball-ball mr-2"></i>Panen</a>
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
            <span>Laporan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('cluster.clusterbiaya') }}">
            <i class="fas fa-fw fa-code"></i>
            <span>Cluster Biaya Pertanian</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('clustering/kelompok-tani') }}">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Cluster Kelompok Tani</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('clustering.show') }}">
            <i class="fas fa-fw fa-map-marked-alt"></i>
            <span>Cluster Wilayah</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
