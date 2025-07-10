
<div class="dataBangsal-container card border-0 mt-1 p-3" style="opacity: 0;">
    <!-- Select Tampilan Konten -->
    <div class="row">
        <div class="col-12">
            <select class="form-select" id="select-data-view">
                <option value="1" selected>Data Bangsal</option>
                <option value="2">Data Kelas Bangsal</option>
                <option value="3">Card Info</option>
            </select>
        </div>
    </div>

    <!-- Data Bangsal dan Kelas Bangsal -->
    <div class="row">
        <!-- Data Bangsal -->
        <div class="row-dataBangsal col-12" style="display: none;">
            <div class="row row-cols-2">
                <!-- Form data bangsal -->
                <div class="col-3 mt-3">        
                    <div class="form-bangsal card px-3 py-2">
                        <h5 class="card-title">Form Input</h5>
                        <form action="{{ route('store.dataBangsal') }}" 
                        method="POST" onsubmit="return cekFormBangsal()">
                            @csrf
                            <div class="mb-3">
                                <label for="nama_bangsal" class="form-label">Nama Bangsal</label>
                                <input type="text" id="nama_bangsal" name="nama_bangsal" class="form-control">
                            </div>

                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>

                <!-- Tabel data bangsal -->
                <div class="col-9">
                    <table id="tabel-bangsal-id" class="table table-striped table-hover table-sm">
                        <thead class="table-header table-color align-middle">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Bangsal</th>
                                <th class="text-center">Total Tempat Tidur</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bangsal as $data)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_bangsal }}</td>
                                <td class="text-center">{{ $data->total_tempat_tidur }}</td>
                                <td class="text-center">
                                    <button id="editButton-{{$data->kd_bangsal}}" onclick="editBangsal({{ $data->kd_bangsal }})" 
                                    class="btn btn-edit btn-warning">Edit</button>
                                    <form id="form-hapus-bangsal-{{ $data->kd_bangsal }}" action="{{ route('delete.dataBangsal', $data->kd_bangsal) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-delete btn-danger" onclick="konfirmasiHapusBangsal({{ $data->kd_bangsal }})">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Loading -->
                    <div class="loading text-center position-absolute start-50 top-50 translate-middle" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Data Kelas Bangsal -->
        <div class="row-kelasBangsal col-12" style="display: none;">
            <div class="row row-cols-2">
                <!-- Form kelas bangsal -->
                <div class="col-3 mt-3">
                    <div class="form-kelasBangsal card px-3 py-2">
                        <h5 class="card-title">Form Input</h5>
                        <form action="{{ route('store.kelasBangsal') }}" 
                        method="POST" onsubmit="return cekFormKelasBangsal()">
                            @csrf
                            <!-- Nama Kelas -->
                            <div class="mb-2">
                                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas">
                            </div>

                            <!-- Jenis Kelas -->
                            <div class="mb-2">
                                <label for="jenis_kelas" class="form-label">Jenis Kelas</label>
                                <select class="form-select" id="jenis_kelas" name="jenis_kelas">
                                    <option value="">Pilih Jenis Kelas</option>
                                    <option value="VIP">VIP</option>
                                    <option value="Kelas 1">Kelas 1</option>
                                    <option value="Kelas 2">Kelas 2</option>
                                    <option value="Kelas 3">Kelas 3</option>
                                    <option value="-">Tida ada Kelas</option>
                                </select>
                            </div>

                            <!-- Jumlah Tempat Tidur -->
                            <div class="mb-2">
                                <label for="jumlah_tempat_tidur" class="form-label">Jumlah Tempat Tidur</label>
                                <input type="number" class="form-control" id="jumlah_tempat_tidur" name="jumlah_tempat_tidur" min="0">
                            </div>

                            <!-- Pilihan Bangsal -->
                            <div class="mb-2">
                                <label for="fk_kd_bangsal" class="form-label">Bangsal</label>
                                <select class="form-select" id="fk_kd_bangsal" name="fk_kd_bangsal">
                                    <option value="">Pilih Bangsal</option>
                                    @foreach ($bangsal as $data2)
                                    <option value="{{ $data2->kd_bangsal }}">{{ $data2->nama_bangsal }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tombol Submit dan reset-->
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>

                <!-- Tabel data kelas bangsal -->
                <div class="col-9">
                    <table id="tabel-kelasBangsal-id" class="table table-striped table-hover table-sm">
                        <thead class="table-header table-color align-middle">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Kelas</th>
                                <th class="text-center">Jenis Kelas</th>
                                <th class="text-center">Jumlah Tempat Tidur</th>
                                <th class="text-center">Bangsal</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Jika data kelas bangsal kosong -->
                            @if ($kelas_bangsal->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">Data kelas bangsal kosong.</td>
                                </tr>
                            <!-- Jika data kelas bangsal tidak kosong -->
                            @else
                                @foreach ($kelas_bangsal as $kelas)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $kelas->nama_kelas }}</td>
                                    <td>{{ $kelas->jenis_kelas }}</td>
                                    <td class="text-center">{{ $kelas->jumlah_tempat_tidur }}</td>
                                    <td>{{ $kelas->bangsal->nama_bangsal }}</td>
                                    <td class="text-center">
                                        <button id="editButton-{{$kelas->id_kelas}}" onclick="editKelasBangsal({{ $kelas->id_kelas }})" 
                                        class="btn btn-edit btn-warning">Edit</button>
                                        <form id="form-hapus-kelas-{{ $kelas->id_kelas }}" action="{{ route('delete.kelasBangsal', $kelas->id_kelas) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete btn-danger" onclick="konfirmasiHapusKelas({{ $kelas->id_kelas }})">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <!-- Loading -->
                    <div class="loading text-center position-absolute start-50 top-50 translate-middle" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Info -->
        <div class="row-cardInfo col-12" style="display: none;">
            <div class="card border-0 mt-2">
                <!-- Dropdown Filter -->
                <div class="mb-1">
                    <select id="filter-selector" class="form-select">
                        <option value="all">Data Tempat Tidur </option>
                        <option value="terpakai">Tempat Tidur Terpakai</option>
                        <option value="tersedia">Tempat Tidur Tersedia</option>
                        <option value="100">Tampilkan Semua Data Bangsal</option>
                    </select>
                </div>

                <!-- Chart Bangsal -->
                <div id="bangsalChart"></div>

                <div class="loading-grafik text-center position-absolute start-50 top-50 translate-middle" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <!-- Pagination Controls -->
            <div class="container-pagination mt-5 d-flex justify-content-between">
                <button id="pagination-prev" class="btn btn-pagination">Sebelumnya (0)</button>
                <button id="pagination-next" class="btn btn-pagination">Berikutnya (1)</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal Form Edit Bangsal -->
<div class="modal fade" id="editBangsalModal" tabindex="-1" aria-labelledby="editBangsalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBangsalLabel">Edit Bangsal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBangsalForm" method="POST"
                    onsubmit="return cekFormEditBangsal()">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_kd_bangsal" name="kd_bangsal">
                
                    <div class="mb-3">
                        <label for="edit_nama_bangsal" class="form-label">Nama Bangsal</label>
                        <input type="text" class="form-control" id="edit_nama_bangsal"  name="nama_bangsal">
                    </div>

                    <input type="hidden" class="form-control" id="edit_total_tempat_tidur" name="total_tempat_tidur">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close" >Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Edit Kelas Bangsal -->
<div class="modal fade" id="editKelasBangsalModal" tabindex="-1" aria-labelledby="editKelasBangsalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKelasBangsalLabel">Edit Kelas Bangsal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editKelasBangsalForm" 
                method="POST" onsubmit="return cekFormEditKelasBangsal()">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id_kelas" name="id_kelas">
                
                    <!-- Nama Kelas -->
                    <div class="mb-3">
                        <label for="edit_nama_kelas" class="form-label
                            ">Nama Kelas</label>
                        <input type="text" class="form-control" id="edit_nama_kelas" name="nama_kelas" required>
                    </div>

                    <!-- Jenis Kelas -->
                    <div class="mb-3">
                        <label for="edit_jenis_kelas" class="form-label">Jenis Kelas</label>
                        <select class="form-select" id="edit_jenis_kelas" name="jenis_kelas" required>
                            <option value="">Pilih Jenis Kelas</option>
                            <option value="VIP">VIP</option>
                            <option value="Kelas 1">Kelas 1</option>
                            <option value="Kelas 2">Kelas 2</option>
                            <option value="Kelas 3">Kelas 3</option>
                            <option value="-">Tida ada Kelas</option>
                        </select>
                    </div>

                    <!-- Jumlah Tempat Tidur -->
                    <div class="mb-3">
                        <label for="edit_jumlah_tempat_tidur" class="form-label">Jumlah Tempat Tidur</label>
                        <input type="number" class="form-control" id="edit_jumlah_tempat_tidur" name="jumlah_tempat_tidur" min="0" required>
                    </div>

                    <!-- Pilihan Bangsal -->
                    <div class="mb-3">
                        <label for="edit_fk_kd_bangsal" class="form-label">Bangsal</label>
                        <select class="form-select" id="edit_fk_kd_bangsal" name="fk_kd_bangsal" required>
                            <option value="">Pilih Bangsal</option>
                                @foreach ($bangsal as $data3)
                                    <option value="{{ $data3->kd_bangsal }}">{{ $data3->nama_bangsal }}</option>
                                @endforeach
                        </select>
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
    // Panggil Fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Panggil fungsi setContentHeight dan setHeaderKontenHeight
        setContentHeight();
        setHeaderKontenHeight();

        // Ambil select element
        let selectDataView = document.getElementById('select-data-view');

        // Cek apakah ada data tersimpan di localStorage
        if (localStorage.getItem("selectedDataView_Bangsal")) {
            selectDataView.value = localStorage.getItem("selectedDataView_Bangsal");
        }

        // Event listener untuk menyimpan perubahan ke localStorage
        selectDataView.addEventListener("change", function () {
            localStorage.setItem("selectedDataView_Bangsal", this.value);
            updateContentDisplay();

            if (this.value === '3') {
                fetchData(currentPage);
            }
        });

        const filterSelector = document.querySelector("#filter-selector");
        const paginationPrev = document.querySelector("#pagination-prev");
        const paginationNext = document.querySelector("#pagination-next");

        let currentPage = 1;

        // **Fungsi untuk fetch data berdasarkan filter & pagination**
        function fetchData(page) {
            let filterValue = filterSelector.value;

            if (filterValue === "100") {
                $('.loading-grafik').show();
                fetchChartData(1, 100, filterValue);
                currentPage = 1;
                paginationNext.innerText = "Selanjutnya";
                paginationPrev.innerText = "Sebelumnya";
            } else {
                $('.loading-grafik').show();
                fetchChartData(page, 5, filterValue);
                paginationNext.innerText = `Selanjutnya (${page})`;
                paginationPrev.innerText = `Sebelumnya (${page - 1})`;
            }
        }

        // **Fungsi untuk menangani klik tombol sebelumnya**
        function handlePrevPage() {
            if (filterSelector.value !== "100" && currentPage > 1) {
                currentPage--;
                fetchData(currentPage);
            }
        }

        // **Fungsi untuk menangani klik tombol selanjutnya**
        function handleNextPage() {
            if (filterSelector.value !== "100") {
                currentPage++;
                fetchData(currentPage);
            }
        }

        // **Cek apakah halaman di-refresh dan filter tersimpan**
        if (localStorage.getItem("selectedFilter")) {
            filterSelector.value = localStorage.getItem("selectedFilter");
            fetchData(currentPage);
        }

        // **Event listener untuk filter**
        filterSelector.addEventListener("change", (event) => {
            localStorage.setItem("selectedFilter", event.target.value);
            currentPage = 1; // Reset ke halaman pertama setiap kali filter diubah
            fetchData(currentPage);
        });

        // **Event listener untuk pagination**
        paginationPrev.addEventListener("click", handlePrevPage);
        paginationNext.addEventListener("click", handleNextPage);

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

<script>
    // Cek form bangsal 
    function cekFormBangsal() {
        let namaBangsal = document.getElementById('nama_bangsal').value;

        if (namaBangsal === "") {
            Swal.fire({
                title: "Data Tidak Lengkap!",
                text: "Nama Bangsal tidak boleh kosong.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return false;
        }

        // Jika semua data sudah diisi, tampilkan loading
        loadingStatus();

        return true;
    }

    // Cek form edit bangsal
    function cekFormEditBangsal() {
        let namaBangsal = document.getElementById('edit_nama_bangsal').value;

        if (namaBangsal === "") {
            Swal.fire({
                title: "Data Tidak Lengkap!",
                text: "Nama Bangsal tidak boleh kosong.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return false;
        }

        // Jika semua data sudah diisi, tampilkan loading
        loadingStatus();

        return true;
    }

    // Cek form kelas bangsal
    function cekFormKelasBangsal() {
        let namaKelas = document.getElementById('nama_kelas').value;
        let jenisKelas = document.getElementById('jenis_kelas').value;
        let jumlahTempatTidur = document.getElementById('jumlah_tempat_tidur').value;
        let fkKdBangsal = document.getElementById('fk_kd_bangsal').value;

        if (namaKelas === "" || jenisKelas === "" || jumlahTempatTidur === "" || fkKdBangsal === "") {
            Swal.fire({
                title: "Data Tidak Lengkap!",
                text: "Semua data harus diisi.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return false;
        }

        // Jika semua data sudah diisi, tampilkan loading
        loadingStatus();

        return true;
    }

    // Cek form edit kelas bangsal
    function cekFormEditKelasBangsal() {
        let namaKelas = document.getElementById('edit_nama_kelas').value;
        let jenisKelas = document.getElementById('edit_jenis_kelas').value;
        let jumlahTempatTidur = document.getElementById('edit_jumlah_tempat_tidur').value;
        let fkKdBangsal = document.getElementById('edit_fk_kd_bangsal').value;

        if (namaKelas === "" || jenisKelas === "" || jumlahTempatTidur === "" || fkKdBangsal === "") {
            Swal.fire({
                title: "Data Tidak Lengkap!",
                text: "Semua data harus diisi.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return false;
        }

        // Jika semua data sudah diisi, tampilkan loading
        loadingStatus();

        return true;
    }

    // Update tampilan konten saat memilih opsi
    function updateContentDisplay() {
        // Ambil nilai dari row-dataBangsal dan row-kelasBangsal dan row-cardInfo
        const rowDataBangsal = $('.row-dataBangsal');
        const rowKelasBangsal = $('.row-kelasBangsal');
        const rowCardInfo = $('.row-cardInfo');

        // Ambil nilai dari select element
        let selectDataView = document.getElementById('select-data-view');
        let selectedValue = selectDataView.value;

        $('.loading').hide();

        // Tampilkan atau sembunyikan elemen berdasarkan nilai select
        if (selectedValue === '1') {
            rowKelasBangsal.css('display', 'none');
            rowDataBangsal.css('display', 'block');
            rowCardInfo.css('display', 'none');
            $('#tabel-bangsal-id').show();
            $('#tabel-kelasBangsal-id').hide();
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        } else if (selectedValue === '2') {
            rowDataBangsal.css('display', 'none');
            rowKelasBangsal.css('display', 'block');
            rowCardInfo.css('display', 'none');
            $('#tabel-bangsal-id').hide();
            $('#tabel-kelasBangsal-id').show();
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        } else if (selectedValue === '3') {
            rowDataBangsal.css('display', 'none');
            rowKelasBangsal.css('display', 'none');
            rowCardInfo.css('display', 'block');
            $('.loading-grafik').show();
            $('#tabel-bangsal-id').hide();
            $('#tabel-kelasBangsal-id').hide();
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        }
    }

    // Fungsi konfirmasi hapus data bangsal
    function konfirmasiHapusBangsal(id) {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-bangsal-' + id).submit();

                // Tampilkan loading
                loadingStatus();
            }
        });
    }

    // Fungsi edit bangsal
    function editBangsal(kd_bangsal) {
        // nonaktifkan tombol sementara
        let editButton = document.getElementById(`editButton-${kd_bangsal}`);
        if (editButton) editButton.disabled = true; // Disable tombol sementara

        // Set action di form menggunakan route Laravel
        let form = document.getElementById("editBangsalForm");
        form.action = `{{ route('update.dataBangsal', ':id') }}`.replace(':id', kd_bangsal);

        fetch(`/petugas_indikator/data-bangsal/${kd_bangsal}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("edit_kd_bangsal").value = kd_bangsal;
                document.getElementById("edit_nama_bangsal").value = data.nama_bangsal;
                document.getElementById("edit_total_tempat_tidur").value = data.total_tempat_tidur;
                
                // Tampilkan modal
                let modal = new bootstrap.Modal(document.getElementById('editBangsalModal'));
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

    // fungsi konfirmasi hapus kelas bangsal
    function konfirmasiHapusKelas(id_kelas) {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-kelas-' + id_kelas).submit();

                // Tampilkan loading
                loadingStatus();
            }
        });
    }
    
    // Fungsi edit kelas bangsal
    function editKelasBangsal(id_kelas) {
        // nonaktifkan tombol sementara
        let editButton = document.getElementById(`editButton-${id_kelas}`);
        if (editButton) editButton.disabled = true; // Disable tombol sementara
        
        // Set action di form menggunakan route Laravel
        let form = document.getElementById("editKelasBangsalForm");
        form.action = `{{ route('update.kelasBangsal', ':id') }}`.replace(':id', id_kelas);

        fetch(`/petugas_indikator/data-kelas-bangsal/${id_kelas}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("edit_id_kelas").value = id_kelas;
                document.getElementById("edit_nama_kelas").value = data.nama_kelas;
                document.getElementById("edit_jenis_kelas").value = data.jenis_kelas;
                document.getElementById("edit_jumlah_tempat_tidur").value = data.jumlah_tempat_tidur;
                document.getElementById("edit_fk_kd_bangsal").value = data.fk_kd_bangsal;
                
                // Tampilkan modal
                let modal = new bootstrap.Modal(document.getElementById('editKelasBangsalModal'));
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

    // Fungsi untuk inisialisasi DataTables
    function initializeDataTable() {
        if (!$.fn.DataTable.isDataTable('#tabel-bangsal-id')) {
            new DataTable('#tabel-bangsal-id', {
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
                    { extend: 'copy', text: '<i class="bi bi-clipboard-fill"></i> Copy', exportOptions: { columns: ':not(:last-child)' }, title: 'Data Bangsal' },
                    { extend: 'print', text: '<i class="bi bi-printer-fill"></i> Print', exportOptions: { columns: ':not(:last-child)' }, title: 'Data Bangsal' }
                ]
            });
        }
        if (!$.fn.DataTable.isDataTable('#tabel-kelasBangsal-id')) {
            new DataTable('#tabel-kelasBangsal-id', {
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
                    { extend: 'copy', text: '<i class="bi bi-clipboard-fill"></i> Copy', exportOptions: { columns: ':not(:last-child)' }, title: 'Data Kelas Bangsal' },
                    { extend: 'print', text: '<i class="bi bi-printer-fill"></i> Print', exportOptions: { columns: ':not(:last-child)' }, title: 'Data Kelas Bangsal' }
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

    // Fungsi untuk menetapkan tinggi konten
    window.onload = function () {
        const container = document.querySelector('.dataBangsal-container');

        function setHeight() {
            let tinggiNavbar = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--tinggi-navbar'));
            let tinggiHeader = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--tinggi-konten-header'));
            
            let tinggiContainer = tinggiNavbar - tinggiHeader;
            container.style.height = tinggiContainer + 'px';

            container.style.opacity = 1; // Tampilkan elemen setelah selesai dihitung
        }

        setTimeout(setHeight, 100); // Beri sedikit delay agar CSS variabel selesai dihitung
    };

    // Fungsi untuk mengambil data chart
    async function fetchChartData(page = 1, perPage = 5, filter = 'all') {
        try {
            const apiUrl = `${window.location.origin}/petugas_indikator/data-bangsal/bangsal/chart-data?page=${page}&per_page=${perPage}&filter=${filter}`;
            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error("Gagal mengambil data");
            const jsonResponse = await response.json();
            const data = jsonResponse.data;

            if (!data || data.length === 0) {
                document.querySelector("#bangsalChart").innerHTML = "<p>Tidak ada data tersedia.</p>";
                return;
            }

            // Ambil semua jenis kelas yang ada (termasuk jika ada '-')
            const jenisKelasSet = new Set();
            data.forEach(item => {
                item.kelas.forEach(kls => {
                    jenisKelasSet.add(kls.jenis_kelas === '-' ? 'Tanpa Kelas' : kls.jenis_kelas);
                });
            });
            const jenisKelasList = Array.from(jenisKelasSet);

            // Ambil nama bangsal untuk label
            const bangsalLabels = data.map(item => item.bangsal);

            $('.loading-grafik').hide();

            // Pisahkan data berdasarkan status (Terpakai & Tersedia)
            let terpakaiData = [];
            let tersediaData = [];

            jenisKelasList.forEach(jenis => {
                terpakaiData.push({
                    name: `${jenis} (Terpakai)`,
                    data: data.map(item => {
                        const kelas = item.kelas.find(kls => (kls.jenis_kelas === jenis || (kls.jenis_kelas === '-' && jenis === 'Tanpa Kelas')));
                        return kelas ? kelas.terpakai : 0;
                    })
                });

                tersediaData.push({
                    name: `${jenis} (Tersedia)`,
                    data: data.map(item => {
                        const kelas = item.kelas.find(kls => (kls.jenis_kelas === jenis || (kls.jenis_kelas === '-' && jenis === 'Tanpa Kelas')));
                        return kelas ? kelas.tersedia : 0;
                    })
                });
            });

            // Gabungkan agar "Terpakai" muncul dulu, lalu "Tersedia"
            let seriesData = [...terpakaiData, ...tersediaData];

            // Opsi warna custom yang lebih seragam dan selaras dengan tema halaman
            const customColors = {
                "Tanpa Kelas (Terpakai)": "#6B542F", // Coklat tua (selaras dengan navbar)
                "Tanpa Kelas (Tersedia)": "#2E7D32", // Hijau tua (sesuai tema)
                "Kelas 3 (Terpakai)": "#8B5A2B",     // Coklat tanah tua
                "Kelas 3 (Tersedia)": "#228B22",     // Hijau hutan
                "Kelas 2 (Terpakai)": "#A36A3D",     // Coklat keemasan
                "Kelas 2 (Tersedia)": "#1E7D32",     // Hijau lumut gelap
                "Kelas 1 (Terpakai)": "#7B3F00",     // Coklat bata
                "Kelas 1 (Tersedia)": "#2E8B57",     // Hijau laut gelap
                "VIP (Terpakai)": "#5A3E1B",         // Coklat eksklusif
                "VIP (Tersedia)": "#006400"          // Hijau tua pekat
            };


            // Konfigurasi Chart dengan perubahan tampilan
            var options = {
                series: seriesData,
                chart: { type: 'bar', height: "100%", stacked: true, toolbar: { show: true }},
                grid: {
                    padding: {
                        right: 20 // Tambah lebih banyak ruang di kanan
                    },
                    borderColor: '#ddd', // Warna grid lebih soft
                    strokeDashArray: 5 // Grid dibuat putus-putus agar lebih halus
                },
                tooltip: {
                    y: {
                        formatter: function (val, opts) {
                            let seriesIndex = opts.seriesIndex;
                            let totalPerKategori = opts.w.globals.series
                                .map(series => series[opts.dataPointIndex])
                                .reduce((a, b) => a + b, 0);

                            let persen = totalPerKategori ? (val / totalPerKategori * 100).toFixed(2) : 0;
                            return `${val} (${persen}%)`;
                        }
                    }
                },
                plotOptions: { 
                    bar: { 
                        horizontal: true, 
                        barHeight: '70%',
                        dataLabels: {  // <-- dataLabels harus di dalam bar
                            total: {
                                enabled: true,
                                offsetX: 5, // Geser ke kanan agar benar-benar di luar
                                useHTML: true, 
                                align: 'right', // Pastikan label ada di ujung kanan
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 900
                                }
                            }
                        }
                    }
                },
                // Mengubah agar Terpakai di samping kiri
                xaxis: { categories: bangsalLabels},
                legend: { position: 'bottom', horizontalAlign: 'center', fontSize: '12px' },
                fill: { opacity: 1 },
                colors: seriesData.map(series => customColors[series.name] || "#000000") // Warna berdasarkan opsi
            };

            document.querySelector("#bangsalChart").innerHTML = "";
            var chart = new ApexCharts(document.querySelector("#bangsalChart"), options);
            chart.render();
        } catch (error) {
            console.error("Terjadi kesalahan saat mengambil data:", error);
        }
    }
</script>

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

    .dataBangsal-container {
        transition: opacity 0.4s ease-in-out;
    }

    .btn-pagination {
        background-color: #6c5b3b;
        color: white; 
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }

    .btn-pagination:hover {
        color: white;
        background-color:rgb(88, 74, 48);
    }

    #bangsalChart {
        height: 45vh; /* Gunakan vh di CSS, bukan di ApexCharts */
    }

</style>