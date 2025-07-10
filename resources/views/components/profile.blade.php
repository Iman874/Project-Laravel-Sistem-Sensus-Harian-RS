@props(['nama'=> 'Belum Login', 'gelar'=> ''])
<!-- Profile -->
<div class="profile-konten d-flex col-12 mb-1 mt-3" style="opacity: 0;">
    <div class="d-flex align-items-center fw-bold ms-auto">
       <span class="fw-bold pe-3">
          {{ $nama }}{{ $gelar ? ', ' . $gelar : '' }}
       </span>
       <i class="bi bi-person-fill fs-1"></i>
    </div>
</div>

@push('scripts')
<script>
    // Hitung tinggi dari header konten
    function hitungTinggiheaderNavbar() {
        // Ambil elemen header konten
        let headerNavbar = document.querySelector('.navbar-header');

        // Ambil tinggi dari header konten
        let tinggiheaderNavbar = headerNavbar.clientHeight;

        // set Height ke Profile Konten
        let profileKonten = document.querySelector('.profile-konten');
        profileKonten.style.height = tinggiheaderNavbar + 'px';
        profileKonten.style.opacity = '1'; // Set opacity menjadi 1 setelah tinggi diatur
    }

    window.onload = function() {
        // Panggil fungsi hitungTinggiheaderNavbar pada saat halaman dimuat
        setTimeout(() => {
            hitungTinggiheaderNavbar();
        }, 100); // Tunggu 1 detik sebelum menghitung tinggi header navbar
    };

    // panggil fungsi hitungTinggiheaderNavbar pada saat halaman dimuat
    document.addEventListener('DOMContentLoaded', hitungTinggiheaderNavbar);
</script>
@endpush

<style>
    .profile-konten {
        transition: opacity 0.4s ease-in-out;
    }
</style>
