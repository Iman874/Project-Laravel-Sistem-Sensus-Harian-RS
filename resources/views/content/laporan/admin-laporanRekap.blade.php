@php
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
    // Dekripsi data
    $data_enkripsi = Crypt::decrypt($data);
@endphp

<div class="laporan-rekap-container card border-0 mt-1 p-3">

    <!-- Pilihan Kategori Laporan -->
    <div class="row">
        <div class="col-12 select-laporan mb-3">
            <select class="form-select" id="select-laporan" aria-label="Default select example">
                <option value="0" selected>Semua Bangsal</option>
                <option value="1">Indikator Per-Bangsal</option>
            </select>
        </div>
        
        <div class="col-12 select-periode-laporan">
            <select class="form-select" id="select-periode-laporan" aria-label="Default select example">
                @php 
                    // Urutkan array berdasarkan label paling akhir
                    $data_enkripsi['periode'] = array_reverse($data_enkripsi['periode']);
                @endphp
                @foreach ($data_enkripsi['periode'] as $periode)
                    <option value="{{ $periode['value'] }}">{{ $periode['label'] }}</option>
                @endforeach
            </select>
        </div>

    </div>    

    <!-- Tabel Laporan -->
    <div class="row">

        <div class="col-12 container-tabel-all">
            <!-- Tabel Rekapitulasi ALL Bangsal-->
            <div class="tabel-rekap-all" style="display: none;">
                <table id="tabel-rekap-all-id" class="table table-striped table-hover table-sm">
                    <thead class="table-header table-color align-middle">
                        <tr>
                            <th class="text-center">Indikator Pencapaian</th>
                            <th class="text-center">Standar DEPKES(2005)</th>
                            <th class="text-center">Hasil Keseluruhan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">BOR</td>
                            <td class="text-center">70%</td>
                            <td class="text-center">{{ number_format($data_enkripsi['totalBOR'], 3) }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 container-tabel-bangsal">
            <!-- Tabel Rekapitulasi BOR -->
            <div class="tabel-rekap-bangsal" style="display: none;">
                <table id="tabel-rekap-per-bangsal-id" class="table table-striped table-hover table-sm">
                    <thead class="table-header table-color align-middle">
                        <tr>
                            <th class="text-center">Nama Bangsal</th>
                            <th class="text-center">Total Tempat Tidur</th>
                            <th class="text-center">BOR</th>
                            <th class="text-center">Hasil DLL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Baris per-bangsal -->
                        @foreach ($data_enkripsi['bor'] as $kdBangsal => $bor)
                            <tr>
                                <td class="text-center">{{ $bangsal->firstWhere('kd_bangsal', $kdBangsal)?->nama_bangsal ?? 'Tidak Diketahui' }}</td>
                                <td class="text-center">{{ $bangsal->firstWhere('kd_bangsal', $kdBangsal)?->total_tempat_tidur ?? 'Tidak Diketahui' }}</td>
                                <td class="text-center">{{ number_format($bor, 3) }}%</td>
                                <td class="text-center">Belum ada data</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Panggil fungsi setContentHeight dan setHeaderKontenHeight dari app.js
        setContentHeight();
        setHeaderKontenHeight();

        // Ambil nilai dari id select dan simpan ke dalam variabel
        var selectElement = document.getElementById('select-laporan');

        // Simpan data select element ke dalam memori local
        localStorage.setItem('selectedLaporan', selectElement.value);

        // Jika ada perubahan pada select element
        selectElement.addEventListener('change', function() {
            // Simpan data yang dipilih ke dalam memori local        
            localStorage.setItem('selectedLaporan', selectElement.value);
            updateTableData(); 
        });

        // Ambil nilai dari id select periode dan simpan ke dalam variabel
        var selectPeriodeElement = document.getElementById('select-periode-laporan');

        // Simpan data select element ke dalam memori local
        localStorage.setItem('selectedPeriode', selectPeriodeElement.value);

        // Jika ada perubahan pada select element
        selectPeriodeElement.addEventListener('change', function() {
            // Simpan data yang dipilih ke dalam memori local        
            localStorage.setItem('selectedPeriode', selectPeriodeElement.value);
            // Ambil data rekapitulasi berdasarkan periode yang dipilih
            var selectedPeriode = localStorage.getItem('selectedPeriode');
            var tanggal_awal = selectedPeriode.split('|')[0];
            var tanggal_akhir = selectedPeriode.split('|')[1];
            fetch_dataRekap(tanggal_awal, tanggal_akhir);
            
        });

        initializeDataTable();
        updateTableData();

    });

    function updateTableData(){
        // Ambil nilai dari id select dan simpan ke dalam variabel
        var selectedLaporan = localStorage.getItem('selectedLaporan');
        // Jika nilai adalah 0, maka tampilkan tabel rekap all
        if (selectedLaporan == 0) {
            document.querySelector('.tabel-rekap-all').style.display = 'block';
            document.querySelector('.tabel-rekap-bangsal').style.display = 'none';
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        } else if (selectedLaporan == 1) {
            document.querySelector('.tabel-rekap-all').style.display = 'none';
            document.querySelector('.tabel-rekap-bangsal').style.display = 'block';
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        } else {
            console.log('Tidak ada data yang dipilih');
        }
    }

    // Fungsi untuk menetapkan tinggi konten
    window.onload = function() {
        const container = document.querySelector('.laporan-rekap-container');

        function setHeight() {
            let tinggiNavbar = parseInt(getComputedStyle(document.documentElement).getPropertyValue(
                '--tinggi-navbar'));
            let tinggiHeader = parseInt(getComputedStyle(document.documentElement).getPropertyValue(
                '--tinggi-konten-header'));

            let tinggiContainer = tinggiNavbar - tinggiHeader;
            // console.log(tinggiNavbar, tinggiHeader, tinggiContainer);
            container.style.height = tinggiContainer + 'px';

            container.style.opacity = 1; // Tampilkan elemen setelah selesai dihitung
        }

        setTimeout(setHeight, 100); // Beri sedikit delay agar CSS variabel selesai dihitung
    };

</script>

<script>
    // Fungsi untuk menjalankan DataTables
    function initializeDataTable() {
        const tables = [
            {
                id: '#tabel-rekap-all-id',
                scrollY: "35vh"
            },
            {
                id: '#tabel-rekap-per-bangsal-id',
                scrollY: "35vh"
            }
        ];

        tables.forEach(table => {
            if ($.fn.DataTable.isDataTable(table.id)) {
                $(table.id).DataTable().destroy(); // destroy instance lama
                $(table.id).empty(); // bersihkan isi HTML agar tidak konflik kolom
            }
        });

        function ambilCaptionTabel(id_tabel) {
            if (id_tabel == '#tabel-rekap-all-id') {
                return 'Rekap Semua Data Pasien dan Bangsal';
            } else if (id_tabel == '#tabel-rekap-per-bangsal-id') {
                return 'Rekap Data Pasien Per Bangsal';
            } else {
                return 'Data Pasien';
            }
        }

        tables.forEach(table => {
            new DataTable(table.id, {
                language: {
                    lengthMenu: "Show _MENU_ entries per page",
                    emptyTable: "Tidak ada data tersedia", // Pesan saat tabel kosong
                },
                layout: {
                    bottomStart: ['info', 'buttons'], // Tombol ada di pojok kiri bawah
                },
                paging: false, // Nonaktifkan pagination
                searching: false, // Nonaktifkan pencarian
                ordering: true, // Nonaktifkan pengurutan kolom
                scrollCollapse: true, // Aktifkan fitur scroll
                scrollX: true, // Aktifkan scroll horizontal
                scrollY: table.scrollY, // Atur tinggi scroll
                autoWidth: false, // Atur lebar tabel secara otomatis
                scroller: true, // Aktifkan fitur scroller

                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer-fill"></i> Print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: function() {
                            return ambilCaptionTabel(table.id);
                        }
                    }
                ],
                drawCallback: function(settings) {
                    // Sembunyikan loading spinner
                    // document.querySelector('.loading-table').style.display = 'none';
                }
            });
        });
    }

    function fetch_dataRekap(tanggal_awal, tanggal_akhir) {
        // Tampilkan loading spinner kalau perlu
        // document.querySelector('.loading-table').style.display = 'block';

        fetch(`/petugas_indikator/laporan/rekapitulasi/getData?tanggal_awal=${tanggal_awal}&tanggal_akhir=${tanggal_akhir}`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal mengambil data');
                return response.json();
            })
            .then(data => {
                // Hapus DataTable yang ada sebelumnya
                const tabelRekapAll = $('#tabel-rekap-all-id').DataTable();
                const tabelRekapBangsal = $('#tabel-rekap-per-bangsal-id').DataTable();

                // Ambil nilai totalBOR dan pastikan formatnya dengan 3 angka desimal

               // Kosongkan elemen HTML tabel
                $('#tabel-rekap-all-id_wrapper').empty(); 
                $('#tabel-rekap-per-bangsal-id_wrapper').empty();

                // Buat ulang tabel dengan data baru
                $('#tabel-rekap-all-id_wrapper').append(`
                    <table id="tabel-rekap-all-id" class="table table-striped table-hover table-sm">
                        <thead class="table-header table-color align-middle">
                            <tr>
                                <th class="text-center">Indikator Pencapaian</th>
                                <th class="text-center">Standar DEPKES(2005)</th>
                                <th class="text-center">Hasil Keseluruhan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">BOR</td>
                                <td class="text-center">70%</td>
                                <td class="text-center">${parseFloat(data.totalBOR).toFixed(3)}%</td>
                            </tr>
                        </tbody>
                    </table>
                `);

                // Ambil nilai BOR tiap bangsal dan pastikan formatnya dengan 3 angka desimal
                

                // Lakukan hal yang sama untuk tabel rekap per bangsal jika diperlukan
                if (Array.isArray(data.bor)) {
                    $('#tabel-rekap-per-bangsal-id_wrapper').append(`
                        <table id="tabel-rekap-per-bangsal-id" class="table table-striped table-hover table-sm">
                            <thead class="table-header table-color align-middle">
                                <tr>
                                    <th class="text-center">Nama Bangsal</th>
                                    <th class="text-center">Total Tempat Tidur</th>
                                    <th class="text-center">BOR</th>
                                    <th class="text-center">Hasil DLL</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.bor.map(bor => `
                                    <tr>
                                        <td class="text-center">${bor.nama_bangsal}</td>
                                        <td class="text-center">${bor.total_tempat_tidur}</td>
                                        <td class="text-center">${parseFloat(bor.hasil_bor).toFixed(3)}%</td>
                                        <td class="text-center">${bor.hasil_dll ? bor.hasil_dll + '%' : 'Belum ada data'}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `);
                } else {
                    console.error('Data BOR tidak valid:', data.bor);
                }

                // Inisialisasi DataTable untuk tabel
                initializeDataTable();

                // Sembunyikan loading jika ada
                // document.querySelector('.loading-table').style.display = 'none';
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
                alert('Gagal mengambil data rekapitulasi!');
            });
        }

</script>


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
</style>