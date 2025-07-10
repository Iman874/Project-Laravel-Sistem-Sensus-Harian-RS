@php
use Carbon\Carbon;
$decryptedData = decrypt($data);
@endphp

<div class="pasien-masuk-container card border-0 mt-1 p-3" style="opacity: 0;">
    <!-- Select Tampilan Konten -->
    <div class="row">
        <div class="col-12">
            <select class="form-select" id="select-data-view">
                <option value="1" selected>Input Pasien Masuk</option>
                <option value="2">Tabel Pasien Masuk</option>
            </select>
        </div>
    </div>

    <!-- Form Pasien Masuk -->
    <div class="form-pasien-masuk card border-0 mt-3" style="display: none;">
        <form class="form-pasienMasuk" action="{{ route('store.perawat-pasienMasuk') }}" 
        method="POST" onsubmit="return cekPasienMasuk()">
            @csrf
            <!-- Form -->
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_pasien" class="form-label">Nama Pasien</label>
                        <input type="text" id="nama_pasien" name="nama_pasien" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                            <option value="" selected>Pilih jenis kelamin...</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bangsal" class="form-label">Bangsal</label>
                        <select id="fk_kd_bangsal" class="form-select" disabled>
                            <option value="{{$decryptedData['bangsal']->first()->kd_bangsal}}" selected>{{$penempatan}}</option>
                        </select>
                        <input type="hidden" name="fk_kd_bangsal" value="{{$decryptedData['bangsal']->first()->kd_bangsal}}">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_rm" class="form-label">No Rekam Medis</label>
                        <input type="text" id="no_rm" name="no_rm" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
                        <input type="datetime-local" id="waktu_masuk" name="waktu_masuk" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="kelas_bangsal" class="form-label">Nama Kelas</label>
                        <select id="fk_id_kelas" name="fk_id_kelas" class="form-select">
                            <option value="" selected>Pilih Nama Kelas...</option>
                            @foreach($decryptedData['kelas_bangsal'] as $kelas)
                                <option value="{{ $kelas->id_kelas }}">
                                    {{ $kelas->nama_kelas }} ({{ $kelas->jenis_kelas }})
                                </option>
                            @endforeach
                        </select>
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

    <!-- Tabel Pasien Masuk -->
    <div class="container-pasien-masuk" style="display: none;">
        <table id="tabel-pasien-masuk-id" class="table table-striped table-hover table-sm">
            <thead class="table-header table-color align-middle">
                <tr>
                    <th>No</th>
                    <th class="text-center">No RM</th>
                    <th class="text-center">Nama Pasien</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Waktu Masuk</th>
                    <th class="text-center">Bangsal</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($decryptedData['pasien_masuk'] as $pasien)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $pasien->no_rm }}</td>
                        <td>{{ $pasien->nama_pasien }}</td>
                        <td>{{ $pasien->jenis_kelamin }}</td>
                        <td> 
                            {{ \Carbon\Carbon::parse($pasien->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                        </td>
                        <td>{{ $pasien->bangsal->nama_bangsal }}
                            ({{ $pasien->kelas_bangsal->nama_kelas }}
                            [{{ $pasien->kelas_bangsal->jenis_kelas}}])</td>
                        <td>
                            <button type="button" class="btn btn-edit btn-primary" id="editButton-{{$pasien->id_pasien_masuk}}" onclick="editPasien({{ $pasien->id_pasien_masuk }})">Edit</button>
                            <button type="button" class="btn btn-delete btn-danger" onclick="hapusData({{ $pasien->id_pasien_masuk }})">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Form Edit Pasien -->
    <div class="modal fade" id="editPasienModal" tabindex="-1" aria-labelledby="editPasienLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasienLabel">Edit Pasien Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPasienForm" 
                    method="POST" onsubmit="return cekEditPasienMasuk()">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id_pasien_masuk" name="id_pasien_masuk">

                        <div class="row row-cols-2">

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_nama_pasien" class="form-label">Nama Pasien:</label>
                                    <input type="text" class="form-control" id="edit_nama_pasien" name="nama_pasien" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                                    <select class="form-select" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_kd_bangsal" class="form-label">Bangsal:</label>
                                    <select class="form-select" id="edit_kd_bangsal" name="kd_bangsal" disabled>
                                        <option value="{{ $decryptedData['bangsal']->first()->kd_bangsal }}">{{ $decryptedData['bangsal']->first()->nama_bangsal }}</option>
                                    </select>
                                    <input type="hidden" name="fk_kd_bangsal" value="{{ $decryptedData['bangsal']->first()->kd_bangsal }}">
                                </div>
                            </div>

                            <div class="col-6">

                                <div class="mb-3">
                                    <label for="edit_no_rm" class="form-label">No Rekam Medis:</label>
                                    <input type="text" class="form-control" id="edit_no_rm" name="no_rm" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_waktu_masuk" class="form-label">Waktu Masuk:</label>
                                    <input type="datetime-local" class="form-control" id="edit_waktu_masuk" name="waktu_masuk" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_fk_id_kelas" class="form-label">Nama Kelas:</label>
                                    <select class="form-select" id="edit_fk_id_kelas" name="fk_id_kelas" required>
                                        <option value="">Pilih Nama Kelas</option>
                                        @foreach ($decryptedData['kelas_bangsal'] as $kelas)
                                            <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }} ({{ $kelas->jenis_kelas }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close" >Batal</button>
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
        let selectDataView = document.getElementById('select-data-view');

        // Cek apakah ada data tersimpan di localStorage
        if (localStorage.getItem("selectedDataView_Masuk")) {
            selectDataView.value = localStorage.getItem("selectedDataView_Masuk");
        }

        // Event listener untuk menyimpan perubahan ke localStorage
        selectDataView.addEventListener("change", function () {
            localStorage.setItem("selectedDataView_Masuk", this.value);
            updateContentDisplay();
        });

        // Jika sudah ada datatable yang ada maka hancurkan dulu
        $('table.dataTable').each(function () {
            $(this).DataTable().destroy();
        });

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
    // Fungsi untuk cek pasien masuk apakah semua kolom sudah diisi
    function cekPasienMasuk() {
        const namaPasien = document.getElementById('nama_pasien').value;
        const jenisKelamin = document.getElementById('jenis_kelamin').value;
        const noRm = document.getElementById('no_rm').value;
        const waktuMasuk = document.getElementById('waktu_masuk').value;
        const kelasBangsal = document.getElementById('fk_id_kelas').value;

        if (!namaPasien || !jenisKelamin || !noRm || !waktuMasuk || !kelasBangsal) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap!',
                text: 'Semua kolom wajib diisi!',
            });
            return false;
        }

        // Jika semua data sudah diisi, tampilkan loading
        loadingStatus();

        // Kembalikan nilai true agar form dapat di-submit
        return true;
    }

    // Fungsi untuk cek data pasien yang diedit apakah sudah lengkap
    function cekEditPasienMasuk() {
        const namaPasien = document.getElementById('edit_nama_pasien').value;
        const jenisKelamin = document.getElementById('edit_jenis_kelamin').value;
        const noRm = document.getElementById('edit_no_rm').value;
        const waktuMasuk = document.getElementById('edit_waktu_masuk').value;
        const kelasBangsal = document.getElementById('edit_fk_id_kelas').value;

        // Ambil atribut waktu-terakhir dari elemen
        const waktuTerakhir = document.getElementById('edit_waktu_masuk').getAttribute('waktu-terakhir');

        // Ubah format waktu agar lebih mudah dibaca
        let waktuTerakhir_convert = formatDateUTCtoWIB(waktuTerakhir);
        let waktu_terakhir_parsed = new Date(waktuTerakhir_convert).toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            timeZoneName: 'short'
        });

        // Cek apakah waktu masuk harus lebih kecil dari waktu terakhir
        // Waktu terakhir adalah waktu pasien pindah/keluar sebelumnya
        // Jika waktu terakhir tidak ada, maka tidak perlu validasi
        if (waktuTerakhir != null) {
            if (new Date(waktuTerakhir) <= new Date(waktuMasuk)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Waktu Masuk Tidak Valid!',
                    html: 'Waktu masuk saat ini harus lebih kecil dari waktu pindah/keluar sebelumnya!<br><br><b>Waktu pasien pindah/keluar sebelumnya:</b> <br>' + waktu_terakhir_parsed,
                });
                return false;
            }
        }

        if (!namaPasien || !jenisKelamin || !noRm || !waktuMasuk || !kelasBangsal) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap!',
                text: 'Semua kolom wajib diisi!',
            });
            return false;
        }

        // Jika semua data sudah diisi, tampilkan loading
        loadingStatus();

        // Kembalikan nilai true agar form dapat di-submit
        return true;
    }

    // Fungsi edit data pasien
    function editPasien(id_pasien_masuk) {
        // nonaktifkan tombol sementara
        let editButton = document.getElementById(`editButton-${id_pasien_masuk}`);
        if (editButton) editButton.disabled = true; // Disable tombol sementara

        // Set action di form menggunakan route Laravel
        let form = document.getElementById("editPasienForm");
        form.action = `{{ route('update.perawat-pasienMasuk', ':id') }}`.replace(':id', id_pasien_masuk);

        fetch(`/perawat/data-pasien-masuk/${id_pasien_masuk}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("edit_id_pasien_masuk").value = id_pasien_masuk;
                document.getElementById("edit_no_rm").value = data.no_rm;
                document.getElementById("edit_nama_pasien").value = data.nama_pasien;
                document.getElementById("edit_jenis_kelamin").value = data.jenis_kelamin;
                document.getElementById("edit_waktu_masuk").value = formatDateUTCtoWIB(data.waktu_masuk);
                document.getElementById("edit_fk_id_kelas").value = data.fk_id_kelas;
                
                // Tampilkan modal
                let modal = new bootstrap.Modal(document.getElementById('editPasienModal'));
                modal.show();
            })
            .catch(error => console.error("Gagal mengambil data:", error));

        // Fungsi untuk mengatur backdrop modal
        document.addEventListener('shown.bs.modal', function (event) {
            // Pastikan modal tetap terlihat saat dibuka
            let modal = event.target;
            modal.scrollTop = 0;
            document.body.classList.add('modal-open');

            // Ambil data sesudah data pasien masuk, jika pasien pernah pindah maka tetapkan atribut waktu-pindah-terakhir
            fetch (`/perawat/data-pasien-masuk/${id_pasien_masuk}/setelah`)
                .then(response => response.json())
                .then(data => {
                    // Cek data pasien pindah dari fetch
                    // Jika pasien pernah pindah atau keluar maka set atribut ke waktu-pindah-terakhir ke edit waktu masuk
                    if (data.waktu_terakhir) {
                        document.getElementById("edit_waktu_masuk").setAttribute('waktu-terakhir', data.waktu_terakhir);
                    } else {
                        document.getElementById("edit_waktu_masuk").removeAttribute('waktu-terakhir');
                    }
                })
                .catch(error => console.error("Gagal mengambil data:", error));
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

    // Fungsi delete data pasien
    function hapusData(id_pasien_masuk) {
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
                let form = document.createElement('form');
                form.action = `{{ route('delete.perawat-pasienMasuk', ':id') }}`.replace(':id', id_pasien_masuk);
                form.method = 'POST';
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();

                // Tampilkan loading
                loadingStatus();
            }
        });
    }

    // Fungsi untuk inisialisasi DataTables
    function initializeDataTable() {
        // Daftarkan format custom di moment.js untuk DataTables
        $.fn.dataTable.moment("DD MMMM YYYY (HH:mm)");
        
        if (!$.fn.DataTable.isDataTable('#tabel-pasien-masuk-id')) {
            new DataTable('#tabel-pasien-masuk-id', {
                columnDefs: [
                    {
                        targets: 4, // Kolom "Waktu Masuk" (Index ke-3)
                        type: "datetime-moment",
                        render: function (data, type, row) {
                            return type === 'sort' ? moment(data, "DD MMMM YYYY (HH:mm)").format("YYYY-MM-DD HH:mm") : data;
                        }
                        
                    }
                ],
                // Urutkan berdasarkan kolom ke-4 (index 3) secara DESC
                order: [[4, "desc"]],
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
                scrollY: "320px", // Atur tinggi maksimal
                scrollX: true, // Aktifkan scroll horizontal
                autoWidth: false, // Atur lebar tabel secara otomatis
                buttons: [
                    { extend: 'copy', text: '<i class="bi bi-clipboard-fill"></i> Copy', exportOptions: { columns: ':not(:last-child)' }, title: 'Pasien Masuk' },
                    { extend: 'excel', text: '<i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel', exportOptions: { columns: ':not(:last-child)' }, title: 'Pasien Masuk' },
                    { extend: 'pdf', text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF', exportOptions: { columns: ':not(:last-child)' }, title: 'Pasien Masuk' },
                    { extend: 'print', text: '<i class="bi bi-printer-fill"></i> Print', exportOptions: { columns: ':not(:last-child)' }, title: 'Pasien Masuk' }
                ]
            });
        }
    }

    // Fungsi untuk menampilkan konten
    function updateContentDisplay() {
        // Ambil elemen
        const formPasienMasuk = $('.form-pasien-masuk');
        const containerPasienMasuk = $('.container-pasien-masuk');

        // Ambil nilai dari select element
        let selectDataView = document.getElementById('select-data-view');
        let selectedValue = selectDataView.value;

        $(".loading").hide();

        // Tampilkan konten berdasarkan nilai yang dipilih
        if (selectedValue == '1') {
            $('#tabel-pasien-masuk-id').hide();
            containerPasienMasuk.css('display', 'none');
            formPasienMasuk.css('display', 'block');
        } else if (selectedValue == '2') {
            $('#tabel-pasien-masuk-id').show();
            containerPasienMasuk.css('display', 'block');
            formPasienMasuk.css('display', 'none');
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        } 
    }

    window.onload = function () {
        const container = document.querySelector('.pasien-masuk-container');

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
    .pasien-masuk-container {
        transition: opacity 0.4s ease-in-out;
    }
</style>
