<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf_token" content="{{ csrf_token() }}"/>
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Usaha Tani - Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @yield('style')
    <style>
        #map {
            height: 70vh;
            width: 100%;
        }
        /* Modern UI/UX Enhancements - Green Color Palette (#1CC88A base) */
        :root {
            /* Light Theme Variables */
            --primary-green: #0e7657ff;
            --active-green: #1CC88A;
            --button-green: #1CC88A;
            --button-green-dark: #17A875;
            --success-green: #22C55E;
            --bg-success: #DCFCE7;
            --bg-white: #FFFFFF;
            --bg-page: #F4FEFA;
            --bg-section: #EAFBF5;
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --border-color: #ffffffff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }        /* Modern Sidebar - Green Theme */
        .sidebar {
            background: var(--primary-green) !important;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);

            width: 20rem !important;
        }
        .sidebar-brand {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding: 1.5rem 0;
            margin-bottom: 1rem;
        }
        .sidebar-brand-text {
            color: #fff !important;
            /* Keep original font size and style */
        }
        .sidebar-brand-icon {
            color: #fff;
        }
        /* Modern Sidebar Links & Items */
        .sidebar .nav-item {
            margin: 0.25rem 0.75rem;
        }
        .sidebar.sidebar-dark .nav-item .nav-link,
        .sidebar.sidebar-dark.toggled .nav-item .nav-link {
            width: 100%;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: var(--transition);
            color: rgba(255, 255, 255, 1);
        }
        .sidebar.sidebar-dark .nav-item .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .sidebar.sidebar-dark .nav-item.active .nav-link,
        .sidebar.sidebar-dark .nav-item .nav-link.active {
            background: #0D7F58;
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(13, 127, 88, 0.4);
        }
        /* Perfect alignment and visibility for dropdown arrow chevrons */
        .sidebar.sidebar-dark .nav-item .nav-link[data-toggle="collapse"]::after {
            float: right;
            line-height: 1.5;
            margin-top: 0.15rem;
            transition: transform 0.3s ease;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .sidebar.sidebar-dark .nav-item .nav-link[data-toggle="collapse"]:hover::after,
        .sidebar.sidebar-dark .nav-item.active .nav-link[data-toggle="collapse"]::after {
            color: #ffffff !important;
        }
        .sidebar-heading {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.0625rem;
            text-transform: uppercase;
        }
        /* High-Specificity Sidebar Collapse / Sub-menu Styling */
        .sidebar .nav-item .collapse .collapse-inner,
        .sidebar .nav-item .collapsing .collapse-inner {
            background: #0d9d5fff !important;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 0.5rem 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        .sidebar.sidebar-dark .nav-item .collapse .collapse-inner .collapse-item,
        .sidebar.sidebar-dark .nav-item .collapsing .collapse-inner .collapse-item {
            border-radius: 8px;
            margin: 0.25rem 0.75rem;
            padding: 0.6rem 1rem;
            transition: var(--transition);
            color: rgba(255, 255, 255, 1) !important;
            display: block;
            font-weight: 500;
            font-size: 0.85rem;
            background: transparent !important;
        }
        .sidebar.sidebar-dark .nav-item .collapse .collapse-inner .collapse-item i,
        .sidebar.sidebar-dark .nav-item .collapsing .collapse-inner .collapse-item i {
            color: rgba(255, 255, 255, 0.65) !important;
            transition: var(--transition);
        }
        .sidebar.sidebar-dark .nav-item .collapse .collapse-inner .collapse-item:hover,
        .sidebar.sidebar-dark .nav-item .collapsing .collapse-inner .collapse-item:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            text-decoration: none;
        }
        .sidebar.sidebar-dark .nav-item .collapse .collapse-inner .collapse-item:hover i {
            color: #ffffff !important;
        }
        .sidebar.sidebar-dark .nav-item .collapse .collapse-inner .collapse-item.active,
        .sidebar.sidebar-dark .nav-item .collapsing .collapse-inner .collapse-item.active {
            background: #0D7F58 !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(13, 127, 88, 0.3);
        }
        .sidebar.sidebar-dark .nav-item .collapse .collapse-inner .collapse-item.active i {
            color: #ffffff !important;
        }        /* Dropdown styling */
        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            padding: 0.5rem 0;
            font-size: 0.875rem;
        }
        .dropdown-item {
            padding: 0.5rem 1rem;
            color: var(--text-primary);
            transition: var(--transition);
        }
        .dropdown-item:hover {
            background: var(--bg-section);
            color: var(--text-primary);
        }
        .dropdown-item:active {
            background: var(--button-green);
            color: #fff;
        }
        /* Modern Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            overflow: hidden;
            background: var(--bg-white);
        }
        .card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }
        .card-header {
            background: var(--button-green);
            color: #fff;
            border: none;
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.9375rem;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--button-green) 0%, var(--button-green-dark) 100%) !important;
            color: #fff !important;
        }
        .card-body {
            padding: 2rem;
        }
        /* Modern Forms */
        .form-control, .form-select, select.form-control, select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: var(--transition);
            height: auto !important; /* Fix for dropdown text cutoff */
        }
        .form-control:focus, .form-select:focus, select.form-control:focus, select:focus {
            border-color: var(--button-green);
            box-shadow: 0 0 0 0.2rem rgba(31, 169, 113, 0.25);
            transform: translateY(-2px);
            outline: none;
        }
        .input-group-text {
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
            background: #f8f9fa;
        }
        .input-group .form-control,
        .input-group .form-select {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        .input-group .form-control:focus,
        .input-group .form-select:focus {
            border-left: 2px solid var(--button-green);
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        /* Modern Buttons */
        .btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: var(--transition);
            border: none;
        }
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }
        .btn-lg {
            padding: 0.625rem 1.25rem;
            font-size: 0.9375rem;
        }
        .btn-primary {
            background: var(--button-green);
            border-color: var(--button-green);
            color: #fff;
            box-shadow: 0 4px 15px rgba(28, 200, 138, 0.4);
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        .btn-primary:hover {
            background: var(--button-green-dark);
            border-color: var(--button-green-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(28, 200, 138, 0.6);
        }
        .btn-success {
            background: var(--success-green);
            border-color: var(--success-green);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4);
        }
        .btn-success:hover {
            background: #16a34a;
            border-color: #16a34a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.6);
        }
        .btn-outline-secondary {
            border: 2px solid #6c757d;
        }
        .btn-outline-secondary:hover {
            background: #6c757d;
            transform: translateY(-2px);
        }
        /* Modern Tables */
        .table {
            border-radius: 10px;
            overflow: hidden;
            background: var(--bg-white);
        }
        .table thead {
            background: var(--button-green);
            color: white;
        }
        .table-primary thead {
            background: var(--button-green) !important;
        }
        .table thead th {
            border: none;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .table tbody tr {
            transition: var(--transition);
        }
        .table tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }
        /* Standardized Financial Table Sizing */
        .table-financial {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            background: var(--bg-white);
        }
        .table-financial th,
        .table-financial td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
            word-wrap: break-word;
            padding: 0.8rem 1rem;
            font-size: 0.9rem;
            vertical-align: middle;
            border-bottom: 1px solid #F0F5F2;
        }
        .table-financial th {
            background: #F4F7F6;
            color: #374151;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            font-size: 0.78rem;
            border-bottom: 2px solid #D1E8DC;
        }
        .table-financial tbody tr:hover {
            background: #FAFCFB;
        }
        .table-financial tr:last-child td {
            border-bottom: none;
        }
        .row-total-vc td {
            background-color: #EBF5F0 !important;
            font-weight: 700;
            color: var(--primary-green) !important;
            border-top: 1.5px solid #1F6F54 !important;
            border-bottom: 1.5px solid #1F6F54 !important;
        }
        .row-grand-total td {
            background-color: #0D7F58 !important;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 0.95rem;
            border-top: 2px solid #0B513C !important;
            border-bottom: 2px solid #0B513C !important;
        }
        .row-grand-total td .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        /* Modern Topbar */
        .topbar {
            background: var(--bg-white) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 15px 15px;
            transition: var(--transition);
        }
        /* Modern Topbar / Navbar Links & Icons */
        .topbar .navbar-nav .nav-item .nav-link {
            color: #4B5563;
            transition: var(--transition);
            border-radius: 8px;
            margin: 0 0.25rem;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .topbar .navbar-nav .nav-item .nav-link i {
            font-size: 1.15rem;
            color: #4B5563;
            transition: var(--transition);
        }
        .topbar .navbar-nav .nav-item .nav-link:hover {
            background-color: var(--bg-section);
            color: var(--primary-green);
        }
        .topbar .navbar-nav .nav-item .nav-link:hover i {
            color: var(--primary-green);
        }
        /* Topbar Red Badges Adjustments */
        .topbar .navbar-nav .nav-item .nav-link .badge-counter {
            position: absolute;
            transform: scale(0.8) translate(40%, -40%);
            transform-origin: top right;
            font-weight: 700;
            padding: 0.25rem 0.4rem;
            border-radius: 999px;
            background-color: #EF4444;
            color: #ffffff;
            border: 2px solid var(--bg-white);
        }
        /* Modern Alerts */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .alert-success {
            background: var(--bg-success);
            color: var(--text-primary);
            border-left: 4px solid var(--success-green);
        }
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }
        /* Page Content */
        #content {
            background: var(--bg-page);
            min-height: 100vh;
        }
        body {
            color: var(--text-primary);
        }
        .container-fluid {
            padding: 2rem;
        }
        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-section);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--button-green);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--active-green);
        }
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card, .alert, .table {
            animation: fadeIn 0.5s ease-out;
        }
        /* Modern Input Groups */
        .input-group .form-control {
            border-right: none;
        }
        .input-group-append .btn {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        /* Modern Badges */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-weight: 600;
        }
        /* Page Header Improvements */
        .page-header {
            background: var(--bg-white);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }
        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, var(--button-green) 0%, var(--active-green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        /* Text Colors */
        .text-muted {
            color: var(--text-secondary) !important;
        }
        /* Border Colors */
        hr {
            border-color: var(--border-color);
        }
        .border {
            border-color: var(--border-color) !important;
        }
        /* Gap utility for Bootstrap 4 compatibility */
        .gap-2 {
            gap: 0.5rem;
        }
        .gap-2 > * {
            margin-right: 0.5rem;
        }
        .gap-2 > *:last-child {
            margin-right: 0;
        }
        .gap-3 {
            gap: 1rem;
        }
        .gap-3 > * {
            margin-right: 1rem;
        }
        .gap-3 > *:last-child {
            margin-right: 0;
        }
        /* Dashboard KPI Cards */
        .card .bg-opacity-10 {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .bg-primary.bg-opacity-10 {
            background-color: rgba(28, 200, 138, 0.1) !important;
        }
        .bg-warning.bg-opacity-10 {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }
        .bg-success.bg-opacity-10 {
            background-color: rgba(34, 197, 94, 0.1) !important;
        }
        /* Dashboard Map */
        #clusterMap {
            border-radius: 0 0 10px 10px;
        }
        /* Badge improvements */
        .badge {
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-lg {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
        /* Dashboard Kelompok Tani Leaderboard */
        .table-hover tbody tr:hover {
            background-color: rgba(28, 200, 138, 0.05);
            transition: background-color 0.2s;
        }
        .progress {
            border-radius: 10px;
            overflow: hidden;
        }
        .progress-bar {
            font-size: 0.7rem;
            font-weight: 600;
        }
        /* Responsive Improvements */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            .container-fluid {
                padding: 1rem 2rem; 
                /* 0.5rem 2rem 2rem 2rem; */
            }
        }
    </style>
    <!-- Include ApexCharts library -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Tambahan highchart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script>
    window.MathJax = {
      tex: {
        inlineMath: [['$', '$'], ['\\(', '\\)']],
        displayMath: [['$$', '$$'], ['\\[', '\\]']]
      }
    };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('layouts.navbar')
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('contents')
                    <!-- Content Row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            @include('layouts.footer')
            <!-- End of Footer -->
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
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
            $('#modal_tambah').modal('show');
        @endif
    </script>
    <!-- Global Table Responsive Wrapper -->
    <script>
        $(document).ready(function() {
            $('table.table').each(function() {
                // Ensure the table does not wrap its text, forcing horizontal scroll
                $(this).addClass('text-nowrap');
                // Wrap in table-responsive if not already wrapped
                if (!$(this).parent().hasClass('table-responsive')) {
                    $(this).wrap('<div class="table-responsive"></div>');
                }
            });
        });
    </script>
    @yield('script')
</body>
</html>
