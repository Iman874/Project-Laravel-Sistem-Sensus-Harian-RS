@php
use Carbon\Carbon;
$decryptedData = decrypt($data);
@endphp


<div class="pasien-keluar-container card border-0 mt-1 p-3" style="opacity: 0;">   
    <div class="row mb-2">
        <!-- Pilih data -->
        <div class="col-12">
            <select class="form-select" id="select-data-view">
                <option value="1" selected>Input Pasien Keluar</option>
                <option value="2">Data Pasien Keluar</option>
            </select>
        </div>

        <!-- Tabel Pencarian -->
        <div class="tabel-cari-pasien col-12" style="display: none;">
            <table id="tabel-cari-pasienKeluar" class="table table-striped table-hover table-sm">
                <thead class="table-header table-color align-middle">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">No RM</th>
                        <th class="text-center">Nama Pasien</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Bangsal Saat Ini</th>
                        <th class="text-center">Waktu Masuk</th>
                        <th class="text-center">Waktu Pindah Terbaru</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Waktu Menetap</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                 <tbody id="dataTable">
                    @foreach ($decryptedData['pasien_masukKeluar'] as $pasien)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $pasien->no_rm }}</td>
                            <td> {{ $pasien->nama_pasien }}</td>
                            <td> {{ $pasien->jenis_kelamin }}</td>
                            <td>
                                {{ $pasien->bangsal->nama_bangsal ?? '-' }}
                                ({{ $pasien->kelas_bangsal->nama_kelas ?? '-' }})
                                [{{ $pasien->kelas_bangsal->jenis_kelas ?? '-' }}]
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($pasien->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                            </td>
                            @php
                                $waktu_menetap = Carbon::parse($pasien->waktu_masuk)->diff(Carbon::now());
                                $years = $waktu_menetap->y;
                                $months = $waktu_menetap->m;
                                $days = $waktu_menetap->d;
                                $hours = $waktu_menetap->h;
                                $minutes = $waktu_menetap->i;

                                $waktu_menetap_formatted = '';
                                if ($years > 0) {
                                    $waktu_menetap_formatted .= $years . ' tahun, ';
                                }
                                if ($months > 0) {
                                    $waktu_menetap_formatted .= $months . ' bulan, ';
                                }
                                if ($days > 0) {
                                    $waktu_menetap_formatted .= $days . ' hari, ';
                                }
                                if ($hours > 0) {
                                    $waktu_menetap_formatted .= $hours . ' jam, ';
                                }
                                if ($minutes > 0) {
                                    $waktu_menetap_formatted .= $minutes . ' menit';
                                }
                                $waktu_menetap_formatted = rtrim($waktu_menetap_formatted, ', ');
                            @endphp
                            <td class="text-center">-</td>
                            <td class="text-center">
                                <span class="badge bg-success">Belum Pernah Pindah</span>
                            </td>
                            <td class="text-center">{{ $waktu_menetap_formatted }}</td>
                            <td>
                                <button onclick="tambahPasienKeluar(
                                    {{ json_encode($pasien) }},
                                    '{{ $pasien->waktu_masuk }}')" 
                                type="button" class="btn btn-edit btn-primary">Tambah Pasien Keluar</button>
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($decryptedData['pasien_pindahKeluar'] as $pasien)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $pasien->no_rm }}</td>
                            <td> {{ $pasien->nama_pasien }}</td>    
                            <td> {{ $pasien->jenis_kelamin }}</td>
                            @php 
                                $bangsal_terbaru =  optional($pasien)->bangsal_terbaru();
                            @endphp
                            <td>
                                {{ $bangsal_terbaru['bangsal']->nama_bangsal ?? '-' }}
                                ({{ $bangsal_terbaru['kelas']->nama_kelas ?? '-' }})
                                [{{ $bangsal_terbaru['kelas']->jenis_kelas ?? '-' }}]
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($pasien->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                            </td>
                            @php
                                $waktu_menetap = Carbon::parse($pasien->waktu_masuk)->diff(Carbon::now());
                                $years = $waktu_menetap->y;
                                $months = $waktu_menetap->m;
                                $days = $waktu_menetap->d;
                                $hours = $waktu_menetap->h;
                                $minutes = $waktu_menetap->i;

                                $waktu_menetap_formatted = '';
                                if ($years > 0) {
                                    $waktu_menetap_formatted .= $years . ' tahun, ';
                                }
                                if ($months > 0) {
                                    $waktu_menetap_formatted .= $months . ' bulan, ';
                                }
                                if ($days > 0) {
                                    $waktu_menetap_formatted .= $days . ' hari, ';
                                }
                                if ($hours > 0) {
                                    $waktu_menetap_formatted .= $hours . ' jam, ';
                                }
                                if ($minutes > 0) {
                                    $waktu_menetap_formatted .= $minutes . ' menit';
                                }
                                $waktu_menetap_formatted = rtrim($waktu_menetap_formatted, ', ');
                            @endphp
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($pasien->pasien_pindahs->waktu_pindah)->translatedFormat('d F Y (H:i)') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">Sudah Pernah Pindah</span>
                            </td>
                            <td class="text-center">{{ $waktu_menetap_formatted }}</td>
                            <td>
                                <button onclick="tambahPasienKeluar(
                                    {{ json_encode($pasien) }},
                                    '{{ $pasien->pasien_pindahs->waktu_pindah }}')" 
                                type="button" class="btn btn-edit btn-primary">Tambah Pasien Keluar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!--Tabel Pasien Keluar -->
        <div class="container-tabel-pasien col-12" style="display: none;">
            <table id="tabel-pasien-keluar-id"  class="table table-striped table-hover table-sm">
                <thead class="table-header table-color align-middle">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">No RM</th>
                        <th class="text-center">Nama Pasien</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Waktu Masuk</th>
                        <th class="text-center">Waktu Keluar</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Bangsal Terakhir</th>
                        <th class="text-center">Total Waktu Menetap</th>
                        <th class="text-center">Cara Keluar</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($decryptedData['DataPasienKeluar'] as $pasien)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $pasien->pasien_masuk->no_rm }}</td>
                            <td>{{ $pasien->pasien_masuk->nama_pasien }}</td>
                            <td>{{ $pasien->pasien_masuk->jenis_kelamin }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($pasien->pasien_masuk->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($pasien->waktu_keluar)->translatedFormat('d F Y (H:i)') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">Belum Pernah Pindah</span>
                            </td>
                             
                            @php 
                                $bangsal_terakhir = $pasien->bangsal_terakhir(); 
                            @endphp
                            <td>
                                {{ $bangsal_terakhir['bangsal']->nama_bangsal ?? '-' }}
                                ({{ $bangsal_terakhir['kelas']->nama_kelas ?? '-' }})
                                [{{ $bangsal_terakhir['kelas']->jenis_kelas ?? '-' }}]
                            </td>
                        
                            @php
                                $waktu_menetap = Carbon::parse($pasien->pasien_masuk->waktu_masuk)->diff(Carbon::parse($pasien->waktu_keluar));
                                $years = $waktu_menetap->y;
                                $months = $waktu_menetap->m;
                                $days = $waktu_menetap->d;
                                $hours = $waktu_menetap->h;
                                $minutes = $waktu_menetap->i;

                                $waktu_menetap_formatted = '';
                                if ($years > 0) {
                                    $waktu_menetap_formatted .= $years . ' tahun, ';
                                }
                                if ($months > 0) {
                                    $waktu_menetap_formatted .= $months . ' bulan, ';
                                }
                                if ($days > 0) {
                                    $waktu_menetap_formatted .= $days . ' hari, ';
                                }
                                if ($hours > 0) {
                                    $waktu_menetap_formatted .= $hours . ' jam, ';
                                }
                                if ($minutes > 0) {
                                    $waktu_menetap_formatted .= $minutes . ' menit';
                                }
                                $waktu_menetap_formatted = rtrim($waktu_menetap_formatted, ', ');
                            @endphp
                            <td class="text-center">{{ $waktu_menetap_formatted }}</td>
                            <td>{{ $pasien->cara_keluar }}</td>
                            <td class="text-center">
                                <button id="editButton-{{$pasien->fk_id_pasien_masuk}}" 
                                onclick="editPasienKeluar(
                                    {{$pasien->fk_id_pasien_masuk}},
                                    '{{ $pasien->pasien_masuk->waktu_masuk }}')" 
                                type="button" class="btn btn-edit btn-warning">Edit</button>
                                <form id="form-hapus-pasienKeluar-{{ $pasien->fk_id_pasien_masuk }}" action="{{ route('delete.perawat-pasienKeluar', $pasien->fk_id_pasien_masuk) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-delete btn-danger" onclick="konfirmasiHapusPasienKeluar({{ $pasien->fk_id_pasien_masuk }})">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($decryptedData['DataPasienKeluar_pindah'] as $pasien)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $pasien->pasien_masuk->no_rm }}</td>
                            <td>{{ $pasien->pasien_masuk->nama_pasien }}</td>
                            <td>{{ $pasien->pasien_masuk->jenis_kelamin }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($pasien->pasien_masuk->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($pasien->waktu_keluar)->translatedFormat('d F Y (H:i)') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">Sudah Pernah Pindah</span>
                            </td>
                             
                            @php 
                                $bangsal_terakhir = $pasien->bangsal_terakhir(); 
                            @endphp
                            <td>
                                {{ $bangsal_terakhir['bangsal']->nama_bangsal ?? '-' }}
                                ({{ $bangsal_terakhir['kelas']->nama_kelas ?? '-' }})
                                [{{ $bangsal_terakhir['kelas']->jenis_kelas ?? '-' }}]
                            </td>
                        
                            @php
                                $waktu_menetap = Carbon::parse($pasien->pasien_masuk->waktu_masuk)->diff(Carbon::parse($pasien->waktu_keluar));
                                $years = $waktu_menetap->y;
                                $months = $waktu_menetap->m;
                                $days = $waktu_menetap->d;
                                $hours = $waktu_menetap->h;
                                $minutes = $waktu_menetap->i;

                                $waktu_menetap_formatted = '';
                                if ($years > 0) {
                                    $waktu_menetap_formatted .= $years . ' tahun, ';
                                }
                                if ($months > 0) {
                                    $waktu_menetap_formatted .= $months . ' bulan, ';
                                }
                                if ($days > 0) {
                                    $waktu_menetap_formatted .= $days . ' hari, ';
                                }
                                if ($hours > 0) {
                                    $waktu_menetap_formatted .= $hours . ' jam, ';
                                }
                                if ($minutes > 0) {
                                    $waktu_menetap_formatted .= $minutes . ' menit';
                                }
                                $waktu_menetap_formatted = rtrim($waktu_menetap_formatted, ', ');
                            @endphp
                            <td class="text-center">{{ $waktu_menetap_formatted }}</td>
                            <td>{{ $pasien->cara_keluar }}</td>
                            <td class="text-center">
                                <button id="editButton-{{$pasien->fk_id_pasien_masuk}}" 
                                onclick="editPasienKeluar(
                                    {{$pasien->fk_id_pasien_masuk}},
                                    '{{ optional($pasien->pasien_masuk->pasien_pindahs->sortByDesc('waktu_pindah')->first())->waktu_pindah }}')"
                                type="button" class="btn btn-edit btn-warning">Edit</button>
                                <form id="form-hapus-pasienKeluar-{{ $pasien->fk_id_pasien_masuk }}" action="{{ route('delete.perawat-pasienKeluar', $pasien->fk_id_pasien_masuk) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-delete btn-danger" onclick="konfirmasiHapusPasienKeluar({{ $pasien->fk_id_pasien_masuk }})">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Form Tambah Pasien Keluar -->
        <div class="container-form-input col-12 mt-2" style="display: none;">
            <!-- Tambahkan logo panah untuk kembali dan jadikan panah itu button -->
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" onclick="updateContentDisplay()">
                <i class="bi bi-arrow-left"></i> Kembali
                </button>
            </div>
            <h5>Tambah Pasien Keluar</h5>
            <form action="{{ route('store.perawat-pasienKeluar') }}" 
            method="POST" onsubmit="return cekPasienKeluar(event)">
                @csrf
                <div class="row center">
                    <!-- Kolom Pertama -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="no_rm" class="form-label">No RM</label>
                            <input type="text" class="form-control" id="tambah_no_rm" name="no_rm" readonly>
                            <input type="hidden" class="form-control" id="tambah_id_pasien_masuk" name="fk_id_pasien_masuk">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                            <label for="nama_pasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="tambah_nama_pasien" name="nama_pasien" readonly>
                        </div>
                    </div>

                    <!-- Kolom Kedua -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
                            <input type="datetime-local" class="form-control" id="tambah_waktu_keluar" name="waktu_keluar">
                            <input type="hidden" class="form-control" id="waktu_masuk_or_pindah">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="Cara_Keluar" class="form-label">Cara Keluar</label>
                            <select class="form-select" id="tambah_cara_keluar" name="cara_keluar">
                                <option value="Hidup">Hidup</option>
                                <option value="Meninggal">Meninggal</option>
                                <option value="Dipindahkan">Dipindahkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close" >Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Edit Pasien Keluar -->
    <div class="modal fade" id="modalPasienKeluar" tabindex="-1" aria-labelledby="modalPasienKeluarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPasienKeluarLabel">Edit Pasien Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">                
                    <!-- Form Pasien Keluar -->
                    <form id="editPasienKeluarForm" 
                    method="POST" onsubmit="return cekEditPasienKeluar()">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_rm" class="form-label">No RM</label>
                                    <input type="text" class="form-control" id="edit_no_rm" name="no_rm" readonly>
                                    <input type="hidden" class="form-control" id="edit_fk_id_pasien_masuk" name="fk_id_pasien_masuk">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="edit_nama_pasien" name="nama_pasien" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
                                    <input type="datetime-local" class="form-control" id="edit_waktu_keluar" name="waktu_keluar" required>
                                    <input type="hidden" class="form-control" id="waktu_masuk_or_pindah">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cara_keluar" class="form-label">Cara Keluar</label>
                                    <select class="form-select" id="edit_cara_keluar" name="cara_keluar" required>
                                        <option value="Hidup">Hidup</option>
                                        <option value="Meninggal">Meninggal</option>
                                        <option value="Dipindahkan">Dipindahkan</option>
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

@push('scripts')
<script>
    // Panggil Fungsi saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function () {
        // Panggil fungsi setContentHeight dan setHeaderKontenHeight dari app.js
        setContentHeight();
        setHeaderKontenHeight();

        // Ambil select element
        let selectDataView = document.getElementById('select-data-view');

        // Cek apakah ada data tersimpan di localStorage
        if (localStorage.getItem("selectedDataView_Keluar")) {
            selectDataView.value = localStorage.getItem("selectedDataView_Keluar");
        }

        // Event listener untuk menyimpan perubahan ke localStorage
        selectDataView.addEventListener("change", function () {
            localStorage.setItem("selectedDataView_Keluar", this.value);
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

        // Tunggu DataTables selesai diinisialisasi
        var tables = ['#tabel-cari-pasienKeluar', '#tabel-pasien-keluar-id']; // Tambahkan ID tabel lainnya di sini

        tables.forEach(function (tableId) {
            var table = $(tableId).DataTable();

            table.on('draw.dt', function () {
                var pageInfo = table.page.info();
                var startIndex = pageInfo.start; // Index awal halaman saat ini
                
                // Cek apakah ada data di tabel
                if (table.data().any()) {
                    document.querySelectorAll(`${tableId} tbody tr`).forEach((row, index) => {
                        var firstCell = row.querySelector('td:first-child');
                        if (firstCell) {
                            firstCell.innerText = startIndex + index + 1;
                        }
                    });
                }
            });

            // Jalankan event draw pertama kali agar nomor urut langsung muncul
            table.draw();
        });
    });

</script>
@endpush

<script>
    // Fungsi Edit Pasien Keluar
    function editPasienKeluar(id_pasien_keluar, waktu) {
        // nonaktifkan tombol sementara
        let editButton = document.getElementById(`editButton-${id_pasien_keluar}`);
        if (editButton) editButton.disabled = true; // Disable tombol sementara

        // Set action di form menggunakan route Laravel
        let form = document.getElementById("editPasienKeluarForm");
        form.action = `{{ route('update.perawat-pasienKeluar', ':id') }}`.replace(':id', id_pasien_keluar);

        // set variabel untuk waktu pindah atau masuk pasien
        document.getElementById('waktu_masuk_or_pindah').value = waktu;

        fetch(`/perawat/data-pasien-keluar/${id_pasien_keluar}/edit`)
            .then(response => response.json())
            .then(data => {
                // Isi data pada form
                document.getElementById("edit_fk_id_pasien_masuk").value = data.fk_id_pasien_masuk;
                document.getElementById("edit_no_rm").value = data.pasien_masuk.no_rm;
                document.getElementById("edit_nama_pasien").value = data.pasien_masuk.nama_pasien;
                document.getElementById("edit_waktu_keluar").value = formatDateUTCtoWIB(data.waktu_keluar);
                document.getElementById("edit_cara_keluar").value = data.cara_keluar;

                // Tampilkan modal
                let modal = new bootstrap.Modal(document.getElementById('modalPasienKeluar'));
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

    // Fungsi tambah Pasien Keluar
    function tambahPasienKeluar(pasien, waktu) {
        // set Nilai ke form
        document.getElementById('tambah_no_rm').value = pasien.no_rm;
        document.getElementById('tambah_nama_pasien').value = pasien.nama_pasien;
        document.getElementById('tambah_id_pasien_masuk').value = pasien.id_pasien_masuk;

        // set waktu masuk or pindah
        document.getElementById('waktu_masuk_or_pindah').value = waktu;

        // Sembunyikan tabel pencarian
        document.querySelector('.tabel-cari-pasien').style.display = 'none';

        // Tampilkan form input pasien pindah
        document.querySelector('.container-form-input').style.display = 'block';
    }

    // Fungsi untuk cek apakah semua data sudah diisi memakai sweetalert2
    function cekPasienKeluar(event) {
        event.preventDefault(); // Mencegah form terkirim langsung

        const noRm = document.getElementById('tambah_no_rm').value;
        const namaPasien = document.getElementById('tambah_nama_pasien').value;
        const waktuKeluar = document.getElementById('tambah_waktu_keluar').value;
        const caraKeluar = document.getElementById('tambah_cara_keluar').value;

        const WaktuMasukOrPindah = document.getElementById('waktu_masuk_or_pindah').value;

        // debug
        // console.log('Waktu Masuk/Pindah:', WaktuMasukOrPindah);
        // console.log('Waktu Keluar:', waktuKeluar);

        // ubah format waktu Masuk/pindah agar lebih mudah dibaca
        let waktuMoP_Parsed = new Date(WaktuMasukOrPindah).toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            timeZoneName: 'short'
        });

        if (!noRm || !namaPasien || !waktuKeluar || !caraKeluar) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap!',
                text: 'Semua kolom wajib diisi!',
            });
            return false;
        }
        
        if (new Date(waktuKeluar) <= new Date(WaktuMasukOrPindah)) {
            Swal.fire({
                icon: 'error',
                title: 'Waktu Keluar Tidak Valid!',
                html: 'Waktu keluar saat ini harus lebih besar dari waktu masuk/pindah sebelumnya!<br><br><b>Waktu masuk/pindah pasien sebelumnya:</b> <br>' + waktuMoP_Parsed,
            });
            return false;
        }

        // Tampilkan loading
        loadingStatus();

        // Jika semua valid, submit form secara manual
        event.target.submit();
    }

    // Fungsi untuk cek form edit pasien keluar
    function cekEditPasienKeluar(){
        // Ambil data form
        let waktuKeluar = document.getElementById('edit_waktu_keluar').value;
        let waktuMasuk = document.getElementById('waktu_masuk_or_pindah').value;

        // Ubah format waktu masuk agar lebih mudah dibaca
        let waktuMoP_Parsed = new Date(waktuMasuk).toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            timeZoneName: 'short'
        });

        // Cek apakah waktu keluar lebih kecil dari waktu masuk
        if (new Date(waktuKeluar) <= new Date(waktuMasuk)) {
            Swal.fire({
                icon: 'error',
                title: 'Waktu Keluar Tidak Valid!',
                html: 'Waktu keluar saat ini harus lebih besar dari waktu masuk/pindah sebelumnya!<br><br><b>Waktu masuk/pindah pasien sebelumnya:</b> <br>' + waktuMoP_Parsed,
            });
            return false;
        }

        // Tampilkan loading
        loadingStatus();

        // Submit form
        document.getElementById('editPasienKeluarForm').submit();
    }

    // Fungsi konfirmasi hapus data pasien keluar
    function konfirmasiHapusPasienKeluar(id) {
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
                // Tampilkan loading
                loadingStatus();

                document.getElementById(`form-hapus-pasienKeluar-${id}`).submit();
            }
        });
    }

    // Fungsi untuk inisialisasi DataTables
    function initializeDataTable() {
        // Daftarkan format custom di moment.js untuk DataTables
        $.fn.dataTable.moment("DD MMMM YYYY (HH:mm)");

        if (!$.fn.DataTable.isDataTable('#tabel-cari-pasienKeluar')) {
            new DataTable('#tabel-cari-pasienKeluar', {
                columnDefs: [
                    {
                        targets: [5, 6],  // Kolom "Waktu Masuk" (Index ke-3)
                        type: "datetime-moment",
                        render: function (data, type, row) {
                            return type === 'sort' ? moment(data, "DD MMMM YYYY (HH:mm)").format("YYYY-MM-DD HH:mm") : data;
                        }
                    }
                ],
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
                paging: true,
                pageLength: -1,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                scrollCollapse: true,
                scrollY: "290px",
                scrollX: true,
                autoWidth: false,
                order: [[5, "desc"]],
                buttons: [
                    { extend: 'copy', 
                        text: '<i class="bi bi-clipboard-fill"></i> Copy', 
                        exportOptions: { columns: ':not(:last-child)' }, 
                        title: 'Pasien Keluar' },
                    { extend: 'excel', text: '<i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel', 
                        exportOptions: { columns: ':not(:last-child)' }, 
                        title: 'Pasien Keluar' },
                    { extend: 'pdf', text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF', 
                        exportOptions: { columns: ':not(:last-child)' }, 
                        title: 'Pasien Keluar' },
                    { extend: 'print', text: '<i class="bi bi-printer-fill"></i> Print',
                        exportOptions: { columns: ':not(:last-child)' }, 
                        title: 'Pasien Keluar' },
                    {
                        text: '<i class="bi bi-caret-down-square"></i> Detail off',
                        action: function (e, dt, node, config) {
                            var columns = [3, 6, 8]; // Kolom Bangsal Sebelumnya, Waktu Masuk, Waktu Pindah
                            var isHidden = dt.column(columns[0]).visible();

                            columns.forEach(function (colIdx) {
                                dt.column(colIdx).visible(!isHidden);
                            });

                            // Ubah teks tombol
                            var newText = isHidden ? '<i class="bi bi-caret-up-square"></i> Detail off' : '<i class="bi bi-caret-down-square"></i> Detail on';
                            $(node).html(newText);
                        }
                    }
                ],
                columnDefs: [
                    { targets: [3, 6, 8], visible: false } // Kolom Bangsal Sebelumnya, Waktu Masuk, Waktu Pindah disembunyikan
                ],
                rowCallback: function (row, data, index) {
                    // Menampilkan nomor urut secara berkelanjutan
                    $('td:eq(0)', row).html(index + 1);
                }
            });
        }
        if (!$.fn.DataTable.isDataTable('#tabel-pasien-keluar-id')) {
            new DataTable ('#tabel-pasien-keluar-id', {
                columnDefs: [
                    {
                        targets: [4, 5], // Kolom "Waktu Masuk" dan "Waktu Keluar"
                        type: "datetime-moment",
                        render: function (data, type, row) {
                            return type === 'sort' ? moment(data, "DD MMMM YYYY (HH:mm)").format("YYYY-MM-DD HH:mm") : data;
                        }
                    }
                ],
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
                scrollY: "290px", // Atur tinggi maksimal
                scrollX: true, // Aktifkan scroll horizontal
                autoWidth: false, // Atur lebar tabel secara otomatis

                // Urutkan berdasarkan kolom yang ditentukan secara DESC
                order: [[5, "desc"]],

                buttons: [
                    {   extend: 'copy', 
                        text: '<i class="bi bi-clipboard-fill"></i> Copy', 
                        exportOptions: { columns: ':not(:last-child)' },
                        title: 'Pasien Keluar'
                    },
                    
                    {   extend: 'excel', 
                        text: '<i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel', 
                        exportOptions: { columns: ':not(:last-child)' },
                        title: 'Pasien Keluar'
                    },
                    
                    {   extend: 'pdf', 
                        text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF', 
                        exportOptions: { columns: ':not(:last-child)' },
                        title: 'Pasien Keluar'
                    },
                    {   extend: 'print', 
                        text: '<i class="bi bi-printer-fill"></i> Print', 
                        exportOptions: { columns: ':not(:last-child)' },
                        title: 'Pasien Keluar'
                    },
                    {
                        text: '<i class="bi bi-caret-down-square"></i> Detail off',
                        action: function (e, dt, node, config) {
                            var columns = [3, 5, 7, 8]; // Kolom Bangsal Sebelumnya, Waktu Masuk, Waktu Pindah
                            var isHidden = dt.column(columns[0]).visible();

                            columns.forEach(function (colIdx) {
                                dt.column(colIdx).visible(!isHidden);
                            });

                            // Ubah teks tombol
                            var newText = isHidden ? '<i class="bi bi-caret-up-square"></i> Detail off' : '<i class="bi bi-caret-down-square"></i> Detail on';
                            $(node).html(newText);
                        }
                    }
                ],
                columnDefs: [
                    { targets: [3, 5, 7, 8], visible: false } // Kolom Bangsal Sebelumnya, Waktu Masuk, Waktu Pindah disembunyikan
                ],
                rowCallback: function (row, data, index) {
                    // Menampilkan nomor urut secara berkelanjutan
                    $('td:eq(0)', row).html(index + 1);
                }
            });
        }
    }

    // Fungsi untuk menampilkan konten
    function updateContentDisplay() {
        // Ambil elemen
        const containerTabelPasien = $('.container-tabel-pasien');
        const containertabelPencarian = $('.tabel-cari-pasien');
        const formInputPasienKeluar = $('.container-form-input');

        // Ambil nilai dari select element
        let selectDataView = document.getElementById('select-data-view');
        let selectedValue = selectDataView.value;

        $(".loading").hide();

        // Pastikan DataTable hanya diinisialisasi jika belum ada
        if (selectedValue == '1') {
            containertabelPencarian.css('display', 'block');
            containerTabelPasien.css('display', 'none');
            formInputPasienKeluar.css('display', 'none');
            $('#tabel-pasien-keluar-id').hide(); // Sembunyikan
            $('#tabel-cari-pasienKeluar').show();
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        } else if (selectedValue == '2') {
            containertabelPencarian.css('display', 'none');
            containerTabelPasien.css('display', 'block');
            formInputPasienKeluar.css('display', 'none');
            $('#tabel-cari-pasienKeluar').hide(); // Sembunyikan
            $('#tabel-pasien-keluar-id').show();
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        } else {
            console.error('Nilai selectedValue tidak ditemukan');
        }
    }

    window.onload = function () {
        const container = document.querySelector('.pasien-keluar-container');

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

    /* Style untuk kontainer */
    .pasien-keluar-container {
        transition: opacity 0.4s ease-in-out;
    }
</style>