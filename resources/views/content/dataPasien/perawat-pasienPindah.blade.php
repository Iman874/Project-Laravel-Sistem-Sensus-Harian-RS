@php
    use Carbon\Carbon;
    $decryptedData = decrypt($data);
@endphp

<div class="pasien-pindah-container card border-0 mt-1 p-3" style="opacity: 0;">
    <!-- Pilih data -->
    <div class="row">
        <!-- Input Pilihan -->
        <div class="col-12">
            <select class="form-select" id="select-data-view">
                <option value="1">Input Pasien Pindah</option>
                <option value="2">Tabel Pasien Pindah</option>
            </select>
        </div>
    </div>

    <!-- Tabel Pencarian -->
    <div class="tabel-cari-pasien" style="display: none;">
        <table id="tabel-cari-pasienPindah" class="table table-striped table-hover table-sm">
            <thead class="table-header table-color align-middle">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">No RM</th>
                    <th class="text-center">Nama Pasien</th>
                    <th class="text-center">Waktu Masuk/Pindah</th> <!-- kolom detail -->
                    <th class="text-center">Jenis Kelamin</th> <!-- kolom detail -->
                    <th class="text-center">Bangsal Sebelumnya</th> <!-- kolom detail -->
                    <th class="text-center">Bangsal Saat Ini</th>
                    <th class="text-center">Status</th> <!-- kolom detail -->
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="dataTable">
                {{-- Pasien yang belum pernah pindah --}}
                @foreach ($decryptedData['pasien_masukPindah'] as $pasien)
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">{{ $pasien->no_rm }}</td>
                        <td>{{ $pasien->nama_pasien }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($pasien->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                        </td>
                        <td>{{ $pasien->jenis_kelamin }}</td>
                        <td>-</td> {{-- Tidak ada bangsal sebelumnya --}}
                        <td>{{ $pasien->bangsal->nama_bangsal }}
                            ({{ $pasien->kelas_bangsal->nama_kelas ?? 'Tidak ada Kelas' }}
                            [{{ $pasien->kelas_bangsal->jenis_kelas ?? '-' }}])
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge bg-success">Belum Pernah Pindah</span>
                        </td>
                        @php $status = 'belum_pernah_pindah'; @endphp
                        <td class="text-center">
                            <button
                                onclick="tambahPasienPindah(
                                    {{ json_encode($pasien) }}, 
                                    {{ json_encode($pasien->bangsal) }}, 
                                    {{ json_encode($pasien->kelas_bangsal) }},
                                    {{ json_encode($decryptedData['bangsal']) }},
                                    '{{ $pasien->waktu_masuk }}'"
                                type="button" class="btn btn-edit btn-primary">Tambah Pasien Pindah</button>
                        </td>
                    </tr>
                @endforeach

                {{-- Pasien yang sudah pernah pindah --}}
                @foreach ($decryptedData['pasien_pindah'] as $pasienPindah)
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center">{{ $pasienPindah->pasien_masuk->no_rm }}</td>
                        <td>{{ $pasienPindah->pasien_masuk->nama_pasien }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($pasienPindah->waktu_pindah)->translatedFormat('d F Y (H:i)') }}
                        </td>
                        <td>{{ $pasienPindah->pasien_masuk->jenis_kelamin }}</td>
                        <td>{{ $pasienPindah->bangsal_asal->nama_bangsal ?? 'Tidak ada Bangsal' }}
                            ({{ $pasienPindah->kelas_bangsal_asal->nama_kelas ?? 'Tidak ada Kelas' }}
                            [{{ $pasienPindah->kelas_bangsal_asal->jenis_kelas ?? '-' }}])
                        </td>
                        <td>{{ $pasienPindah->bangsal_tujuan->nama_bangsal ?? 'Tidak ada Bangsal' }}
                            ({{ $pasienPindah->kelas_bangsal_tujuan->nama_kelas ?? 'Tidak ada Kelas' }}
                            [{{ $pasienPindah->kelas_bangsal_tujuan->jenis_kelas ?? '-' }}] )
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge bg-danger">Sudah Pernah Pindah</span>
                        </td>
                        @php
                            $status = 'pernah_pindah';

                            $waktu_pindah_sebelumnya = Carbon::parse($pasienPindah->waktu_pindah);
                            // Ambil data terbaru berdasarkan kondisi yang diberikan
                            $pindah_terbaru = $decryptedData['pasien_pindahTerbaru']
                                ->where('fk_id_pasien_masuk', $pasienPindah->fk_id_pasien_masuk)
                                ->first();

                            // Pastikan $pindah_terbaru tidak null sebelum mengakses waktunya
                            $waktu_pindah_terbaru = $pindah_terbaru
                                ? Carbon::parse($pindah_terbaru->waktu_pindah)
                                : null;
                        @endphp

                        @if ($waktu_pindah_sebelumnya < $waktu_pindah_terbaru && $penempatan !== $pasienPindah->bangsal_asal->nama_bangsal)
                            <td class="align-middle text-center">
                                <span class="badge bg-secondary">data history</span>
                            </td>
                        @elseif($penempatan !== $pasienPindah->bangsal_tujuan->nama_bangsal)
                            <td class="align-middle text-center">
                                <span class="badge bg-secondary">data history</span>
                            </td>
                        @elseif($pindah_terbaru->id_pindah !== $pasienPindah->id_pindah)
                            <td class="align-middle text-center">
                                <span class="badge bg-secondary">data history</span>
                            </td>
                        @else
                            <td class="text-center">
                                <button
                                    onclick="tambahPasienPindah(
                                    {{ json_encode($pasienPindah->pasien_masuk) }}, 
                                    {{ json_encode($pasienPindah->bangsal_tujuan) }}, 
                                    {{ json_encode($pasienPindah->kelas_bangsal_tujuan) }},
                                    {{ json_encode($decryptedData['bangsal']) }},
                                    '{{ $pasienPindah->waktu_pindah }}')"
                                    type="button" class="btn btn-edit btn-primary">Tambah Pasien Pindah</button>
                            </td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <!-- Tabel Pasien Pindah -->
    <div class="container-tabel-pasien" style="display: none;">
        <table id="tabel-pasien-pindah-id" class="table table-striped table-hover table-sm">
            <thead class="table-header table-color align-middle">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">No RM</th>
                    <th class="text-center">Nama Pasien</th>
                    <th class="text-center">Waktu Masuk</th>
                    <th class="text-center">Waktu Pindah</th>
                    <th class="text-center">Bangsal Sebelumnya</th>
                    <th class="text-center">Bangsal Saat ini</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="dataTable">
                @foreach ($decryptedData['pasien_pindah'] as $index => $pasien)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $pasien->pasien_masuk->no_rm }}</td>
                        <td>{{ $pasien->pasien_masuk->nama_pasien }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($pasien->pasien_masuk->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($pasien->waktu_pindah)->translatedFormat('d F Y (H:i)') }}</td>
                        <td>
                            {{ $pasien->bangsal_asal->nama_bangsal }}
                            ({{ $pasien->kelas_bangsal_asal->nama_kelas }}
                            [{{ $pasien->kelas_bangsal_asal->jenis_kelas }}])
                        </td>
                        <td>
                            {{ $pasien->bangsal_tujuan->nama_bangsal }}
                            ( {{ $pasien->kelas_bangsal_tujuan->nama_kelas }}
                            [{{ $pasien->kelas_bangsal_tujuan->jenis_kelas }}] )
                        </td>

                        @php
                            $waktu_pindah_sebelumnya = $pasien->waktu_pindah
                                ? Carbon::parse($pasien->waktu_pindah)
                                : null;
                            // Ambil data terbaru berdasarkan kondisi yang diberikan
                            $pindah_terbaru = $decryptedData['pasien_pindahTerbaru']
                                ->where('fk_id_pasien_masuk', $pasien->fk_id_pasien_masuk)
                                ->first();

                            // Pastikan $pindah_terbaru tidak null sebelum mengakses waktunya
                            $waktu_pindah_terbaru = $pindah_terbaru
                                ? Carbon::parse($pindah_terbaru->waktu_pindah)
                                : null;
                        @endphp

                        @if (
                            $waktu_pindah_sebelumnya !== null &&
                                $waktu_pindah_terbaru !== null &&
                                $waktu_pindah_sebelumnya < $waktu_pindah_terbaru &&
                                $penempatan !== $pasien->bangsal_asal->nama_bangsal)
                            <td class="align-middle">
                                <span class="badge bg-secondary">Tidak Bisa Edit</span>
                                <span></span>
                            </td>
                        @elseif($pindah_terbaru->id_pindah !== $pasien->id_pindah)
                            <td class="align-middle">
                                <span class="badge bg-secondary">Tidak Bisa Edit</span>
                                <span></span>
                            </td>
                        @else
                            <td>
                                <button id="editButton-{{ $pasien->id_pindah }}" data-bs-toggle="modal"
                                    data-bs-target="#modalPasienPindah"
                                    onclick="editPasienPindah(
                                    {{ $pasien->id_pindah }}, 
                                    {{ json_encode($pasien->kelas_bangsal_tujuan) }},
                                    {{ json_encode($pasien->bangsal_asal) }},
                                    {{ json_encode($pasien->kelas_bangsal_asal) }},
                                    {{ $decryptedData['bangsal'] }})"
                                    class="btn btn-edit btn-warning">Edit</button>

                                <form id="form-hapus-pasienPindah-{{ $pasien->id_pindah }}"
                                    action="{{ route('delete.perawat-pasienPindah', $pasien->id_pindah) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-danger"
                                        onclick="konfirmasiHapusPasienPindah({{ $pasien->fk_id_pasien_masuk }})">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Form Input Pasien Pindah -->
    <div class="container-form-input mt-2" style="display: none;">
        <!-- Tambahkan logo panah untuk kembali dan jadikan panah itu button -->
        <div class="mb-3">
            <button type="button" class="btn btn-secondary" onclick="updateContentDisplay()">
                <i class="bi bi-arrow-left"></i> Kembali
            </button>
        </div>
        <h5>Tambah Pasien Pindah</h5>
        <form action="{{ route('store.perawat-pasienPindah') }}" method="POST"
            onsubmit="return cekPasienPindah(event)">
            @csrf
            <div class="body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tambah_no_rm" class="form-label">No RM</label>
                            <input type="text" class="form-control" id="tambah_no_rm" name="no_rm" readonly>
                            <input type="hidden" id="tambah_id_pasien_masuk" name="fk_id_pasien_masuk">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tambah_nama_pasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="tambah_nama_pasien" name="nama_pasien"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tambah_waktu_pindah" class="form-label">Waktu Pindah</label>
                            <input type="datetime-local" class="form-control" id="tambah_waktu_pindah"
                                name="waktu_pindah">
                            <input type="hidden" id="tambah_waktu_masuk" name="waktu_masuk">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tambah_asal_bangsal" class="form-label">Asal Bangsal</label>
                            <input type="text" class="form-control" id="tambah_asal_bangsal" name="nama_bangsal"
                                readonly>
                            <input type="hidden" id="tambah_id_asal_bangsal" name="fk_asal_bangsal">
                            <input type="hidden" id="tambah_id_kelas_bangsal_asal" name="fk_id_kelas_asal">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tambah_tujuan_bangsal" class="form-label">Tujuan Bangsal</label>
                            <select class="form-select" id="tambah_tujuan_bangsal" name="fk_tujuan_bangsal">
                                <option value="">Pilih Bangsal Tujuan</option>
                            </select>
                            <input type="hidden" id="tambah_id_kelas_bangsal_tujuan" name="fk_id_kelas_tujuan">
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"
                    onclick="updateContentDisplay()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pasien Pindah -->
<div class="modal fade" id="modalPasienPindah" tabindex="-1" aria-labelledby="modalPasienPindahLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienPindahLabel">Edit Pasien Pindah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Edit Data Pasien Pindah</p>
                <!-- Form Pasien Pindah -->
                <form id="editPasienPindahForm" method="POST" onsubmit="return cekEditPasienPindah()">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_rm" class="form-label">No RM</label>
                                <input type="text" class="form-control" id="edit_no_rm" name="no_rm" readonly>
                                <input type="hidden" class="form-control" id="edit_fk_id_pasien_masuk"
                                    name="fk_id_pasien_masuk">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                <input type="text" class="form-control" id="edit_nama_pasien" name="nama_pasien"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="waktu_pindah" class="form-label">Waktu Pindah</label>
                                <input type="datetime-local" class="form-control" id="edit_waktu_pindah"
                                    name="waktu_pindah" required data-waktu-awal="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="asal_bangsal" class="form-label">Asal Bangsal</label>
                                <input type="text" class="form-control" id="edit_asal_bangsal"
                                    name="fk_asal_bangsal" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tujuan_bangsal" class="form-label">Tujuan Bangsal</label>
                                <select class="form-select" id="edit_tujuan_bangsal" name="fk_tujuan_bangsal"
                                    required>
                                </select>
                                <input type="hidden" id="edit_id_kelas_bangsal_tujuan" name="fk_id_kelas_tujuan">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            aria-label="Close">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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

@push('scripts')
    <script>
        // Muat fungsi setelah halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Panggil fungsi setContentHeight dan setHeaderKontenHeight dari app.js
            setContentHeight();
            setHeaderKontenHeight();

            // Tetapkan nilai kelas id bangsal tujuan ke elemen hidden
            document.getElementById('tambah_tujuan_bangsal').addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                document.getElementById('tambah_id_kelas_bangsal_tujuan').value = selectedOption.getAttribute('data-kelas');
            });

            // Tetapkan nilai kelas id bangsal tujuan-edit ke elemen hidden
            document.getElementById('edit_tujuan_bangsal').addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                document.getElementById('edit_id_kelas_bangsal_tujuan').value = selectedOption.getAttribute('edit-data-kelas');
            });

            // Ambil select element
            let selectDataView = document.getElementById('select-data-view');

            // Cek apakah ada data tersimpan di localStorage
            if (localStorage.getItem("selectedDataView_Pindah")) {
                selectDataView.value = localStorage.getItem("selectedDataView_Pindah");
            }

            // Event listener untuk menyimpan perubahan ke localStorage
            selectDataView.addEventListener("change", function() {
                localStorage.setItem("selectedDataView_Pindah", this.value);
                updateContentDisplay();
            });

            // Jika sudah ada datatable yang ada maka hancurkan dulu
            $('table.dataTable').each(function() {
                $(this).DataTable().destroy();
            });

            // Inisialisasi DataTable
            initializeDataTable();

            // Tampilkan konten setelah 200ms
            setTimeout(() => {
                updateContentDisplay();
            }, 200);

            // Tunggu DataTables selesai diinisialisasi
            var tables = ['#tabel-cari-pasienPindah']; // Tambahkan ID tabel lainnya di sini

            tables.forEach(function(tableId) {
                var table = $(tableId).DataTable();

                table.on('draw.dt', function() {
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
    // Fungsi Tambah Pasien Pindah
    function tambahPasienPindah(pasien, bangsalPasien, KelasPasien, dataBangsal, waktu) {
        // Isi nilai input dalam modal
        document.getElementById('tambah_no_rm').value = pasien.no_rm;
        document.getElementById('tambah_nama_pasien').value = pasien.nama_pasien;
        document.getElementById('tambah_id_pasien_masuk').value = pasien.id_pasien_masuk; // elemen hidden
        document.getElementById('tambah_asal_bangsal').value = bangsalPasien.nama_bangsal + ' (' + KelasPasien.nama_kelas + ' [' + KelasPasien.jenis_kelas + '] )';
        document.getElementById('tambah_id_asal_bangsal').value = bangsalPasien.kd_bangsal; // elemen hidden
        document.getElementById('tambah_id_kelas_bangsal_asal').value = KelasPasien.id_kelas; // elemen hidden
        document.getElementById('tambah_waktu_masuk').value = waktu;

        // Kosongkan dan isi ulang dropdown tujuan bangsal
        let tujuanBangsalDropdown = document.getElementById('tambah_tujuan_bangsal');
        tujuanBangsalDropdown.innerHTML = '<option value="">Pilih Bangsal Tujuan</option>';

        // Saring data bangsal, hanya ambil yang berbeda dari bangsal asal
        dataBangsal.forEach(bangsal => {
            bangsal.kelas_bangsals.forEach(kelasBangsal => {
                if (!(bangsal.kd_bangsal === bangsalPasien.kd_bangsal && kelasBangsal.id_kelas ===
                        KelasPasien.id_kelas)) {
                    let option = document.createElement('option');
                    option.value = bangsal.kd_bangsal;
                    option.setAttribute('data-kelas', kelasBangsal.id_kelas);
                    option.textContent = bangsal.nama_bangsal + ' (' + kelasBangsal.nama_kelas + ' [' +
                        kelasBangsal.jenis_kelas + '] )';
                    tujuanBangsalDropdown.appendChild(option);
                }
            });
        });

        // Sembunyikan tabel pencarian
        document.querySelector('.tabel-cari-pasien').style.display = 'none';

        // Tampilkan form input pasien pindah
        document.querySelector('.container-form-input').style.display = 'block';
    }

    // Fungsi Edit Pasien Pindah
    function editPasienPindah(id_pasien_pindah, KelasTujuan, BangsalAsal, KelasAsal, dataBangsal) {
        // Nonaktifkan tombol sementara
        let editButton = document.getElementById(`editButton-${id_pasien_pindah}`);
        if (editButton) {
            editButton.disabled = true; // Disable tombol sementara
        }

        // Set action di form menggunakan route Laravel
        let form = document.getElementById("editPasienPindahForm");
        form.action = `{{ route('update.perawat-pasienPindah', ':id') }}`.replace(':id', id_pasien_pindah);

        // Reset dropdown sebelum mengisi ulang
        let selectBangsal = document.getElementById('edit_tujuan_bangsal');
        selectBangsal.innerHTML = '<option value="">Pilih Bangsal Tujuan</option>';

        // set data bangsal asal dan kelas asal
        let bangsal_asal = BangsalAsal.nama_bangsal;
        let kelas_asal = KelasAsal.nama_kelas + ' [' + KelasAsal.jenis_kelas + ']';
        document.getElementById('edit_asal_bangsal').value = bangsal_asal + ' (' + kelas_asal + ')';

        fetch(`/perawat/data-pasien-pindah/${id_pasien_pindah}/edit`)
            .then(response => response.json())
            .then(data => {
                // Isi data pada form
                document.getElementById("edit_fk_id_pasien_masuk").value = data.fk_id_pasien_masuk;
                document.getElementById("edit_no_rm").value = data.pasien_masuk.no_rm;
                document.getElementById("edit_nama_pasien").value = data.pasien_masuk.nama_pasien;
                document.getElementById("edit_waktu_pindah").value = formatDateUTCtoWIB(data.waktu_pindah);

                // Ambil data bangsal tujuan
                let bangsal_tujuan = data.bangsal_tujuan;

                // Ambil data bangsal asal
                let bangsalPasien = data.bangsal_asal;

                // Ambil data kelas pasien
                let KelasPasien = data.kelas_bangsal_asal;

                // Saring data bangsal, hanya ambil yang berbeda dari bangsal asal
                let bangsalTujuan = SeleksiOptionBangsal(dataBangsal, bangsalPasien, KelasPasien);

                bangsalTujuan.forEach(bangsal => {
                    // Buat option baru
                    let option = document.createElement('option');
                    if (bangsal.kd_bangsal === bangsal_tujuan.kd_bangsal) {
                        if (bangsal.kelas_bangsals[0].id_kelas === data.fk_id_kelas_tujuan) {
                            option.selected = true;
                        }
                    }
                    // Isi value dengan kd bangsal
                    option.value = bangsal.kd_bangsal;

                    // Isi option dengan id kelas
                    option.setAttribute('edit-data-kelas', bangsal.kelas_bangsals[0].id_kelas);

                    // Ambil kelas pertama jika ada, jika tidak beri teks default
                    let namaKelas = bangsal.kelas_bangsals.length > 0 ? bangsal.kelas_bangsals[0]
                        .nama_kelas : 'Tidak ada Kelas';
                    let jenisKelas = bangsal.kelas_bangsals.length > 0 ? bangsal.kelas_bangsals[0]
                        .jenis_kelas : '-';

                    // Tambahkan ke dropdown            
                    option.textContent = bangsal.nama_bangsal + ' (' + namaKelas + ' [' + jenisKelas + ']' +
                        ')';
                    selectBangsal.appendChild(option);

                });
            })
            .catch(error => console.error("Gagal mengambil data:", error));
        // Set id bangsal tujuan
        if (document.getElementById('edit_id_kelas_bangsal_tujuan').value == '') {
            document.getElementById('edit_id_kelas_bangsal_tujuan').value = KelasTujuan.id_kelas;
        }

        // Fungsi untuk mengatur backdrop modal
        document.addEventListener('shown.bs.modal', function(event) {
            // Pastikan modal tetap terlihat saat dibuka
            let modal = event.target;
            modal.scrollTop = 0;
            document.body.classList.add('modal-open');

            // Fecth data pasien pindah, ambil data pasien pindah sebelumnya
            fetch(`/perawat/data-pasien-pindah/${id_pasien_pindah}/sebelumnya`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Gagal mengambil data pasien pindah sebelumnya");
                        console.log("Gagal mengambil data pasien pindah sebelumnya");
                    }
                    return response.json();
                })
                .then(data => {

                    // Ambil id waktu pindah
                    let inputWaktuPindah = document.getElementById("edit_waktu_pindah");

                    // Set data waktu pindah sebelumnya
                    if (data.waktu_pindah) {
                        console.log(data.waktu_pindah);
                        inputWaktuPindah.setAttribute("data-waktu-awal", formatDateUTCtoWIB(data
                            .waktu_pindah));
                    } else if (data.waktu_masuk) {
                        console.log(data.waktu_masuk);
                        inputWaktuPindah.setAttribute("data-waktu-awal", formatDateUTCtoWIB(data
                            .waktu_masuk));
                    } else {
                        console.log(
                            "Tidak ada data waktu pindah sebelumnya yang ditemukan. Bahkan relasi ke pasien masuk"
                            );
                        // set waktu awal ke waktu 0 tahun 0 dan bulan 1 waktu WIB
                        inputWaktuPindah.setAttribute("data-waktu-awal", "0000-01-01T00:00");
                    }
                })
                .catch(error => console.error("Gagal mengambil data:", error.message));
        });

        // Fungsi untuk mengatur backdrop modal
        document.addEventListener('hidden.bs.modal', function(event) {
            // Bersihkan backdrop agar tidak menumpuk
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            // aktifkan tombol kembali
            if (editButton) editButton.disabled = false; // Enable tombol kembali
        });
    }

    function SeleksiOptionBangsal(dataBangsal, bangsalAsal, kelasAsal) {
        let hasil = [];

        if (!Array.isArray(dataBangsal) || !bangsalAsal || !kelasAsal) {
            console.warn("Data bangsal tidak valid");
            return [];
        }

        dataBangsal.forEach(bangsal => {
            bangsal.kelas_bangsals.forEach(kelasBangsal => {
                // Hindari memasukkan bangsal dan kelas yang sama dengan asal
                if (!(bangsal.kd_bangsal === bangsalAsal.kd_bangsal && kelasBangsal.id_kelas ===
                        kelasAsal.id_kelas)) {
                    hasil.push({
                        kd_bangsal: bangsal.kd_bangsal,
                        nama_bangsal: bangsal.nama_bangsal,
                        kelas_bangsals: [kelasBangsal]
                    });
                }
            });
        });

        return hasil;
    }

    // Fungsi konfirmasi hapus data pasien pindah
    function konfirmasiHapusPasienPindah(id) {
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

                document.getElementById(`form-hapus-pasienPindah-${id}`).submit();
            }
        });
    }

    // Fungsi untuk cek apakah semua data sudah diisi memakai sweetalert2
    function cekPasienPindah(event) {
        event.preventDefault(); // Mencegah form terkirim langsung

        // Ambil nilai dari form
        const noRm = document.getElementById('tambah_no_rm').value;
        const namaPasien = document.getElementById('tambah_nama_pasien').value;
        const waktuPindah = document.getElementById('tambah_waktu_pindah').value;
        const waktuMasuk = document.getElementById('tambah_waktu_masuk').value;
        const asalBangsal = document.getElementById('tambah_asal_bangsal').value;
        const tujuanBangsal = document.getElementById('tambah_tujuan_bangsal').value;

        // debug
        // console.log(noRm, namaPasien, waktuPindah, waktuMasuk, asalBangsal, tujuanBangsal);

        // ubah format waktu masuk agar lebih mudah dibaca
        let waktuMasukParsed = new Date(waktuMasuk).toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            timeZoneName: 'short'
        });

        // Cek apakah semua data sudah diisi
        if (!noRm || !namaPasien || !waktuPindah || !asalBangsal || !tujuanBangsal) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap!',
                text: 'Semua kolom wajib diisi!',
            });
            return false;
        }

        if (new Date(waktuPindah) <= new Date(waktuMasuk)) {
            Swal.fire({
                icon: 'error',
                title: 'Waktu Pindah Tidak Valid!',
                html: 'Waktu pindah saat ini harus lebih besar dari waktu masuk/pindah sebelumnya!<br><br><b>Waktu masuk/pindah pasien sebelumnya:</b> <br>' +
                    waktuMasukParsed,
            });
            return false;
        }

        // Tampilkan Loading
        loadingStatus();

        // Jika semua valid, submit form secara manual
        event.target.submit();
    }

    // Fungsi untuk cek form edit pasien pindah 
    function cekEditPasienPindah() {
        // Ambil nilai dari form
        const waktuPindah = document.getElementById('edit_waktu_pindah').value;
        const waktuPindahSebelumnya = document.getElementById('edit_waktu_pindah').getAttribute('data-waktu-awal');

        // Cek apakah semua data sudah diisi
        if (!waktuPindah) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap!',
                text: 'Semua kolom wajib diisi!',
            });
            return false;
        }

        // ubah format waktu pindah sebelumnya agar lebih mudah dibaca
        let waktu_pindah_sebelumnya_parsed = new Date(waktuPindahSebelumnya).toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            timeZoneName: 'short'
        });

        if (new Date(waktuPindah) <= new Date(waktuPindahSebelumnya)) {
            Swal.fire({
                icon: 'error',
                title: 'Waktu Pindah Tidak Valid!',
                html: 'Waktu pindah saat ini harus lebih besar dari waktu pindah sebelumnya!<br><br><b>Waktu masuk/pindah pasien sebelumnya:</b> <br>' +
                    waktu_pindah_sebelumnya_parsed,
            });
            return false;
        }

        // Tampilkan Loading
        loadingStatus();

        // Jika semua valid, submit form secara manual
        return true;
    }

    // Fungsi untuk menampilkan konten
    function updateContentDisplay() {
        // Ambil elemen
        const containerTabelPasien = $('.container-tabel-pasien');
        const containertabelPencarian = $('.tabel-cari-pasien');
        const formPasienPindah = $('.container-form-input');

        // Ambil nilai dari select element
        let selectDataView = document.getElementById('select-data-view');
        let selectedValue = selectDataView.value;

        $(".loading").hide();

        // Pastikan DataTable hanya diinisialisasi jika belum ada
        if (selectedValue == '1') {
            containertabelPencarian.css('display', 'block');
            containerTabelPasien.css('display', 'none');
            formPasienPindah.css('display', 'none');
            $('#tabel-pasien-pindah-id').hide(); // Sembunyikan
            $('#tabel-cari-pasienPindah').show();
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        } else if (selectedValue == '2') {
            containerTabelPasien.css('display', 'block');
            containertabelPencarian.css('display', 'none');
            formPasienPindah.css('display', 'none');
            $('#tabel-cari-pasienPindah').hide(); // Sembunyikan
            $('#tabel-pasien-pindah-id').show();
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        } else {
            console.error('Nilai selectedValue tidak ditemukan');
        }
    }

    // Fungsi untuk menjalankan DataTables
    function initializeDataTable() {
        // Daftarkan format custom di moment.js untuk DataTables
        $.fn.dataTable.moment("DD MMMM YYYY (HH:mm)");

        if (!$.fn.DataTable.isDataTable('#tabel-cari-pasienPindah')) {
            new DataTable('#tabel-cari-pasienPindah', {
                columnDefs: [{
                    targets: 3, // Kolom "Waktu" (Index ke-3)
                    type: "datetime-moment",
                    render: function(data, type, row) {
                        return type === 'sort' ? moment(data, "DD MMMM YYYY (HH:mm)").format(
                            "YYYY-MM-DD HH:mm") : data;
                    }
                }],
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
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                scrollCollapse: true,
                scrollY: "290px",
                scrollX: true,
                autoWidth: false,
                order: [
                    [3, "desc"]
                ],
                buttons: [{
                        extend: 'copy',
                        text: '<i class="bi bi-clipboard-fill"></i> Copy',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Pasien Pindah'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Pasien Pindah'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Pasien Pindah'
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer-fill"></i> Print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Pasien Pindah'
                    },
                    {
                        text: '<i class="bi bi-caret-down-square"></i> Detail off',
                        action: function(e, dt, node, config) {
                            var columns = [4, 5,
                            6]; // Kolom Bangsal Sebelumnya, Waktu Masuk, Waktu Pindah
                            var isHidden = dt.column(columns[0]).visible();

                            columns.forEach(function(colIdx) {
                                dt.column(colIdx).visible(!isHidden);
                            });

                            // Ubah teks tombol
                            var newText = isHidden ?
                                '<i class="bi bi-caret-up-square"></i> Detail off' :
                                '<i class="bi bi-caret-down-square"></i> Detail on';
                            $(node).html(newText);
                        }
                    }
                ],
                columnDefs: [{
                        targets: [4, 5, 6],
                        visible: false
                    } // Kolom Bangsal Sebelumnya, Waktu Masuk, Waktu Pindah disembunyikan
                ],
                rowCallback: function(row, data, index) {
                    // Menampilkan nomor urut secara berkelanjutan
                    $('td:eq(0)', row).html(index + 1);
                }
            });
        }

        if (!$.fn.DataTable.isDataTable('#tabel-pasien-pindah-id')) {
            new DataTable('#tabel-pasien-pindah-id', {
                columnDefs: [{
                    targets: [3, 4], // Kolom "Waktu" (Index ke-3)
                    type: "datetime-moment",
                    render: function(data, type, row) {
                        return type === 'sort' ? moment(data, "DD MMMM YYYY (HH:mm)").format(
                            "YYYY-MM-DD HH:mm") : data;
                    }
                }],
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
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ], // -1 berarti "semua data"
                scrollCollapse: true, // Aktifkan fitur scroll
                scrollY: "290px", // Atur tinggi maksimal
                scrollX: true, // Aktifkan scroll horizontal
                autoWidth: false, // Atur lebar tabel secara otomatis

                // Urutkan berdasarkan kolom yang ditentukan secara DESC
                order: [
                    [4, "desc"]
                ],

                buttons: [{
                        extend: 'copy',
                        text: '<i class="bi bi-clipboard-fill"></i> Copy',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Pasien Pindah'
                    },

                    {
                        extend: 'excel',
                        text: '<i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Pasien Pindah'
                    },

                    {
                        extend: 'pdf',
                        text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Pasien Pindah'
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer-fill"></i> Print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Pasien Pindah'
                    },
                    {
                        text: '<i class="bi bi-caret-down-square"></i> Detail off',
                        action: function(e, dt, node, config) {
                            var columns = [3, 5]; // Kolom Bangsal Sebelumnya, Waktu Masuk, Waktu Pindah
                            var isHidden = dt.column(columns[0]).visible();

                            columns.forEach(function(colIdx) {
                                dt.column(colIdx).visible(!isHidden);
                            });

                            // Ubah teks tombol
                            var newText = isHidden ?
                                '<i class="bi bi-caret-up-square"></i> Detail off' :
                                '<i class="bi bi-caret-down-square"></i> Detail on';
                            $(node).html(newText);
                        }
                    }
                ],
                columnDefs: [{
                        targets: [3, 5],
                        visible: false
                    } // Kolom Bangsal Sebelumnya, Waktu Masuk, Waktu Pindah disembunyikan
                ],
                rowCallback: function(row, data, index) {
                    // Menampilkan nomor urut secara berkelanjutan
                    $('td:eq(0)', row).html(index + 1);
                }
            });
        }
    }

    window.onload = function() {
        const container = document.querySelector('.pasien-pindah-container');

        function setHeight() {
            let tinggiNavbar = parseInt(getComputedStyle(document.documentElement).getPropertyValue(
                '--tinggi-navbar'));
            let tinggiHeader = parseInt(getComputedStyle(document.documentElement).getPropertyValue(
                '--tinggi-konten-header'));

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
    .table td,
    .table th {
        white-space: nowrap !important;
        /* paksa agar tidak ada wrap */
    }

    /* Style untuk header table */
    .table-color {
        background-color: #6c5b3b;
        color: rgb(255, 255, 255);
    }

    /* Style untuk tombol edit dan hapus */
    .btn-edit,
    .btn-delete {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }

    /* Style untuk kontainer */
    .pasien-pindah-container {
        transition: opacity 0.4s ease-in-out;
    }
</style>
