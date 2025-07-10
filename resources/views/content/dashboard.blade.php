<div class="card border-0 mt-1">
    <!-- ditambah 4px karena pada gambar terdapat margin sebesar 4px -->

    <img class="card border-0 image_dashboard" 
    src="{{ asset('image/rumah-sakit.png') }}" alt="Rumah Sakit">
</div>

<div class="loading text-center position-absolute top-50 translate-middle" style="left: 60%;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

@push('scripts')
<script>
    // Fungsi untuk menambahkan tinggi pada navbar
    function setNavbarHeight() {
        if(!document.querySelector('.navbar-header') || !document.querySelector('.navbar-menu') || !document.querySelector('.navbar-footer')) {
            console.error("Elemen navbar-header, navbar-menu, atau navbar-footer tidak ditemukan.");
            return;
        }
        const headerHeight = document.querySelector('.navbar-header').offsetHeight;
        const menuHeight = document.querySelector('.navbar-menu').offsetHeight;
        const footerHeight = document.querySelector('.navbar-footer').offsetHeight;
        const totalHeight = headerHeight + menuHeight + footerHeight;
        document.documentElement.style.setProperty('--tinggi-navbar', `${totalHeight}px`);
    }

    // Fungsi untuk menambahkan tinggi pada header konten
    function setHeaderKontenHeight_dashboard() {
        const headerHeight = document.querySelector('.konten-header').offsetHeight;
        document.documentElement.style.setProperty('--tinggi-konten-header', `${headerHeight}px`);
    }

    // Panggil fungsi setNavbarHeight dan setHeaderKontenHeight pada saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        setNavbarHeight();
        setHeaderKontenHeight_dashboard();

        const img = document.querySelector('.image_dashboard');
        const loading = document.querySelector('.loading');

        function hideLoading() {
            if (img) {
                loading.style.display = 'none';    
                img.style.opacity = '1';
                img.style.height = 'calc(var(--tinggi-navbar) - var(--tinggi-konten-header) + 4px)';
                // ditambah 4px karena pada gambar terdapat margin sebesar 4px
            }
        }

        // Jika gambar sudah di-cache, langsung tampilkan
        if (img.complete && img.naturalWidth > 0) {
            hideLoading();
        } else {
            img.addEventListener('load', hideLoading);
            img.addEventListener('error', () => {
                console.error("Gagal memuat gambar!");
                hideLoading();
            });
        }

        // Gunakan IntersectionObserver agar tidak stuck saat console aktif
        // Solusi untuk mengatasi stuck loading saat console aktif
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    hideLoading();
                    observer.disconnect();
                }
            });
        }, { threshold: 0.5 });

        observer.observe(img);

        // Paksa hilangkan loading setelah 5 detik
        setTimeout(hideLoading, 5000);

    });
</script>
@endpush

<!-- Style -->
<style>
    img {
        object-fit: cover;
    }

    .image_dashboard {
        opacity: 0;
        transition: opacity 0.4s ease-in-out;
    }
</style>