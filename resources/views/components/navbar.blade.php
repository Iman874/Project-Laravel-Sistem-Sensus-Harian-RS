@props(['role_active' => ''])
<div class="navbar-container d-flex flex-column vh-100 py-3 color-bg-window">
    <!-- Header Navbar -->
    <div class="navbar-header card border-0 text-center text-white fw-bold py-2 color-navbar-header">
        <h5 class="pt-1">RSUD TESTING</h5>
    </div>

    <!-- Navbar Menu -->
    <ul class="navbar-menu nav card border-0 flex-column h-100 my-1 px-2 color-navbar-menu">
        <li class="nav-item mt-3">
            @if($role_active === 'petugas_indikator')    
                <a href="{{ route('petugas_indikator.dashboard') }}" class="nav-link text-white">
                    @if(url()->current() == route('petugas_indikator.dashboard'))
                        <i class="bi bi-house-door-fill"></i> Dashboard
                    @else
                        <i class="bi bi-house-door"></i> Dashboard
                    @endif
                </a>
            @elseif($role_active === 'perawat')
                <a href="{{ route('perawat.dashboard') }}" class="nav-link text-white">
                    @if(url()->current() == route('perawat.dashboard'))
                        <i class="bi bi-house-door-fill"></i> Dashboard
                    @else
                        <i class="bi bi-house-door"></i> Dashboard
                    @endif
                </a>
            @elseif($role_active === 'kepala_instalasi')
                <a href="#" class="nav-link text-white">
                    @if(url()->current() == route('kepala_instalasi.dashboard'))
                        <i class="bi bi-house-door-fill"></i> Dashboard
                    @else
                        <i class="bi bi-house-door"></i> Dashboard
                    @endif
                </a>
            @endif
        </li>
        
        <!-- Jika Role adalah Petugas_Indikator -->
        @if($role_active === 'petugas_indikator')
            <li class="nav-item">
                <a href="{{ route('petugas_indikator.data-pasien.index') }}" class="nav-link text-white">
                    @if(url()->current() == route('petugas_indikator.data-pasien.index'))
                        <i class="bi bi-folder-fill"></i> Data
                    @else
                        <i class="bi bi-folder"></i> Data
                    @endif
                </a>
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a href="{{ route('petugas_indikator.data-pasien.index') }}" class="nav-link text-white">Data Pasien</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('petugas_indikator.data-bangsal.index') }}" class="nav-link text-white">Data Bangsal</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('petugas_indikator.data-perawat.index')}}" class="nav-link text-white">Data Perawat</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('petugas_indikator.laporan.index')}}" class="nav-link text-white">
                    <i class="bi bi-file-earmark-text"></i> Laporan
                </a>
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a href="{{ route('petugas_indikator.laporan.rekap')}}" class="nav-link text-white">Laporan RI</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white">Tabel Rekapitulasi</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-bar-chart"></i> Grafik
                </a>
            </li>

        <!-- Jika Role adalah Perawat -->
        @elseif($role_active === 'perawat')
            <li class="nav-item">
                <!-- Menu data pasien  -->
                <a href="{{ route('perawat-pasienMasuk.index') }}" class="nav-link text-white">
                    @if(url()->current() == route('perawat-pasienMasuk.index') 
                        || url()->current() == route('perawat-pasienPindah.index')
                        || url()->current() == route('perawat-pasienKeluar.index'))
                        <i class="bi bi-folder-fill"></i> Data Pasien
                    @else
                        <i class="bi bi-folder"></i> Data Pasien
                    @endif
                </a>

                
                <ul class="nav flex-column ms-3">
                    <!-- Menu data pasien Masuk -->
                    <li class="nav-item">
                        <a href="{{ route('perawat-pasienMasuk.index') }}" class="nav-link text-white">
                            Pasien Masuk
                        </a>
                    </li>

                    <!-- Menu data pasien Pindah -->
                    <li class="nav-item">
                        <a href="{{ route('perawat-pasienPindah.index') }}" class="nav-link text-white">
                            Pasien Pindah
                        </a>
                    </li>

                    <!-- Menu data pasien keluar -->
                    <li class="nav-item">
                        <a href="{{ route('perawat-pasienKeluar.index') }}" class="nav-link text-white">
                            Pasien Keluar
                        </a>
                    </li>
                </ul>
            </li>

        <!-- Jika Role adalah Kepala Instalasi -->
        @elseif($role_active === 'kepala_instalasi')
            <!-- Jika Role adalah Kepala_Instalasi -->
            <li class="nav-item">
                
            </li>
        @endif

    </ul>

    <!-- Tombol Logout -->
    <div class="navbar-footer card border-0">
        <a href="{{ route('route-logout') }}" class="btn btn-danger w-100">Logout</a>
    </div>
</div>

<!-- Script -->
<script>
    // Fungsi untuk menambahkan bold pada menu yang aktif
    function addBoldActiveMenu() {
        // Ambil semua elemen dengan class nav-link
        let navLinks = document.querySelectorAll('.nav-link');

        // Looping setiap elemen nav-link
        navLinks.forEach(navLink => {
            // Jika href dari navLink sama dengan URL saat ini
            if (navLink.href === window.location.href) {
                // Tambahkan class fw-bold pada navLink
                navLink.classList.add('fw-bold');
            }
        });
    }

    // Panggil fungsi addBoldActiveMenu pada saat halaman dimuat
    document.addEventListener('DOMContentLoaded', addBoldActiveMenu);
</script>

<style>
    .color-navbar-header {
        background-color: #373224;
    }
    .color-navbar-menu {
        background-color: #6c5b3b;
    }

    /* Style tombol-hover untuk menu yang aktif */
     /* Style tombol-hover untuk menu yang aktif */
    .nav-link {
        transition: background-color 0.3s, transform 0.2s;
    }

    .nav-link:hover {
        background-color: #373224;
        color: #373224;
    }

    .nav-link:active {
        background-color: #4a3a1b;
        transform: scale(0.95);
    }
</style>