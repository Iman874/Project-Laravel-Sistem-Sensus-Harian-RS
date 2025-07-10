@props(['role_active' => '', 'halaman' => '', 'judulHalaman' => ''])
<div class="konten-header">
    <!-- Header Konten -->
    @if($halaman === 'dashboard')    
        @php
            $roles = [
                'petugas_indikator' => 'PETUGAS INDIKATOR',
                'perawat' => 'PERAWAT',
                'kepala_instalasi' => 'KEPALA INSTALASI'
            ];
        @endphp
        @if (array_key_exists($role_active, $roles))
            <div class="card border-0 text-center text-white fw-bold py-3 color-header-dashboard">
                <h4>SELAMAT DATANG {{ $roles[$role_active] }}</h4>
                <h4>SISTEM INFORMASI SENSUS HARIAN</h4>
            </div>
        @endif
    @elseif($halaman === 'konten')
        <div class="card border-0 d-flex align-items-center color-konten-header">
            <div class="text-start align-self-start text-white py-1 ps-4 fw-bold">
                <h5 class="pt-1">{{ $judulHalaman }}</h5>
            </div>
        </div>
    @endif
</div>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.konten-header').style.opacity = 1;
    });
</script>

<!-- Style -->
<style>
    .color-header-dashboard {
        background-color: #34a853;
    }

    .color-konten-header {
        background-color: #6c5b3b;
    }

    .konten-header {
        opacity: 0;
        transition: opacity 0.4s ease-in-out;
    }
</style>