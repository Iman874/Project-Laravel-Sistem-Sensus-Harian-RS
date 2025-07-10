<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    
    <!-- Bootstrap 5.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (HARUS sebelum js DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Chart Apexchars -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.dataTables.min.css">

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.min.js"></script>

    <!-- RowGroup Nightly -->
    <link rel="stylesheet" href="https://nightly.datatables.net/rowgroup/css/rowGroup.dataTables.min.css">
    <script src="https://nightly.datatables.net/rowgroup/js/dataTables.rowGroup.min.js"></script>

    <!-- Tambahkan moment.js untuk sorting kolom tanggal custom -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.4/sorting/datetime-moment.js"></script>

    <!-- Libbary untuk form-tanggal -->
    <!-- Tambahkan CSS & JS Tempus Dominus -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Ekstensi untuk ekspor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- Ekstensi untuk tombol ekspor spesifik -->
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"></script>

    <!-- Csrftoken -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Style Custom -->
    <style>
        /* Warna Testing */
        .color-red {
            background-color:rgb(255, 0, 0);
        }
        .color-blue {
            background-color:rgb(0, 0, 255);
        }
        .color-bg-window {
            background-color: #efefef;
        }
    </style>

    @stack('styles')
    @stack('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <!-- Container -->
    <div class="container-fluid d-flex color-bg-window">
        <!-- Navbar -->
        <div class="col-2 d-flex flex-column ps-3 pe-2">
            @yield('navbar')
        </div>

        <!-- Right Content -->
        <div class="col-10 pe-3">
            <!-- Header -->
            <div class="col">
                @yield('header')
            </div>
            
            <!-- Content -->
            <div class="col flex-grow-1">
                @yield('content')
            </div>
        </div>
    </div>

    
</body>
</html>