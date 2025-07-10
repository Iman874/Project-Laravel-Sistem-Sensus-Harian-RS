@php
use Carbon\Carbon;
$decryptedData = decrypt($data);
@endphp

<div class="perawat-container card border-0 mt-1 p-3" style="opacity: 0;">
    <!-- Select Tampilan Konten -->
    <div class="row">
        <div class="col-12">
            <select class="form-select" id="select-data-view_perawat">
                <option value="1" selected>Input Data Perawat</option>
                <option value="2">Tabel Data Perawat</option>
            </select>
        </div>
    </div>

    <!-- Form Data Perawat -->
    <div class="form-data-perawat card border-0 mt-3" style="display: none;">
        <form class="form-dataPerawat" action="{{ route('store.perawat') }}" 
        method="POST" onsubmit="return cekDataPerawat()">
            @csrf
            <!-- Form -->
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                            <option value="" selected>Pilih jenis kelamin...</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="penempatan" class="form-label">Penempatan</label>
                        <select id="penempatan" name="penempatan" class="form-select">
                            @foreach ($bangsal as  $item)
                                <option value="{{ $item->nama_bangsal }}">{{ $item->nama_bangsal }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                       <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" disabled>
                            <option value="perawat" selected>Perawat</option>
                        </select>
                        <input type="hidden" name="role" value="perawat">
                    </div>
                </div>
            </div>

            <!-- Tombol Submit dan Reset -->
            <div class="mt-3">
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>

    <!-- Tabel Data Perawat -->
    <div class="container-data-perawat" style="display: none;">
        <table id="tabel-data-perawat-id" class="table table-striped table-hover table-sm">
            <thead class="table-header table-color align-middle">
                <tr>
                    <th>No</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Penempatan</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($decryptedData['perawat'] as $perawat)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $perawat->username }}</td>
                        <td>{{ $perawat->nama }}</td>
                        <td>{{ $perawat->jenis_kelamin }}</td>
                        <td>{{ $perawat->penempatan }}</td>
                        <td>{{ $perawat->role }}</td>
                        <td>
                            <button type="button" class="btn btn-edit btn-primary" id="editButton-{{$perawat->id_perawat}}" onclick="editPerawat({{ $perawat->id_perawat }})">Edit</button>
                            <button type="button" class="btn btn-delete btn-danger" onclick="hapusData({{ $perawat->id_perawat }})">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Form Edit Perawat -->
    <div class="modal fade" id="editPerawatModal" tabindex="-1" aria-labelledby="editPerawatLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPerawatLabel">Edit Data Perawat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPerawatForm" 
                    method="POST" onsubmit="return cekEditDataPerawat()">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id_perawat" name="id_perawat">

                        <div class="row row-cols-2">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="edit_username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="edit_password" name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="edit_nama" name="nama" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                                    <select class="form-select" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_penempatan" class="form-label">Penempatan</label>
                                    <select id="edit_penempatan" name="penempatan" class="form-select">
                                        @foreach ($bangsal as  $item)
                                            <option value="{{ $item->nama_bangsal }}">{{ $item->nama_bangsal }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_role" class="form-label">Role</label>
                                    <select id="edit_role" name="role" class="form-select" disabled>
                                        <option value="perawat" selected>Perawat</option>
                                    </select>
                                    <input type="hidden" name="role" value="perawat">
                                </div>
                            </div>
                        </div>
                                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Loading Spinner -->
<div class="loading text-center position-absolute top-50 translate-middle" style="left: 60%;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- Tampilkan pesan status (create, update, delete, eror) -->
@if (session('status'))
<script>
    let decryptedStatus = {!! json_encode(Crypt::decryptString(session('status'))) !!};
    console.log(decryptedStatus);
    if (decryptedStatus) {
        MessageInfo(decryptedStatus);
    }

    function MessageInfo(action) {
        let title = "";
        let text = "";
        let icon = "";
        let timerInterval;
        let timeLeft = 10; // Hitungan mundur dalam detik

        if (action === "create") {
            title = "Berhasil!";
            text = "Data berhasil ditambahkan.";
            icon = "success";
        } else if (action === "update") {
            title = "Berhasil!";
            text = "Data berhasil diperbarui.";
            icon = "success";
        } else if (action === "delete") {
            title = "Berhasil!";
            text = "Data berhasil dihapus.";
            icon = "success";
        } else if (action === "eror") {
            title = "Error!";
            text = "Terjadi kesalahan, silakan coba lagi.";
            icon = "error";
        } else {
            title = action;
            text = "Terjadi kesalahan, silakan coba lagi.";
            icon = "error";
        }

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            timer: 10000, // 10 detik
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonText: `OK (10)`,
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

<!--- Script yang di push -->
@push('scripts')
<script>
    // Panggil Fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Panggil fungsi setContentHeight dan setHeaderKontenHeight dari app.js
        setContentHeight();
        setHeaderKontenHeight();

        // Ambil select element
        let selectDataView = document.getElementById('select-data-view_perawat');

        // Cek apakah ada data tersimpan di localStorage
        if (localStorage.getItem("selectedDataView_Perawat")) {
            selectDataView.value = localStorage.getItem("selectedDataView_Perawat");
        }

        // Event listener untuk menyimpan perubahan ke localStorage
        selectDataView.addEventListener("change", function () {
            localStorage.setItem("selectedDataView_Perawat", this.value);
            updateContentDisplay();
        });

        // Destroy DataTable sebelumnya
        destroyDataTable('#tabel-data-perawat-id');

        // Inisialisasi DataTable
        initializeDataTable();

        // Tampilkan konten setelah 200ms
        setTimeout(() => {
            updateContentDisplay();
        }, 200);
    });

</script>
@endpush

<!-- script yang tidak di push -->
<script>
    // Fungsi untuk cek data perawat apakah semua kolom sudah diisi
    function cekDataPerawat() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const nama = document.getElementById('nama').value;
        const jenisKelamin = document.getElementById('jenis_kelamin').value;
        const penempatan = document.getElementById('penempatan').value;
        const role = document.getElementById('role').value;

        if (!username || !password || !nama || !jenisKelamin || !penempatan || !role) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap!',
                text: 'Semua kolom wajib diisi!',
            });
            return false;
        }

        if (password.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Password Terlalu Pendek!',
                text: 'Password minimal 8 karakter!',
            });
            return false;
        }

        // Tampilkan loading
        loadingStatus();

        return true;
    }

    // Fungsi untuk cek form edit data perawat
    function cekEditDataPerawat() {
        const username = document.getElementById('edit_username').value;
        const password = document.getElementById('edit_password').value;
        const nama = document.getElementById('edit_nama').value;
        const jenisKelamin = document.getElementById('edit_jenis_kelamin').value;
        const penempatan = document.getElementById('edit_penempatan').value;
        const role = document.getElementById('edit_role').value;

        if (!username || !nama || !jenisKelamin || !penempatan || !role) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap!',
                text: 'Semua kolom wajib diisi!',
            });
            return false;
        }

        if (password.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Password Terlalu Pendek!',
                text: 'Password minimal 8 karakter!',
            });
            return false;
        }

        // Tampilkan loading
        loadingStatus();

        return true;
    }

    // Fungsi edit data perawat
    function editPerawat(id_perawat) {
        // nonaktifkan tombol sementara
        let editButton = document.getElementById(`editButton-${id_perawat}`);
        if (editButton) editButton.disabled = true; // Disable tombol sementara

        // Set action di form menggunakan route Laravel
        let form = document.getElementById("editPerawatForm");
        form.action = `{{ route('update.perawat', ':id') }}`.replace(':id', id_perawat);

        fetch(`/petugas_indikator/perawat/${id_perawat}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("edit_id_perawat").value = id_perawat;
                document.getElementById("edit_username").value = data.username;
                document.getElementById("edit_nama").value = data.nama;
                document.getElementById("edit_jenis_kelamin").value = data.jenis_kelamin;
                document.getElementById("edit_penempatan").value = data.penempatan;
                document.getElementById("edit_role").value = data.role;
                
                // Tampilkan modal
                let modal = new bootstrap.Modal(document.getElementById('editPerawatModal'));
                modal.show();
            })
            .catch(error => console.error("Gagal mengambil data:", error));

        // Fungsi untuk mengatur backdrop modal
        document.addEventListener('shown.bs.modal', function (event) {
            // Pastikan modal tetap terlihat saat dibuka
            let modal = event.target;
            modal.scrollTop = 0;
            document.body.classList.add('modal-open');
        });

        // Fungsi untuk mengatur backdrop modal
        document.addEventListener('hidden.bs.modal', function (event) {
            // Bersihkan backdrop agar tidak menumpuk
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            // aktifkan tombol kembali
            if (editButton) editButton.disabled = false; // Enable tombol kembali
        });
    }

    // Fungsi delete data perawat
    function hapusData(id_perawat) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                // tampilkan loading
                loadingStatus();
                let form = document.createElement('form');
                form.action = `{{ route('delete.perawat', ':id') }}`.replace(':id', id_perawat);
                form.method = 'POST';
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Fungsi untuk inisialisasi DataTables
    function initializeDataTable() {
        if (!$.fn.DataTable.isDataTable('#tabel-data-perawat-id')) {
            new DataTable('#tabel-data-perawat-id', {
                language: {
                    lengthMenu: "Show _MENU_ entries per page",
                    emptyTable: "Tidak ada data tersedia", // Pesan saat tabel kosong
                },
                layout: {
                    topStart: 'pageLength', // Tombol ada di pojok kiri atas
                    topEnd: {
                        search: {
                            placeholder: ' Cari data...'
                        }
                    },
                    bottomStart: ['info', 'buttons'], // Tombol ada di pojok kiri bawah
                    bottomEnd: 'paging',
                },
                paging: true, // Aktifkan pagination
                pageLength: -1, // Default menampilkan semua data
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]], // -1 berarti "semua data"
                scrollCollapse: true, // Aktifkan fitur scroll
                scrollY: "40vh", // Atur tinggi maksimal
                scrollX: true, // Aktifkan scroll horizontal
                autoWidth: false, // Atur lebar tabel secara otomatis
                buttons: [
                    { extend: 'copy', text: '<i class="bi bi-clipboard-fill"></i> Copy', exportOptions: { columns: ':not(:last-child)' }, title: 'Data Perawat' },
                    { extend: 'excel', text: '<i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel', exportOptions: { columns: ':not(:last-child)' }, title: 'Data Perawat' },
                    { extend: 'pdf', text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF', exportOptions: { columns: ':not(:last-child)' }, title: 'Data Perawat' },
                    { extend: 'print', text: '<i class="bi bi-printer-fill"></i> Print', exportOptions: { columns: ':not(:last-child)' }, title: 'Data Perawat' }
                ]
            });
        }
    }

    // Fungsi untuk menghancurkan DataTable
    function destroyDataTable(tableId) {
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }
    }

    // Fungsi untuk menampilkan konten
    function updateContentDisplay() {
        // Ambil elemen
        const formDataPerawat = $('.form-data-perawat');
        const containerDataPerawat = $('.container-data-perawat');

        // Ambil nilai dari select element
        let selectDataView = document.getElementById('select-data-view_perawat');
        let selectedDataView_Perawat = selectDataView.value;

        $('.loading').hide();

        // Tampilkan konten berdasarkan pilihan
        if (selectedDataView_Perawat === '1') {
            destroyDataTable('#tabel-data-perawat-id');
            formDataPerawat.css('display', 'block');
            containerDataPerawat.css('display', 'none');
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        } else if (selectedDataView_Perawat === '2') {
            initializeDataTable();
            formDataPerawat.css('display', 'none');
            containerDataPerawat.css('display', 'block');
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        }
    }

    window.onload = function () {
        const container = document.querySelector('.perawat-container');

        function setHeight() {
            let tinggiNavbar = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--tinggi-navbar'));
            let tinggiHeader = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--tinggi-konten-header'));
            
            let tinggiContainer = tinggiNavbar - tinggiHeader;
            container.style.height = tinggiContainer + 'px';

            container.style.opacity = 1; // Tampilkan elemen setelah selesai dihitung
        }

        setTimeout(setHeight, 100); // Beri sedikit delay agar CSS variabel selesai dihitung
    };

</script>

<!-- style -->
<style>
    /* Style untuk table */
    .table td, .table th {
        white-space: nowrap !important; /* paksa agar tidak ada wrap */
    }

    /* Style untuk header table */
    .table-color {
        background-color: #6c5b3b; 
        color:rgb(255, 255, 255);
    }

    /* Style untuk tombol edit dan hapus */
    .btn-edit, .btn-delete {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }

    /* Style header table */
    .table-header tr th{
        text-align: center;
    }

    /* Style untuk kontainer */
    .perawat-container {
        transition: opacity 0.4s ease-in-out;
    }

</style>
