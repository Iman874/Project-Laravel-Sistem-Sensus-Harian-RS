@extends('layout.auth')

@section('title', 'Login')

@section('field')
<div class="container-fluid">
    <div class="container-field row row-cols-2 p-5 h-100" style="opacity: 0;">
        <div class="col-6 d-flex justify-content-end align-items-center">
            <div class="card py-5 px-5 border-0 d-flex justify-content-center align-items-center color-card-login">
                <h2 class="mt-5">SISTEM INFORMASI SENSUS</h2>
                <h2>HARIAN RAWAT INAP</h2>
                <br>
                <h2 class="mb-5">RSUD TESTING</h2>
            </div>            
        </div>
        <div class="col-6 d-flex justify-content-start align-items-center">
            <div class="card border-0 pe-5 d-flex justify-content-center align-items-center">
                <h1 class="mt-2 mb-3">LOGIN</h1>
                <form action="{{ route('route-login') }}" method="POST" class="row px-5 g-0">
                    @csrf
                    <div class="col-12 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="showPassword" id="showPassword" onclick="togglePassword()">
                            <label class="form-check-label" for="showPassword">
                                Tampilkan Password
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="col-12 btn mt-3 btn-login">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tampilkan pesan status apabila kata sandi salah -->
    @if (session('login_error'))
    <script>
        let decryptedStatus = {!! json_encode(Crypt::decryptString(session('login_error'))) !!};
        console.log(decryptedStatus);
        if (decryptedStatus) {
            MessageInfo(decryptedStatus);
        }

        function MessageInfo(action) {
            let title = "";
            let text = "";
            let icon = "";
            let timerInterval;
            let timeLeft = 5; // Hitungan mundur dalam detik

            if (action === "Password salah.") {
                title = "Gagal!";
                text = "Kata sandi yang Anda masukkan salah.";
                icon = "error";
            } else if (action === "Username tidak ditemukan.") {
                title = "Gagal!";
                text = "Username yang Anda masukkan tidak ditemukan.";
                icon = "error";
            }

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                timer: 5000, // 5 detik
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: `OK (5)`,
                didOpen: () => {
                    const confirmButton = Swal.getConfirmButton();
                    timerInterval = setInterval(() => {
                        timeLeft--;
                        confirmButton.textContent = `OK (${timeLeft})`;
                    }, 1000);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            });
        }
    </script>
    @endif

</div>

@endsection

<!-- Scripts -->
<script>
    function togglePassword() {
        var password = document.getElementById("password");
        if (password.type === "password") {
            password.type = "text";
        } else {
            password.type = "password";
        }
    }

    // Fungsi untuk mereset zoom
    function resetZoom() {
        let aspectRatio = 20 / 9;
        let width = window.innerWidth;
        let height = window.innerHeight;
        
        if (width / height > aspectRatio) {
            width = height * aspectRatio;
        } else {
            height = width / aspectRatio;
        }
        
        let scaleX = window.innerWidth / width;
        let scaleY = window.innerHeight / height;
        let scale = Math.min(scaleX, scaleY);
        
        document.body.style.transform = `scale(${scale})`;
        document.body.style.transformOrigin = "top left";
        document.body.style.width = `${width}px`;
        document.body.style.height = `${height}px`;

        // Atur layar agar selalu di tengah secara horizontal dan vertikal
        document.body.style.marginLeft = `${(window.innerWidth - width) / 2}px`;
    }
    // Fungsi untuk menonaktifkan zoom
    function disableZoom() {
        // Pastikan layar berada pada zoom 100%
        resetZoom();

        // Nonaktifkan zoom pada mouse scroll
        document.addEventListener('wheel', function(event) {
            if (event.ctrlKey) {
                event.preventDefault();
            }
        }, { passive: false });

        // Nonaktifkan zoom pada keyboard
        document.addEventListener('keydown', function(event) {
            if (
                event.ctrlKey && 
                (event.key === '+' || event.key === '-' || event.key === '=' || event.key === '0')
            ) {
                event.preventDefault();
            }
        });

        // Nonaktifkan zoom pada gesture
        document.addEventListener('gesturestart', function(event) {
            event.preventDefault();
        });
    } 

    // Panggil fungsi disableZoom pada saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        disableZoom();
        resetZoom();

        // Animasi container-field
        let containerField = document.querySelector('.container-field');
        containerField.style.opacity = 1;
    });

</script>
@push('styles')
<style>
    .color-card-login {
        background-color: #34a853 !important;
        color: white;
        border-radius: 10px;
    }
    .btn-login {
        background-color: #34a853;
        color: white;
    }
    .btn-login:hover {
        background-color: #2e8a3a;
        color: white;
    }
    .btn-login:active {
        background-color: #2a7c32;
    }

    .container-field {
        transition: opacity 0.5s ease-in-out;
        min-height: 100vh;
    }
</style>
@endpush
