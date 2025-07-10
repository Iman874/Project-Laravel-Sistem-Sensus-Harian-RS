@php
    use Carbon\Carbon;

@endphp

<div class="dataPasien-container card border-0 mt-1 p-3" style="opacity: 0;">

    <!-- Container Row -->
    <div class="row">
        <!-- Select Konten -->
        <div class="container-select-konten col-12">
            <div class="row">
                <!-- Jenis Konten -->
                <div class="filter-konten-select col-12 mb-2" style="display: none;">
                    <select class="form-select konten-select">
                        <option value="1" selected>Card Info</option>
                        <option value="2">Tabel Data Pasien</option>
                        <option value="3">Input Data Pasien</option>
                    </select>
                </div>

                <!-- Filter Jenis Pasien -->
                <div class="filter-jenis-pasien" style="display: none;">
                    <select class="form-select data-pasien-select">
                        <option value="1" selected>Pasien Masuk</option>
                        <option value="2">Pasien Pindah</option>
                        <option value="3">Pasien Keluar</option>
                    </select>
                </div>

                <!-- Filter Jenis input Pasien -->
                <div class="filter-input-pasien" style="display: none;">
                    <select class="form-select data-pasien-input">
                        <option value="1" selected>Pasien Masuk</option>
                        <option value="2">Pasien Pindah</option>
                        <option value="3">Pasien Keluar</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- Konten -->
        <!-- Card Info -->
        <div class="card-info col-12" style="display: none;">
            <div class="row">
                <!-- Card Info dan Button -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="card border-0 text-white bg-pasien-masuk p-3">
                                <div class="row">
                                    <!-- Judul -->
                                    <div class="col-12 text-center">
                                        <h5 class="card-title">Pasien masuk hari ini</h5>
                                    </div>

                                    <!-- Ikon dan Angka -->
                                    <div class="col-6 d-flex justify-content-center align-items-center">
                                        <i class="bi bi-person-plus-fill fs-2"></i>
                                    </div>
                                    <div class="col-6 d-flex justify-content-center align-items-center">
                                        <h4>{{ $pasien_masuk_hari_ini }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card border-0 text-white bg-pasien-pindah p-3">
                                <div class="row">
                                    <!-- Judul -->
                                    <div class="col-12 text-center">
                                        <h5 class="card-title">Pasien pindah hari ini</h5>
                                    </div>

                                    <!-- Ikon dan Angka -->
                                    <div class="col-6 d-flex justify-content-center align-items-center">
                                        <i class="bi bi-arrow-left-right fs-2"></i>
                                    </div>
                                    <div class="col-6 d-flex justify-content-center align-items-center">
                                        <h4>{{ $pasien_keluar_hari_ini }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card border-0 text-white bg-pasien-keluar p-3">
                                <div class="row">
                                    <!-- Judul -->
                                    <div class="col-12 text-center">
                                        <h5 class="card-title">Pasien keluar hari ini</h5>
                                    </div>

                                    <!-- Ikon dan Angka -->
                                    <div class="col-6 d-flex justify-content-center align-items-center">
                                        <i class="bi bi-person-dash-fill fs-2"></i>
                                    </div>
                                    <div class="col-6 d-flex justify-content-center align-items-center">
                                        <h4>{{ $pasien_keluar_hari_ini }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Data Pasien All -->
                <div class="tabel-pasien-all">
                    <table id="tabel-pasien-all-id" class="table table-striped table-hover table-sm">
                        <thead class="table-header table-color align-middle">
                            <tr>
                                <th class="text-center">No RM</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Waktu Masuk</th>
                                <th class="text-center">Waktu Pindah</th>
                                <th class="text-center">Waktu Keluar</th>
                                <th class="text-center">Jenis Kelamin</th>
                                <th class="text-center">Bangsal Saat Masuk</th>
                                <th class="text-center">Bangsal Sebelumnya</th>
                                <th class="text-center">Bangsal Saat Ini</th>
                                <th class="text-center">Bangsal Saat Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_pasien_masuk_hari_ini as $pasien)
                                <tr>
                                    <td class="text-center">{{ $pasien->no_rm }}</td>
                                    <td>{{ $pasien->nama_pasien }}</td>
                                    <td class="align-middle">
                                        <span class="badge bg-primary">Pasien Masuk Hari Ini</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pasien->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>{{ $pasien->jenis_kelamin }}</td>
                                    <td>{{ $pasien->bangsal->nama_bangsal }}
                                        ({{ $pasien->kelas_bangsal->nama_kelas }}
                                        [{{ $pasien->kelas_bangsal->jenis_kelas }}])
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endforeach
                            @foreach ($data_pasien_pindah_hari_ini as $pasien)
                                <tr>
                                    <td class="text-center">{{ $pasien->pasien_masuk->no_rm }}</td>
                                    <td>{{ $pasien->pasien_masuk->nama_pasien }}</td>
                                    <td class="align-middle">
                                        <span class="badge bg-warning">Pasien Pindah Hari Ini</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pasien->pasien_masuk->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pasien->waktu_pindah)->translatedFormat('d F Y (H:i)') }}
                                    </td>
                                    <td>-</td>
                                    <td>{{ $pasien->pasien_masuk->jenis_kelamin }}</td>
                                    <td>{{ $pasien->pasien_masuk->bangsal->nama_bangsal }}
                                        ({{ $pasien->pasien_masuk->kelas_bangsal->nama_kelas }}
                                        [{{ $pasien->pasien_masuk->kelas_bangsal->jenis_kelas }}])
                                    </td>
                                    <td>{{ $pasien->bangsal_asal->nama_bangsal }}
                                        ({{ $pasien->kelas_bangsal_asal->nama_kelas }}
                                        [{{ $pasien->kelas_bangsal_asal->jenis_kelas }}])
                                    </td>
                                    <td>{{ $pasien->bangsal_tujuan->nama_bangsal }}
                                        ({{ $pasien->kelas_bangsal_tujuan->nama_kelas }}
                                        [{{ $pasien->kelas_bangsal_tujuan->jenis_kelas }}])
                                    </td>
                                    <td>-</td>
                                </tr>
                            @endforeach
                            @foreach ($data_pasien_keluar_hari_ini as $pasien)
                                <tr>
                                    <td class="text-center">{{ $pasien->pasien_masuk->no_rm }}</td>
                                    <td>{{ $pasien->pasien_masuk->nama_pasien }}</td>
                                    <td class="align-middle">
                                        <span class="badge bg-danger">Pasien Keluar Hari Ini</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pasien->pasien_masuk->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                                    </td>
                                    <td>-</td>
                                    <td>{{ \Carbon\Carbon::parse($pasien->waktu_keluar)->translatedFormat('d F Y (H:i)') }}
                                    </td>
                                    <td>{{ $pasien->pasien_masuk->jenis_kelamin }}</td>
                                    <td>{{ $pasien->pasien_masuk->bangsal->nama_bangsal }}
                                        ({{ $pasien->pasien_masuk->kelas_bangsal->nama_kelas }}
                                        [{{ $pasien->pasien_masuk->kelas_bangsal->jenis_kelas }}])
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                    @if ($pasien->pasien_masuk && $pasien->pasien_masuk->pasien_pindahs->isNotEmpty())
                                        @php
                                            $bangsal_terakhir = $pasien->bangsal_terakhir();
                                        @endphp
                                        <td>{{ $bangsal_terakhir['bangsal']->nama_bangsal ?? '-' }}
                                            ({{ $bangsal_terakhir['kelas']->nama_kelas ?? '-' }})
                                            [{{ $bangsal_terakhir['kelas']->jenis_kelas ?? '-' }}]
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Tabel Pasien -->
        <div class="tabel-data-pasien col-12" style="display: none;">
            <main class="row">
                <!-- Filter Tabel Data Pasien -->
                <div class="mt-2 col-3">
                    <div class="card card-filter">
                        <div class="px-3 pt-3">
                            <!-- Filter Grup by Bulan dan Tahun -->
                            <h6>Pilih Periode</h6>
                            <div class="mb-2">
                                <input type="checkbox" class="btn-filter-bulan form-check-input">
                                <label class="form-check-label">
                                    Bulanan
                                </label>
                            </div>
                            <div class="mb-2">
                                <input type="checkbox" class="btn-filter-tahun form-check-input">
                                <label class="form-check-label">
                                    Tahunan
                                </label>
                            </div>
                        </div>
                        <div class="p-3">
                            <!-- Filter waktu -->
                            <h6>Filter Waktu</h6>
                            <div class="mb-2">
                                <label class="form-label">Dari waktu</label>
                                <input type="date" id="filter-dari" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Sampai waktu</label>
                                <input type="date" id="filter-sampai" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button id="btn-filter" class="btn btn-success">Terapkan</button>
                                    <button id="btn-reset-filter" class="btn btn-danger">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Pasien -->
                <div class="col-9 position-relative">
                    <!-- Tabel Pasien Masuk -->
                    <div class="tabel-pasien-masuk" style="display: none;">
                        <table id="tabel-pasien-masuk-id" class="table table-striped table-hover table-sm">
                            <thead class="table-header table-color align-middle">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">No RM</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Status Pindah</th>
                                    <th class="text-center">Status Keluar</th>
                                    <th class="text-center">Waktu Masuk</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">Bangsal</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasien_masuk as $index => $pasien)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $pasien->no_rm }}</td>
                                        <td>{{ $pasien->nama_pasien }}</td>
                                        @if ($pasien && $pasien->pasien_pindahs->isNotEmpty())
                                            <td>
                                                <span class="badge bg-primary">Sudah Pernah Pindah</span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge bg-secondary">Belum Pernah Pindah</span>
                                            </td>
                                        @endif
                                        @if ($pasien && $pasien->pasien_keluar)
                                            <td>
                                                <span class="badge bg-danger">Pasien Sudah Keluar</span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge bg-success">Pasien Belum Keluar</span>
                                            </td>
                                        @endif
                                        <td>
                                            {{ \Carbon\Carbon::parse($pasien->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                                        </td>
                                        <td>{{ $pasien->jenis_kelamin }}</td>
                                        <td>
                                            {{ $pasien->bangsal->nama_bangsal }}
                                            ({{ $pasien->kelas_bangsal->nama_kelas }}
                                            [{{ $pasien->kelas_bangsal->jenis_kelas }}])
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-edit btn-warning"
                                                id="editButton-{{ $pasien->id_pasien_masuk }}"
                                                onclick="editPasienMasuk(
                                            {{ $pasien->id_pasien_masuk }},
                                            {{ json_encode($bangsal) }}, 
                                            {{ json_encode($kelas_bangsal) }}
                                        )">Edit</button>
                                            <button type="button" class="btn btn-delete btn-danger"
                                                onclick="hapusDataPasienMasuk({{ $pasien->id_pasien_masuk }})">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Pasien Pindah -->
                    <div class="tabel-pasien-pindah" style="display: none;">
                        <table id="tabel-pasien-pindah-id" class="table table-striped table-hover table-sm">
                            <thead class="table-header table-color align-middle">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">No RM</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Waktu Pindah</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">Bangsal Sebelumnya</th>
                                    <th class="text-center">Bangsal Saat Ini</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasien_pindah as $index => $pasien)
                                    <tr>
                                        <td class="align-middle text-center">{{ $index + 1 }}</td>
                                        <td class="align-middle text-center">{{ $pasien->pasien_masuk->no_rm }}</td>
                                        <td>{{ $pasien->pasien_masuk->nama_pasien }}</td>
                                        @if ($pasien->pasien_masuk && $pasien->pasien_masuk->pasien_keluar)
                                            <td>
                                                <span class="badge bg-danger">Pasien Sudah Keluar</span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge bg-success">Pasien Belum Keluar</span>
                                            </td>
                                        @endif
                                        <td>
                                            {{ \Carbon\Carbon::parse($pasien->waktu_pindah)->translatedFormat('d F Y (H:i)') }}
                                        </td>
                                        <td>{{ $pasien->pasien_masuk->jenis_kelamin }}</td>
                                        <td>{{ $pasien->bangsal_asal->nama_bangsal }}
                                            ({{ $pasien->kelas_bangsal_asal->nama_kelas }}
                                            [{{ $pasien->kelas_bangsal_asal->jenis_kelas }}])
                                        </td>
                                        <td>{{ $pasien->bangsal_tujuan->nama_bangsal }}
                                            ({{ $pasien->kelas_bangsal_tujuan->nama_kelas }}
                                            [{{ $pasien->kelas_bangsal_tujuan->jenis_kelas }}])</td>

                                        @php
                                            // Ambil data pasien pindah terbaru
                                            $pasien_pindah_terbaru = $pasien->pasien_masuk->pasien_pindahs->last();
                                        @endphp
                                        @if ($pasien->pasien_masuk && $pasien->pasien_masuk->pasien_keluar)
                                            <td>
                                                <span class="badge bg-dark">Tidak Bisa Edit</span>
                                                <span></span>
                                            </td>
                                        @elseif($pasien_pindah_terbaru->id_pindah == $pasien->id_pindah)
                                            <td>
                                                <button id="editButton_Pindah-{{ $pasien->id_pindah }}"
                                                    onclick="editPasienPindah(
                                                {{ json_encode($pasien) }}, 
                                                {{ $bangsal }})"
                                                    class="btn btn-edit btn-warning">Edit</button>
                                                <button class="btn btn-delete btn-danger"
                                                    onclick="hapusDataPasienPindah({{ $pasien->id_pindah }})">Delete</button>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge bg-secondary">Data History</span>
                                                <span></span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Pasien Keluar -->
                    <div class="tabel-pasien-keluar" style="display: none;">
                        <table id="tabel-pasien-keluar-id" class="table table-striped table-hover table-sm">
                            <thead class="table-header table-color align-middle">
                                <tr>
                                    <th class="center">No</th>
                                    <th class="text-center">No RM</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Waktu Masuk</th>
                                    <th class="text-center">Waktu Keluar</th>
                                    <th class="text-center">Cara Keluar</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">Bangsal Saat Masuk</th>
                                    <th class="text-center">Bangsal Saat Keluar</th>
                                    <th class="text-center">Total Waktu Menetap</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasien_keluar as $index => $pasien)
                                    <tr>
                                        <td class="align-middle text-center">{{ $index + 1 }}</td>
                                        <td class="align-middle text-center">{{ $pasien->pasien_masuk->no_rm }}</td>
                                        <td>{{ $pasien->pasien_masuk->nama_pasien }}</td>
                                        @if ($pasien->pasien_masuk && $pasien->pasien_masuk->pasien_pindahs->isNotEmpty())
                                            <td>
                                                <span class="badge bg-primary">Sudah Pernah Pindah</span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge bg-success">Belum Pernah Pindah</span>
                                            </td>
                                        @endif
                                        <td>
                                            {{ \Carbon\Carbon::parse($pasien->pasien_masuk->waktu_masuk)->translatedFormat('d F Y (H:i)') }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($pasien->waktu_keluar)->translatedFormat('d F Y (H:i)') }}
                                        </td>
                                        <td>{{ $pasien->cara_keluar }}</td>
                                        <td>{{ $pasien->pasien_masuk->jenis_kelamin }}</td>
                                        <td>{{ $pasien->pasien_masuk->bangsal->nama_bangsal }}
                                            ({{ $pasien->pasien_masuk->kelas_bangsal->nama_kelas }}
                                            [{{ $pasien->pasien_masuk->kelas_bangsal->jenis_kelas }}])
                                        </td>
                                        @if ($pasien->pasien_masuk && $pasien->pasien_masuk->pasien_pindahs->isNotEmpty())
                                            @php
                                                $bangsal_terakhir = $pasien->bangsal_terakhir();
                                            @endphp
                                            <td>
                                                {{ $bangsal_terakhir['bangsal']->nama_bangsal ?? '-' }}
                                                ({{ $bangsal_terakhir['kelas']->nama_kelas ?? '-' }})
                                                [{{ $bangsal_terakhir['kelas']->jenis_kelas ?? '-' }}]
                                            </td>
                                        @else
                                            <td>{{ $pasien->pasien_masuk->bangsal->nama_bangsal }}
                                                ({{ $pasien->pasien_masuk->kelas_bangsal->nama_kelas }}
                                                [{{ $pasien->pasien_masuk->kelas_bangsal->jenis_kelas }}])
                                            </td>
                                        @endif
                                        @php
                                            $waktu_menetap = Carbon::parse($pasien->pasien_masuk->waktu_masuk)->diff(
                                                Carbon::parse($pasien->waktu_keluar),
                                            );
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
                                        <td>
                                            <button id="editButton_Keluar-{{ $pasien->fk_id_pasien_masuk }}"
                                                onclick="editPasienKeluar(
                                                {{ $pasien->fk_id_pasien_masuk }},
                                                '{{ $pasien->pasien_masuk->waktu_masuk }}')"
                                                class="btn btn-edit btn-warning">Edit</button>
                                            <button class="btn btn-delete btn-danger"
                                                onclick="hapusDataPasienKeluar({{ $pasien->fk_id_pasien_masuk }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Loading Spinner -->
                    <div class="loading-table text-center position-absolute start-50 top-50 translate-middle"
                        style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Form Input Pasien -->
        <div class="container-form-input-pasien col-12" style="display: none;">

            <div class="row">
                <div class="col-12">

                    <!-- Tabel Cari Input Pasien Masuk -->
                    <div class="form-input-pasien-masuk mt-3" style="display: none;">
                        <form class="form-pasienMasuk" action="{{ route('store.petugas_indikator-pasienMasuk') }}"
                            method="POST" onsubmit="return cekPasienMasuk()">
                            @csrf
                            <!-- Form -->
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                        <input type="text" id="input_nama_pasien" name="nama_pasien"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select id="input_jenis_kelamin" name="jenis_kelamin" class="form-select">
                                            <option value="" selected>Pilih jenis kelamin...</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="no_rm" class="form-label">No Rekam Medis</label>
                                        <input type="text" id="input_no_rm" name="no_rm" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
                                        <input type="datetime-local" id="input_waktu_masuk" name="waktu_masuk"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="bangsal" class="form-label">Bangsal</label>
                                    <select id="pilih_fk_kd_bangsal" class="form-select">
                                        @foreach ($bangsal as $bangsal_pilih)
                                            @foreach ($bangsal_pilih->kelas_bangsals as $kelas)
                                                <option
                                                    value="{{ $bangsal_pilih->kd_bangsal }}|{{ $kelas->id_kelas }}">
                                                    {{ $bangsal_pilih->nama_bangsal }}
                                                    ({{ $kelas->nama_kelas }} [{{ $kelas->jenis_kelas }}])
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                <label for="input_fk_kd_bangsal" class="form-label"></label>
                                <input type="hidden" id="input_fk_kd_bangsal" name="fk_kd_bangsal">

                                <label for="input_fk_id_kelas" class="form-label"></label>
                                <input type="hidden" id="input_fk_id_kelas" name="fk_id_kelas">

                            </div>
                            <!-- Tombol Submit dan Reset -->
                            <div class="mt-3">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Cari Input Pasien Pindah -->
                    <div class="tabel-cari-pasien-pindah" style="display: none;">
                        <table id="tabel-cari-pasien-pindah-id" class="table table-striped table-hover table-sm">
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
                            <tbody>
                                @php
                                    $pasien_masuk_filter_pindah = $pasien_masuk->filter(function ($item) {
                                        return $item->pasien_pindahs->isEmpty() && !$item->pasien_keluar;
                                    });

                                    $pasien_pindah_filter_pindah = $pasien_pindah->filter(function ($item) {
                                        return !$item->pasien_masuk->pasien_keluar;
                                    });
                                @endphp
                                @foreach ($pasien_masuk_filter_pindah as $index => $pasien)
                                    <tr>
                                        <td class="align-middle text-center"></td>
                                        <td class="align-middle text-center">{{ $pasien->no_rm }}</td>
                                        <td>{{ $pasien->nama_pasien }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pasien->waktu_masuk)->translatedFormat('d F Y (H:i)') }}</td>
                                        <td>{{ $pasien->jenis_kelamin }}</td>
                                        <td>{{ $pasien->bangsal->nama_bangsal }}
                                            ({{ $pasien->kelas_bangsal->nama_kelas }}
                                            [{{ $pasien->kelas_bangsal->jenis_kelas }}])</td>
                                        <td>{{ $pasien->bangsal->nama_bangsal }}
                                            ({{ $pasien->kelas_bangsal->nama_kelas }}
                                            [{{ $pasien->kelas_bangsal->jenis_kelas }}])</td>

                                        <!-- Status Pindah -->
                                        <td><span class="badge bg-success">Belum Pernah Pindah</span></td>

                                        <!-- Tombol -->
                                        <td class="align-middle text-center">
                                            <button
                                                onclick="tambahPasienPindah(
                                                    {{ json_encode($pasien) }}, 
                                                    {{ json_encode($pasien->bangsal) }}, 
                                                    {{ json_encode($pasien->kelas_bangsal) }},
                                                    {{ json_encode($bangsal) }},
                                                    '{{ $pasien->waktu_masuk }}'"
                                                type="button" class="btn btn-edit btn-primary">Tambah Pasien Pindah</button>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($pasien_pindah_filter_pindah as $index => $pasien)
                                    <tr>
                                        <td class="align-middle text-center"></td>
                                        <td class="align-middle text-center">{{ $pasien->pasien_masuk->no_rm }}</td>
                                        <td>{{ $pasien->pasien_masuk->nama_pasien }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pasien->waktu_pindah)->translatedFormat('d F Y (H:i)') }}</td>
                                        <td>{{ $pasien->pasien_masuk->jenis_kelamin }}</td>
                                        <td>{{ $pasien->bangsal_asal->nama_bangsal }}
                                            ({{ $pasien->kelas_bangsal_asal->nama_kelas }}
                                            [{{ $pasien->kelas_bangsal_asal->jenis_kelas }}])</td>
                                        <td>{{ $pasien->bangsal_tujuan->nama_bangsal }}
                                            ({{ $pasien->kelas_bangsal_tujuan->nama_kelas }}
                                            [{{ $pasien->kelas_bangsal_tujuan->jenis_kelas }}])</td>

                                        <!-- Status Pindah -->
                                        <td><span class="badge bg-danger">Sudah Pernah Pindah</span></td>

                                        <!-- Hanya tampilkan tombol jika pasien adalah pasien terbaru -->
                                        @php
                                            // Ambil data pasien pindah terbaru
                                            $pasien_pindah_terbaru = $pasien->pasien_masuk->pasien_pindahs->last();
                                        @endphp

                                        @if($pasien_pindah_terbaru->id_pindah == $pasien->id_pindah)
                                            <td class="align-middle text-center">
                                                <button
                                                    onclick="tambahPasienPindah(
                                                    {{ json_encode($pasien->pasien_masuk) }}, 
                                                    {{ json_encode($pasien->bangsal_tujuan) }}, 
                                                    {{ json_encode($pasien->kelas_bangsal_tujuan) }},
                                                    {{ json_encode($bangsal) }},
                                                    '{{ $pasien->waktu_pindah }}')"
                                                    type="button" class="btn btn-edit btn-primary">Tambah Pasien Pindah</button>
                                            </td>
                                        @else
                                            <td class="align-middle text-center">
                                                <span class="badge bg-secondary">data History</span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Cari Input Pasien Keluar -->
                    <div class="tabel-cari-pasien-keluar" style="display: none;">
                        <table id="tabel-cari-pasien-keluar-id" class="table table-striped table-hover table-sm">
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
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $pasien_masuk_filter = $pasien_masuk->filter(function ($item) {
                                        return $item->pasien_pindahs->isEmpty() && !$item->pasien_keluar;

                                    });
                                    $pasien_pindah_filter = $pasien_pindah->filter(function ($item) {
                                        $terakhir = $item->pasien_masuk->pasien_pindahs->last();
                                        return !$item->pasien_masuk->pasien_keluar && $item->id_pindah === $terakhir->id_pindah;
                                    });
                                @endphp
                                @foreach ($pasien_masuk_filter as $index => $pasien)
                                    <tr>
                                        <td class="align-middle text-center"></td>
                                        <td class="align-middle text-center">{{ $pasien->no_rm }}</td>
                                        <td>{{ $pasien->nama_pasien }}</td>
                                        <td>{{ $pasien->jenis_kelamin }}</td>
                                        <td>{{ $pasien->bangsal->nama_bangsal }}
                                            ({{ $pasien->kelas_bangsal->nama_kelas }}
                                            [{{ $pasien->kelas_bangsal->jenis_kelas }}])</td>
                                        <td>{{ \Carbon\Carbon::parse($pasien->waktu_masuk)->translatedFormat('d F Y (H:i)') }}</td>

                                        <!-- waktu pindah, default tidak ada karena ini adalah data pasien masuk --> 
                                        <td>-</td>
                                    
                                        <!-- Status Pindah -->
                                        <td><span class="badge bg-success">Belum Pernah Pindah</span></td>

                                        <!-- Tombol -->
                                        <td class="align-middle text-center">
                                            <button onclick="tambahPasienKeluar(
                                                {{ json_encode($pasien) }},
                                                '{{ $pasien->waktu_masuk }}')" 
                                            type="button" class="btn btn-edit btn-primary">Tambah Pasien Keluar</button></td>
                                    </tr>
                                @endforeach
                                @foreach ($pasien_pindah_filter as $index => $pasien)
                                    <tr>
                                        <td class="align-middle text-center"></td>
                                        <td class="align-middle text-center">{{ $pasien->pasien_masuk->no_rm }}</td>
                                        <td>{{ $pasien->pasien_masuk->nama_pasien }}</td>
                                        <td>{{ $pasien->pasien_masuk->jenis_kelamin }}</td>
                                        @php
                                            $pasien_terbaru = $pasien->pasien_masuk->pasien_pindahs->last();
                                        @endphp
                                        <td>
                                            {{ $pasien->bangsal_tujuan->nama_bangsal }}
                                            ({{ $pasien->kelas_bangsal_tujuan->nama_kelas }}
                                            [{{ $pasien->kelas_bangsal_tujuan->jenis_kelas }}])</td>
                                        <td>{{ \Carbon\Carbon::parse($pasien->pasien_masuk->waktu_masuk)->translatedFormat('d F Y (H:i)') }}</td>

                                        <!-- waktu pindah -->
                                        <td>{{ \Carbon\Carbon::parse($pasien->waktu_pindah)->translatedFormat('d F Y (H:i)') }}</td>

                                        <!-- Status Pindah -->
                                        <td><span class="badge bg-danger">Sudah Pernah Pindah</span></td>

                                        <!-- Hanya tampilkan tombol jika pasien adalah pasien pindah terbaru -->
                                        @if($pasien_terbaru->id_pindah == $pasien->id_pindah)
                                            <td class="align-middle text-center">
                                                <button onclick="tambahPasienKeluar(
                                                    {{ json_encode($pasien->pasien_masuk) }},
                                                    '{{ $pasien->waktu_pindah }}')" 
                                                type="button" class="btn btn-edit btn-primary">Tambah Pasien Keluar</button>
                                            </td>
                                        @else
                                            <td class="align-middle text-center">
                                                <span class="badge bg-secondary">data History</span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Form Input Pasien Pindah -->
                    <div class="form-pasien-pindah mt-2" style="display: none;">
                        <!-- Tambahkan logo panah untuk kembali dan jadikan panah itu button -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" onclick="updateInputPasienDisplay()">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </button>
                        </div>
                        <form action="{{ route('store.petugas_indikator-pasienPindah') }}" method="POST"
                            onsubmit="return cekPasienPindah(event)">
                            @csrf
                            <div class="body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tambah_no_rm" class="form-label">No RM</label>
                                            <input type="text" class="form-control" id="tambah_no_rm"name="no_rm" readonly>
                                            <input type="hidden" id="tambah_id_pasien_masuk" name="fk_id_pasien_masuk">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tambah_nama_pasien" class="form-label">Nama Pasien</label>
                                            <input type="text" class="form-control" id="tambah_nama_pasien" name="nama_pasien" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tambah_waktu_pindah" class="form-label">Waktu Pindah</label>
                                            <input type="datetime-local" class="form-control" id="tambah_waktu_pindah" name="waktu_pindah">
                                            <input type="hidden" id="tambah_waktu_masuk" name="waktu_masuk">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tambah_asal_bangsal" class="form-label">Asal Bangsal</label>
                                            <input type="text" class="form-control" id="tambah_asal_bangsal" name="nama_bangsal" readonly>
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
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                    aria-label="Close" onclick="updateInputPasienDisplay()">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>

                    <!-- Form Tambah Pasien Keluar -->
                    <div class="form-pasien-keluar col-12 mt-2" style="display: none;">
                        <!-- Tambahkan logo panah untuk kembali dan jadikan panah itu button -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" onclick="updateInputPasienDisplay()">
                            <i class="bi bi-arrow-left"></i> Kembali
                            </button>
                        </div>
                        <form action="{{ route('store.petugas_indikator-pasienKeluar') }}" 
                        method="POST" onsubmit="return cekPasienKeluar(event)">
                            @csrf
                            <div class="row center">
                                <!-- Kolom Pertama -->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="no_rm" class="form-label">No RM</label>
                                        <input type="text" class="form-control" id="tambah_no_rm_keluar" name="no_rm" readonly>
                                        <input type="hidden" class="form-control" id="tambah_id_pasien_masuk_keluar" name="fk_id_pasien_masuk">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                        <input type="text" class="form-control" id="tambah_nama_pasien_keluar" name="nama_pasien" readonly>
                                    </div>
                                </div>

                                <!-- Kolom Kedua -->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
                                        <input type="datetime-local" class="form-control" id="tambah_waktu_keluar" name="waktu_keluar">
                                        <input type="hidden" class="form-control" id="waktu_masuk_or_pindah_input">
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
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" 
                                        aria-label="Close" onclick="updateInputPasienDisplay()">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <!-- Loading Spinner -->
                <div class="loading-table-input text-center position-absolute start-50 translate-middle"
                    style="display: none; top: 60%;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <!-- Modal Form Edit Pasien Masuk-->
    <div class="modal fade" id="editPasienModal" tabindex="-1" aria-labelledby="editPasienLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasienLabel">Edit Pasien Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPasienForm" method="POST" onsubmit="return cekEditPasienMasuk()">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id_pasien_masuk" name="id_pasien_masuk">

                        <div class="row row-cols-2">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_nama_pasien" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="edit_nama_pasien"
                                        name="nama_pasien" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="edit_jenis_kelamin" name="jenis_kelamin"
                                        required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="edit_no_rm" class="form-label">No Rekam Medis</label>
                                    <input type="text" class="form-control" id="edit_no_rm" name="no_rm"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_waktu_masuk" class="form-label">Waktu Masuk</label>
                                    <input type="datetime-local" class="form-control" id="edit_waktu_masuk"
                                        name="waktu_masuk" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="edit_fk_kd_bangsal" class="form-label">Bangsal</label>
                                    <select class="form-select" id="edit_fk_kd_bangsal" name="fk_kd_bangsal"
                                        required>
                                        <option></option>
                                    </select>

                                    <input type="hidden" class="form-select" id="edit_fk_id_kelas"
                                        name="fk_id_kelas">
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

    <!-- Modal Form Edit Pasien Pindah -->
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
                                    <input type="text" class="form-control" id="edit_no_rm_pindah" name="no_rm"
                                        readonly>
                                    <input type="hidden" class="form-control" id="edit_fk_id_pasien_masuk"
                                        name="fk_id_pasien_masuk">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="edit_nama_pasien_pindah"
                                        name="nama_pasien" readonly>
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
                                    <input type="hidden" id="edit_id_kelas_bangsal_tujuan"
                                        name="fk_id_kelas_tujuan">
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

    <!-- Modal Form Edit Pasien Keluar -->
    <div class="modal fade" id="modalPasienKeluar" tabindex="-1" aria-labelledby="modalPasienKeluarLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPasienKeluarLabel">Edit Pasien Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Pasien Keluar -->
                    <form id="editPasienKeluarForm" method="POST" onsubmit="return cekEditPasienKeluar()">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_rm" class="form-label">No RM</label>
                                    <input type="text" class="form-control" id="edit_no_rm_keluar" name="no_rm"
                                        readonly>
                                    <input type="hidden" class="form-control" id="fk_id_pasien_masuk_modalKeluar"
                                        name="fk_id_pasien_masuk">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="edit_nama_pasien_keluar"
                                        name="nama_pasien" readonly>
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
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                aria-label="Close">Batal</button>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Variabel yang diperlukan
            let bulanCheckbox = document.querySelector(".btn-filter-bulan");
            let tahunCheckbox = document.querySelector(".btn-filter-tahun");

            // Panggil fungsi setContentHeight dan setHeaderKontenHeight dari app.js
            setContentHeight();
            setHeaderKontenHeight();

            // Tetapkan nilai kelas id bangsal tujuan pada form pasien pindah ke elemen hidden 
            document.getElementById('tambah_tujuan_bangsal').addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                document.getElementById('tambah_id_kelas_bangsal_tujuan').value = selectedOption.getAttribute('data-kelas');
            });

            const selectBangsal = document.getElementById('pilih_fk_kd_bangsal');
            const inputBangsal = document.getElementById('input_fk_kd_bangsal');
            const inputKelas = document.getElementById('input_fk_id_kelas');

            // Set nilai input bangsal dan kelas apabila ada perubahan
            selectBangsal.addEventListener('change', function() {
                const selectedValue = this.value;
                const [kd_bangsal, id_kelas] = selectedValue.split('|');

                inputBangsal.value = kd_bangsal;
                inputKelas.value = id_kelas;
            });

            if (selectBangsal.value) {
                const selectedValue = selectBangsal.value;
                const [kd_bangsal, id_kelas] = selectedValue.split('|');

                inputBangsal.value = kd_bangsal;
                inputKelas.value = id_kelas;
            }

            // Fungsi untuk menyimpan selected value ke localStorage
            let selectInput = document.querySelector(".data-pasien-input");

            // Cek apakah ada data tersimpan di localStorage
            if (localStorage.getItem("selectedValue_DataPasienInput")) {
                selectInput.value = localStorage.getItem("selectedValue_DataPasienInput");
            }

            // Event listener untuk menyimpan perubahan ke localStorage
            selectInput.addEventListener("change", function() {
                localStorage.setItem("selectedValue_DataPasienInput", this.value);
                document.querySelector('.loading-table-input').style.display =
                    'block'; // Tampilkan loading spinner tabel
                setTimeout(() => {
                    updateInputPasienDisplay();
                }, 200); // Delay kecil agar loading spinner terlihat
            });

            // Fungsi untuk menyimpan selected value ke localStorage
            let selectElement = document.querySelector(".data-pasien-select");

            // Cek apakah ada data tersimpan di localStorage
            if (localStorage.getItem("selectedValue_DataPasien")) {
                selectElement.value = localStorage.getItem("selectedValue_DataPasien");
            }

            // Event listener untuk menyimpan perubahan ke localStorage
            selectElement.addEventListener("change", function() {
                localStorage.setItem("selectedValue_DataPasien", this.value);
                bulanCheckbox.checked = false; // Reset checkbox bulan
                tahunCheckbox.checked = false; // Reset checkbox tahun

                let tables = [
                    '#tabel-pasien-masuk-id',
                    '#tabel-pasien-pindah-id',
                    '#tabel-pasien-keluar-id'
                ];

                document.querySelector('.loading-table').style.display =
                    'block'; // Tampilkan loading spinner tabel

                let activeTables = tables.filter(id => {
                    let tableElement = document.querySelector(id);
                    return tableElement && window.getComputedStyle(tableElement).display !== 'none';
                });

                Promise.all(activeTables.map(id => {
                    return new Promise(resolve => {
                        let table = window.tableInstances[id];
                        if (!table) return resolve();

                        setTimeout(() => {
                            resetGrouping(id);
                            resolve();
                        }, 200); // Delay kecil agar reset berjalan dulu
                    });
                })).then(() => {
                    setTimeout(() => {
                        updateTableDisplay();
                    }, 200);
                });

            });

            // Fungsi untuk menyimpan selected value ke localStorage
            let selectKonten = document.querySelector(".konten-select");

            // Cek apakah ada data tersimpan di localStorage
            if (localStorage.getItem("selectedKonten")) {
                selectKonten.value = localStorage.getItem("selectedKonten");
            }

            // Event listener untuk menyimpan perubahan ke localStorage
            selectKonten.addEventListener("change", function() {
                localStorage.setItem("selectedKonten", this.value);
                updateContentDisplay();
            });

            // Custom filter untuk tanggal
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                let dariTanggal = $('#filter-dari').val();
                let sampaiTanggal = $('#filter-sampai').val();

                // Ambil element select tabel yang sedang aktif
                let selectElement = document.querySelector('.data-pasien-select');
                let selectedValue = selectElement.value;

                if (selectedValue == '1') {
                    tanggalData = data[3]; // Kolom ke-3 (index 3)
                } else if (selectedValue == '2') {
                    tanggalData = data[3]; // Kolom ke-3 (index 3)
                } else if (selectedValue == '3') {
                    tanggalData = data[4]; // Kolom ke-4 (index 4)
                } else {
                    console.error('Nilai selectedValue tidak ditemukan');
                }

                if (!dariTanggal && !sampaiTanggal) {
                    return true; // Tidak ada filter, tampilkan semua data
                }

                // Konversi format tanggal
                let parsedTanggal = moment(tanggalData, "DD MMMM YYYY (HH:mm)").format("YYYY-MM-DD");

                // Cek batasan tanggal
                let mulai = dariTanggal ? moment(dariTanggal, "YYYY-MM-DD") : null;
                let akhir = sampaiTanggal ? moment(sampaiTanggal, "YYYY-MM-DD") : null;
                let cekTanggal = moment(parsedTanggal, "YYYY-MM-DD");

                if ((mulai === null || cekTanggal.isSameOrAfter(mulai)) &&
                    (akhir === null || cekTanggal.isSameOrBefore(akhir))) {
                    return true;
                }

                return false;
            });

            window.tableInstances = {}; // Objek untuk menyimpan semua instance DataTables non Input

            window.tableInstances_input = {}; // Objek untuk menyimpan semua instance DataTables Input

            let isProcessing = false; // Variabel untuk mencegah event tumpang tindih

            // Event listener untuk tombol filter
            document.getElementById('btn-filter').addEventListener('click', () => {
                if (bulanCheckbox.checked || tahunCheckbox.checked) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan nonaktifkan filter periode sebelum menerapkan filter tanggal.',
                        confirmButtonText: 'Mengerti'
                    });
                    return; // Hentikan proses jika filter salah
                }

                let dariTanggal = document.getElementById('filter-dari').value;
                let sampaiTanggal = document.getElementById('filter-sampai').value;

                if (dariTanggal === '' && sampaiTanggal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Filter tanggal kosong',
                        confirmButtonText: 'Mengerti'
                    });
                    return; // Hentikan proses jika filter salah
                }

                // Cek apakah "dari" lebih besar dari "sampai"
                if (dariTanggal && sampaiTanggal && dariTanggal > sampaiTanggal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Filter Error',
                        text: 'Tanggal "Dari" tidak boleh lebih besar dari "Sampai"!',
                        confirmButtonText: 'OK'
                    });
                    return; // Hentikan proses jika filter salah
                }

                let tables = [
                    '#tabel-pasien-masuk-id',
                    '#tabel-pasien-pindah-id',
                    '#tabel-pasien-keluar-id'
                ];

                $('.loading-table').show(); // Tampilkan loading spinner sebelum memulai

                Promise.all(tables.map(id => {
                    return new Promise(resolve => {
                        let table = window.tableInstances[
                            id]; // Ambil instance DataTable yang benar
                        if (!table) return resolve(); // Lewati jika tidak ada instance

                        setTimeout(() => {
                            // Hapus semua elemen group-header dengan cara manual
                            table.draw(); // Perbarui tampilan tabel
                            document.querySelectorAll(`tbody .group-header`)
                                .forEach(header => {
                                    header.parentNode.removeChild(header);
                                });
                            resolve();
                        }, 300);
                    });
                })).then(() => {
                    $('.loading-table').hide(); // Sembunyikan loading spinner setelah selesai
                });
            });

            // Event listener untuk reset tombol filter
            document.getElementById('btn-reset-filter').addEventListener('click', () => {
                let dariTanggal = document.getElementById('filter-dari').value;
                let sampaiTanggal = document.getElementById('filter-sampai').value;

                if (bulanCheckbox.checked || tahunCheckbox.checked) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan nonaktifkan filter periode sebelum menerapkan filter tanggal.',
                        confirmButtonText: 'Mengerti'
                    });
                    return; // Hentikan proses jika filter salah
                }

                if (dariTanggal === '' && sampaiTanggal === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Filter tanggal telah direset',
                        confirmButtonText: 'Mengerti'
                    });
                    return; // Hentikan proses jika filter salah
                } else {
                    document.getElementById('filter-dari').value = '';
                    document.getElementById('filter-sampai').value = '';
                }

                let tables = [
                    '#tabel-pasien-masuk-id',
                    '#tabel-pasien-pindah-id',
                    '#tabel-pasien-keluar-id'
                ];

                tables.forEach(id => {
                    let tableElement = document.querySelector(id);
                    if (tableElement) {
                        let table = $(tableElement).DataTable();
                        $('.loading-table').show(); // Tampilkan loading spinner

                        setTimeout(() => {
                            table.draw(); // Perbarui tampilan tabel
                            // Hapus semua elemen group-header dengan cara manual
                            document.querySelectorAll(`tbody .group-header`).forEach(
                                header => {
                                    header.parentNode.removeChild(header);
                                });
                            $('.loading-table').hide(); // Sembunyikan loading spinner
                        }, 300);
                    }
                });
            });

            // Fungsi untuk membuat checkbox "Bulan" dan "Tahun" menjadi eksklusif
            function toggleCheckbox(selected, other) {
                if (selected.checked) {
                    other.checked = false; // Matikan checkbox lain
                    return true;
                }
            }

            // Fungsi untuk apply filter berdasarkan bulan atau tahun
            function applyFilter(isChecked, group) {
                let tables = [
                    '#tabel-pasien-masuk-id',
                    '#tabel-pasien-pindah-id',
                    '#tabel-pasien-keluar-id'
                ];

                document.querySelector('.loading-table').style.display = 'block'; // Tampilkan loading spinner tabel

                let activeTables = tables.filter(id => {
                    let tableElement = document.querySelector(id);
                    return tableElement && window.getComputedStyle(tableElement).display !== 'none';
                });

                // Jika tidak ada tabel yang aktif, sembunyikan loading spinner
                if (activeTables.length === 0) {
                    document.querySelector('.loading-table').style.display = 'none';
                    return;
                }

                // Reset Grouping dulu
                Promise.all(activeTables.map(id => {
                    return new Promise(resolve => {
                        let table = window.tableInstances[id];
                        if (!table) return resolve();

                        setTimeout(() => {
                            resetGrouping(id);
                            resolve();
                        }, 100); // Delay kecil agar reset berjalan dulu
                    });
                })).then(() => {
                    // jalankan filter setelah reset selesai
                    setTimeout(() => {
                        Promise.all(activeTables.map(id => {
                            return new Promise(resolve => {
                                let table = window.tableInstances[id];
                                if (!table) return resolve();

                                setTimeout(() => {
                                    if (isChecked) {
                                        group === "bulan" ? Bulan(id) :
                                            Tahun(id);
                                    }
                                    resolve();
                                }, 200);
                            });
                        })).then(() => {
                            $('.loading-table').hide();
                        });
                    }, 100);
                });
            }

            // Event listener untuk checkbox "Tahun"
            tahunCheckbox.addEventListener("change", function() {
                if (!isProcessing) {
                    toggleCheckbox(this, bulanCheckbox);
                    applyFilter(this.checked, "tahun");
                }
            });

            // Event listener untuk checkbox "Bulan"
            bulanCheckbox.addEventListener("change", function() {
                if (!isProcessing) {
                    toggleCheckbox(this, tahunCheckbox);
                    applyFilter(this.checked, "bulan");
                }
            });

            // Event Listener untuk menyesuaikan fk_id_kelas berdasarkan fk_kd_bangsal
            const editFkKdBangsal = document.getElementById("edit_fk_kd_bangsal");
            const editFkIdKelas = document.getElementById("edit_fk_id_kelas");
            editFkKdBangsal.addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];
                editFkIdKelas.value = selectedOption.getAttribute("data-kelas");
            });

            // Jika sudah ada datatable yang ada maka hancurkan dulu
            $('table.dataTable').each(function() {
                $(this).DataTable().destroy();
            });

            // Inisialisasi DataTable
            initializeDataTable();
            initializeTable_input();

            // Tampilkan konten setelah 200ms
            setTimeout(() => {
                // Initial display setup
                updateContentDisplay();
                updateInputPasienDisplay();
                updateTableDisplay();
            }, 200);

            // Tunggu DataTables selesai diinisialisasi
            var tables = ['#tabel-cari-pasien-pindah-id',
                '#tabel-cari-pasien-keluar-id'
            ]; // Tambahkan ID tabel lainnya di sini

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
    // Fungsi untuk menampilkan tabel Input pasien pindah dan keluar
    function updateInputPasienDisplay() {
        const ContainerInputPasien = document.querySelector('.container-form-input-pasien');
        const FormInputPasienMasuk = document.querySelector('.form-input-pasien-masuk');
        const TabelCariPasienPindah = document.querySelector('.tabel-cari-pasien-pindah');
        const TabelCariPasienKeluar = document.querySelector('.tabel-cari-pasien-keluar');

        // Form input pasien
        const formPasienPindah = document.querySelector('.form-pasien-pindah');
        const formPasienKeluar = document.querySelector('.form-pasien-keluar');

        // Reset tampilan semua form
        formPasienPindah.style.display = 'none';
        formPasienKeluar.style.display = 'none';

        // Cek apakah form input pasien sudah ditampilkan
        if (ContainerInputPasien.style.display == 'none') {
            return;
        } else {
            // Tampilkan Kontainer Input Pasien
            ContainerInputPasien.style.display = 'block';
        }

        // Sembunyikan loading spinner
        document.querySelector('.loading-table-input').style.display = 'none';

        // Ambil nilai dari selectedValue
        const selectElement = document.querySelector(".data-pasien-input");
        const selectedValue = selectElement.value;

        // Tampilkan tabel sesuai pilihan
        if (selectedValue === '1') {
            FormInputPasienMasuk.style.display = 'block';
            TabelCariPasienPindah.style.display = 'none';
            TabelCariPasienKeluar.style.display = 'none';
        } else if (selectedValue === '2') {
            FormInputPasienMasuk.style.display = 'none';
            TabelCariPasienPindah.style.display = 'block';
            TabelCariPasienKeluar.style.display = 'none';
        } else if (selectedValue === '3') {
            FormInputPasienMasuk.style.display = 'none';
            TabelCariPasienPindah.style.display = 'none';
            TabelCariPasienKeluar.style.display = 'block';
        } else {
            console.error('Nilai selectedValue tidak ditemukan');
        }

        // Sesuaikan tampilan kolom jika DataTables digunakan
        if (window.jQuery && $.fn.dataTable) {
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        }
    }

    // Fungsi untuk menampilkan tabel pasien 
    function updateTableDisplay() {
        const tabelPasienMasuk = document.querySelector('.tabel-pasien-masuk');
        const tabelPasienPindah = document.querySelector('.tabel-pasien-pindah');
        const tabelPasienKeluar = document.querySelector('.tabel-pasien-keluar');

        const tabelPasienMasukId = document.getElementById('tabel-pasien-masuk-id');
        const tabelPasienPindahId = document.getElementById('tabel-pasien-pindah-id');
        const tabelPasienKeluarId = document.getElementById('tabel-pasien-keluar-id');

        document.querySelector('.loading-table').style.display = 'none';

        // Ambil nilai dari selectedValue
        const selectElement = document.querySelector(".data-pasien-select");
        const selectedValue = selectElement.value;

        // Reset tampilan semua tabel
        tabelPasienMasuk.style.display = 'none';
        tabelPasienPindah.style.display = 'none';
        tabelPasienKeluar.style.display = 'none';
        tabelPasienMasukId.style.display = 'none';
        tabelPasienPindahId.style.display = 'none';
        tabelPasienKeluarId.style.display = 'none';

        // Tampilkan tabel sesuai pilihan
        if (selectedValue === '1') {
            tabelPasienMasuk.style.display = 'block';
            tabelPasienMasukId.style.display = 'table';
        } else if (selectedValue === '2') {
            tabelPasienPindah.style.display = 'block';
            tabelPasienPindahId.style.display = 'table';
        } else if (selectedValue === '3') {
            tabelPasienKeluar.style.display = 'block';
            tabelPasienKeluarId.style.display = 'table';
        } else {
            console.error('Nilai selectedValue tidak ditemukan');
        }

        // Sesuaikan tampilan kolom jika DataTables digunakan
        if (window.jQuery && $.fn.dataTable) {
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        }
    }

    // Fungsi untuk menampilkan konten
    function updateContentDisplay() {
        const cardInfo = document.querySelector('.card-info');
        const containerInputPasien = document.querySelector('.container-form-input-pasien');
        const tabelDataPasien = document.querySelector('.tabel-data-pasien');
        const filterJenisPasien = document.querySelector('.filter-jenis-pasien');
        const filterInputPasien = document.querySelector('.filter-input-pasien');
        const filterSelectKonten = document.querySelector('.filter-konten-select');

        // Ambil value dari konten select
        selectKonten = document.querySelector(".konten-select");
        selectedValue = selectKonten.value;

        // Selesaikan animasi loading
        document.querySelector('.loading').style.display = 'none';

        if (selectedValue == '1') {
            cardInfo.style.display = 'block';
            filterSelectKonten.style.display = 'block';
            filterJenisPasien.style.display = 'none';
            filterInputPasien.style.display = 'none';
            tabelDataPasien.style.display = 'none';
            containerInputPasien.style.display = 'none';
        } else if (selectedValue == '2') {
            cardInfo.style.display = 'none';
            filterInputPasien.style.display = 'none';
            filterSelectKonten.style.display = 'block';
            filterJenisPasien.style.display = 'block';
            tabelDataPasien.style.display = 'block';
            containerInputPasien.style.display = 'none';
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        } else if (selectedValue == '3') {
            filterSelectKonten.style.display = 'block';
            filterInputPasien.style.display = 'block';
            containerInputPasien.style.display = 'block';
            filterJenisPasien.style.display = 'none';
            cardInfo.style.display = 'none';
            tabelDataPasien.style.display = 'none';
            updateInputPasienDisplay();
        } else {
            console.error('Nilai selectedValue tidak ditemukan');
        }
    }

    // Fungsi untuk menjalankan DataTables
    function initializeDataTable() {
        // Daftarkan format custom di moment.js untuk DataTables
        $.fn.dataTable.moment("DD MMMM YYYY (HH:mm)");

        const tables = [{
                id: '#tabel-pasien-masuk-id',
                orderColumn: 5,
                scrollY: "35vh",
                colomWaktu: 5
            },
            {
                id: '#tabel-pasien-pindah-id',
                orderColumn: 4,
                scrollY: "35vh",
                colomWaktu: 4
            },
            {
                id: '#tabel-pasien-keluar-id',
                orderColumn: 5,
                scrollY: "35vh",
                colomWaktu: [4, 5]
            },
            {
                id: '#tabel-pasien-all-id',
                orderColumn: 3,
                scrollY: "22vh",
                colomWaktu: [3, 4, 5]
            }
        ];

        // Cari index yang harus dihapus
        const removeIndex = tables.findIndex(table => $.fn.DataTable.isDataTable(table.id));

        if (removeIndex !== -1) {
            tables.splice(removeIndex, 1); // Hapus elemen sesuai index yang ditemukan
        }

        function ambilCaptionTabel(id_tabel) {
            if (id_tabel == '#tabel-pasien-masuk-id') {
                return 'Pasien Masuk';
            } else if (id_tabel == '#tabel-pasien-pindah-id') {
                return 'Pasien Pindah';
            } else if (id_tabel == '#tabel-pasien-keluar-id') {
                return 'Pasien Keluar';
            } else {
                return 'Data Pasien';
            }
        }

        tables.forEach(table => {
            window.tableInstances[table.id] = new DataTable(table.id, {
                columnDefs: [{
                    targets: Array.isArray(table.colomWaktu) ? table.colomWaktu : [table
                        .colomWaktu
                    ],
                    type: "datetime-moment",
                    render: function(data, type, row) {
                        return type === 'sort' ? moment(data, "DD MMMM YYYY (HH:mm)")
                            .format("YYYY-MM-DD HH:mm") : data;
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
                pageLength: 50, // Default menampilkan semua data
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ], // -1 berarti "semua data"
                scrollCollapse: true, // Aktifkan fitur scroll
                scrollX: true, // Aktifkan scroll horizontal
                scrollY: table.scrollY, // Atur tinggi scroll
                autoWidth: false, // Atur lebar tabel secara otomatis
                deferRender: true, // Tunda render untuk meningkatkan performa
                scroller: true, // Aktifkan fitur scroller
                stateSave: true,
                // Urutkan berdasarkan kolom yang ditentukan secara DESC
                order: [table.orderColumn, "desc"],

                buttons: [{
                        text: '<i class="bi bi-arrows-fullscreen"></i>',
                        action: function(e, dt, node, config) {
                            toggleFullscreen($(dt.table().container())[0], dt, table.id);
                        }
                    },
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
                onInit: () => {
                    window.initialTableState = JSON.stringify(table
                        .state()); // Simpan state awal sebagai JSON string
                },
                drawCallback: function(settings) {
                    // Sembunyikan loading spinner
                    document.querySelector('.loading-table').style.display = 'none';
                }
            });
            // Cek apakah rowGroup sudah aktif
            // console.log("RowGroup aktif untuk tabel:", table.id, "Status:", dataTableInstance.rowGroup ? "OK" : "TIDAK ADA");
            window.tableInstances[table.id].state.save();
        });
    }

    let isGroupingByMonth = false; // State untuk melacak apakah grouping bulan aktif

    // Fungsi untuk grouping berdasarkan bulan
    function Bulan(tableId) {
        let dt = window.tableInstances[tableId]; // Ambil instance DataTable dari tableInstances
        if (!dt) return console.error("Table not found:", tableId); // Jika tidak ditemukan, keluarkan error

        if (!isGroupingByMonth) {
            dt.off('draw', addMonthHeaders); // Pastikan tidak ada event duplikat sebelumnya
            dt.on('draw', function() {
                addMonthHeaders(tableId); // Kirim ID tabel
            });

            isGroupingByMonth = true;
        } else {
            dt.off('draw', addMonthHeaders); // Hapus event listener saat dinonaktifkan
            isGroupingByMonth = false;
        }

        dt.draw(); // Gambar ulang tabel
    }

    // Fungsi untuk menambahkan header bulan
    function addMonthHeaders(tableId) {
        let dt = window.tableInstances[tableId]; // Ambil instance DataTable dari tableInstances
        if (!dt) return;

        let api = dt;
        let rows = api.rows({
            page: 'current'
        }).nodes();
        let lastGroup = null;

        // Hapus header grup sebelum menambahkan yang baru
        document.querySelectorAll(`${tableId} tbody .group-header`).forEach(header => {
            header.remove();
        });

        let columnIndex;

        if (tableId === '#tabel-pasien-masuk-id' || tableId === '#tabel-pasien-keluar-id') {
            columnIndex = 5;
        } else if (tableId === '#tabel-pasien-pindah-id') {
            columnIndex = 4;
        }

        if (columnIndex !== undefined) {
            api.column(columnIndex, {
                page: 'current'
            }).data().each(function(data, i) {
                let bulan = moment(data, "DD MMMM YYYY (HH:mm)").format("MMMM YYYY");

                if (lastGroup !== bulan) {
                    let headerRow = document.createElement("tr");
                    headerRow.classList.add("group-header");
                    headerRow.innerHTML = `<td colspan="11"><strong>${bulan}</strong></td>`;

                    rows[i].parentNode.insertBefore(headerRow, rows[i]);
                    lastGroup = bulan;
                }
            });
        }

    }

    let isGroupingByYear = false; // State untuk tracking apakah grouping tahun aktif

    // Fungsi untuk grouping berdasarkan tahun
    function Tahun(tableId) {
        let dt = window.tableInstances[tableId]; // Ambil instance DataTable dari tableInstances
        if (!dt) return console.error("Table not found:", tableId); // Jika tidak ditemukan, keluarkan error

        if (!isGroupingByYear) {
            dt.off('draw', addYearHeaders); // Pastikan tidak ada event duplikat sebelumnya
            dt.on('draw', function() {
                addYearHeaders(tableId); // Kirim ID tabel
            });

            isGroupingByYear = true;
        } else {
            dt.off('draw', addYearHeaders); // Hapus event listener saat dinonaktifkan
            isGroupingByYear = false;
        }

        dt.draw(); // Gambar ulang tabel
    }

    // Fungsi untuk menambahkan header tahun
    function addYearHeaders(tableId) {
        let dt = window.tableInstances[tableId]; // Ambil instance DataTable dari tableInstances
        if (!dt) return;

        let api = dt;
        let rows = api.rows({
            page: 'current'
        }).nodes();
        let lastGroup = null;

        // Hapus header grup sebelum menambahkan yang baru
        document.querySelectorAll(`${tableId} tbody .group-header`).forEach(header => {
            header.remove();
        });

        let columnIndex;

        if (tableId === '#tabel-pasien-masuk-id' || tableId === '#tabel-pasien-keluar-id') {
            columnIndex = 5;
        } else if (tableId === '#tabel-pasien-pindah-id') {
            columnIndex = 4;
        }

        if (columnIndex !== undefined) {
            api.column(columnIndex, {
                page: 'current'
            }).data().each(function(data, i) {
                let tahun = moment(data, "DD MMMM YYYY (HH:mm)").format("YYYY"); // Ambil hanya tahun

                if (lastGroup !== tahun) {
                    let headerRow = document.createElement("tr");
                    headerRow.classList.add("group-header");
                    headerRow.innerHTML = `<td colspan="11"><strong>${tahun}</strong></td>`;

                    rows[i].parentNode.insertBefore(headerRow, rows[i]);
                    lastGroup = tahun;
                }
            });
        }
    }

    // Fungsi reset grouping
    function resetGrouping(tableId) {
        let dt = window.tableInstances[tableId];
        if (!dt) return;

        // Hapus semua elemen group-header dengan cara manual
        document.querySelectorAll(`${tableId} tbody .group-header`).forEach(header => {
            header.parentNode.removeChild(header);
        });

        // Paksa DataTables untuk merender ulang
        resetToInitialState(dt); // Hapus cache state
    }

    function resetToInitialState(table) {
        if (!window.initialTableState) return; // Pastikan state awal ada

        let initialState = JSON.parse(window.initialTableState); // Ambil state awal yang disimpan
        table.state.clear(); // Hapus state saat ini
        table.state(initialState); // Terapkan kembali state awal
        table.draw(); // Refresh tabel agar perubahan terlihat
    }

    // Fungsi untuk toggle fullscreen
    function toggleFullscreen(element, dt, tableId) {
        if (!document.fullscreenElement) {
            // Masuk ke mode fullscreen
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) { // Firefox
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullscreen) { // Chrome, Safari, Opera
                element.webkitRequestFullscreen();
            } else if (element.msRequestFullscreen) { // IE/Edge
                element.msRequestFullscreen();
            }

            // Sembunyikan tombol edit dan hapus
            $(tableId + " .btn-edit").hide();
            $(tableId + " .btn-delete").hide();

            // Tampilkan Loading
            $('.loading').show();

            // Ubah background menjadi putih saat fullscreen
            $(element).css("background", "white");
            $(element).addClass("p-3");

            // Atur tinggi maksimal pada tabel
            let tableWrapper = $(tableId + "_wrapper .dt-layout-row .dt-layout-cell .dt-scroll .dt-scroll-body");
            tableWrapper.css("max-height", (window.innerHeight - 70) + "px");

            let tableWrapperHeihgt3 = $(tableId +
                "_wrapper .dt-layout-row .dt-layout-cell .dt-scroll .dt-scroll-head .dt-scroll-headInner .table");
            tableWrapperHeihgt3.css("width", (window.innerWidth - 39) + "px");

        } else {
            // Keluar dari mode fullscreen
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }

            $(element).removeClass("p-3");

            // Tampilkan tombol edit dan hapus
            $(tableId + " .btn-edit").show();
            $(tableId + " .btn-delete").show();

            // Tampilkan Loading
            $('.loading').hide();
            if (tableId == '#tabel-pasien-all-id') {
                console.log(tableId);
                $(tableId + "_wrapper .dt-layout-row .dt-layout-cell .dt-scroll .dt-scroll-body").css("max-height",
                    "22vh");
            } else {
                console.log("tes1");
                $(tableId + "_wrapper .dt-layout-row .dt-layout-cell .dt-scroll .dt-scroll-body").css("max-height",
                    "35vh");
            }
            $(".dt-layout-row .dt-layout-cell .dt-scroll .dt-scroll-head, .dt-scroll-headInner, .table").css("width",
                "100%");

        }
    }

    // **Event listener global untuk menangani keluar fullscreen dengan cara apapun**
    document.addEventListener("fullscreenchange", function() {
        if (!document.fullscreenElement) {

            // Hapus padding
            $("#tabel-pasien-masuk-id_wrapper").removeClass("p-3");
            $("#tabel-pasien-pindah-id_wrapper").removeClass("p-3");
            $("#tabel-pasien-keluar-id_wrapper").removeClass("p-3");
            $("#tabel-pasien-all-id_wrapper").removeClass("p-3");

            // Tampilkan Loading
            $('.loading').hide();

            // Atur tinggi maksimal dan with pada tabel
            let tableId = ['#tabel-pasien-masuk-id', '#tabel-pasien-pindah-id', '#tabel-pasien-keluar-id',
                '#tabel-pasien-all-id'
            ];
            tableId.forEach(id => {
                if (id === '#tabel-pasien-all-id') { // Bandingkan 'id', bukan array 'tableId'
                    console.log(id);
                    $(id + "_wrapper .dt-layout-row .dt-layout-cell .dt-scroll .dt-scroll-body").css(
                        "max-height", "22vh");
                } else {
                    console.log("tes");
                    $(id + "_wrapper .dt-layout-row .dt-layout-cell .dt-scroll .dt-scroll-body").css(
                        "max-height", "35vh");
                }
            });

            $(".dt-layout-row .dt-layout-cell .dt-scroll .dt-scroll-head, .dt-scroll-headInner, .table").css(
                "width", "100%");

            // Tampilkan tombol edit dan hapus
            $(".btn-edit").show();
            $(".btn-delete").show();
        }

    });

    // Fungsi untuk menetapkan tinggi konten
    window.onload = function() {
        const container = document.querySelector('.dataPasien-container');

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

    // FUNGSI CEK
    // Fungsi untuk cek form input pasien masuk
    function cekPasienMasuk() {
        const namaPasien = document.getElementById('input_nama_pasien').value;
        const jenisKelamin = document.getElementById('input_jenis_kelamin').value;
        const noRm = document.getElementById('input_no_rm').value;
        const waktuMasuk = document.getElementById('input_waktu_masuk').value;
        const bangsal = document.getElementById('input_fk_kd_bangsal').value;
        const kelasBangsal = document.getElementById('input_fk_id_kelas').value;

        if (!namaPasien || !jenisKelamin || !noRm || !waktuMasuk || !kelasBangsal || !bangsal) {
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
    // Fungsi untuk cek form edit pasien masuk
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
                    html: 'Waktu masuk saat ini harus lebih kecil dari waktu pindah/keluar sebelumnya!<br><br><b>Waktu pasien pindah/keluar sebelumnya:</b> <br>' +
                        waktu_terakhir_parsed,
                });
                return false;
            }
        }
        // debug
        //console.log(namaPasien, jenisKelamin, noRm, waktuMasuk, "|", kelasBangsal);

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

    // Fungsi untuk cek form input pasien pindah
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

    // Fungsi untuk cek data pasien pindah yang di edit apakah sudah lengkap
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

    // Fungsi cek form pasien keluar
    // Fungsi untuk cek apakah semua data sudah diisi memakai sweetalert2
    function cekPasienKeluar(event) {
        event.preventDefault(); // Mencegah form terkirim langsung

        const noRm = document.getElementById('tambah_no_rm_keluar').value;
        const namaPasien = document.getElementById('tambah_nama_pasien_keluar').value;
        const waktuKeluar = document.getElementById('tambah_waktu_keluar').value;
        const caraKeluar = document.getElementById('tambah_cara_keluar').value;

        const WaktuMasukOrPindah = document.getElementById('waktu_masuk_or_pindah_input').value;

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

    // Fungsi untuk cek data pasien keluar yang di edit apakah sudah lengkap
    // Fungsi untuk cek form edit pasien keluar
    function cekEditPasienKeluar() {
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
                html: 'Waktu keluar saat ini harus lebih besar dari waktu masuk/pindah sebelumnya!<br><br><b>Waktu masuk/pindah pasien sebelumnya:</b> <br>' +
                    waktuMoP_Parsed,
            });
            return false;
        }

        // Tampilkan loading
        loadingStatus();

        // Submit form
        document.getElementById('editPasienKeluarForm').submit();
    }

    // FUNGSI CRUD
    // Fungsi edit data pasien masuk
    function editPasienMasuk(id_pasien_masuk, bangsal, kelas_bangsal) {
        let editButton = document.getElementById(`editButton-${id_pasien_masuk}`);
        if (editButton) editButton.disabled = true;

        let form = document.getElementById("editPasienForm");
        form.action = `{{ route('update.petugas_indikator-pasienMasuk', ':id') }}`.replace(':id', id_pasien_masuk);

        fetch(`/petugas_indikator/data-pasien/${id_pasien_masuk}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("edit_id_pasien_masuk").value = id_pasien_masuk;
                document.getElementById("edit_no_rm").value = data.no_rm;
                document.getElementById("edit_nama_pasien").value = data.nama_pasien;
                document.getElementById("edit_jenis_kelamin").value = data.jenis_kelamin;
                // function formatDateUTCtoWIB(datetime) ada pada public/js/app.js
                document.getElementById("edit_waktu_masuk").value = formatDateUTCtoWIB(data.waktu_masuk);

                const editFkKdBangsal = document.getElementById("edit_fk_kd_bangsal");
                const editFkIdKelas = document.getElementById("edit_fk_id_kelas");

                editFkKdBangsal.innerHTML = "";
                editFkIdKelas.innerHTML = "";

                kelas_bangsal.forEach(kb => {
                    const bangsalData = bangsal.find(b => b.kd_bangsal === kb.fk_kd_bangsal);
                    if (bangsalData) {
                        const option = document.createElement("option");
                        option.value = kb.fk_kd_bangsal;
                        option.textContent =
                            `${bangsalData.nama_bangsal} - ${kb.nama_kelas ? kb.nama_kelas + ' (' + kb.jenis_kelas + ')' : '-'}`;
                        option.setAttribute("data-kelas", kb.id_kelas);

                        if (data.fk_kd_bangsal === kb.fk_kd_bangsal && data.fk_id_kelas === kb.id_kelas) {
                            option.selected = true;
                            editFkIdKelas.value = kb.id_kelas;
                        }

                        editFkKdBangsal.appendChild(option);
                    }
                });

                let modal = new bootstrap.Modal(document.getElementById('editPasienModal'));
                modal.show();

            })
            .catch(error => console.error("Gagal mengambil data:", error));

        document.addEventListener('shown.bs.modal', function(event) {
            let modal = event.target;
            modal.scrollTop = 0;
            document.body.classList.add('modal-open');
            // Ambil data sesudah data pasien masuk, jika pasien pernah pindah maka tetapkan atribut waktu-pindah-terakhir
            fetch(`/petugas_indikator/data-pasien/${id_pasien_masuk}/setelah`)
                .then(response => response.json())
                .then(data => {
                    // Cek data pasien pindah dari fetch
                    // Jika pasien pernah pindah atau keluar maka set atribut ke waktu-pindah-terakhir ke edit waktu masuk
                    if (data.waktu_terakhir) {
                        document.getElementById("edit_waktu_masuk").setAttribute('waktu-terakhir', data
                            .waktu_terakhir);
                        console.log("Waktu terakhir:", data.waktu_terakhir);
                    } else {
                        document.getElementById("edit_waktu_masuk").removeAttribute('waktu-terakhir');
                    }
                })
                .catch(error => console.error("Gagal mengambil data:", error));
        });

        document.addEventListener('hidden.bs.modal', function(event) {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            if (editButton) editButton.disabled = false;
        });
    }

    // Fungsi delete data pasien masuk
    function hapusDataPasienMasuk(id_pasien_masuk) {
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
                form.action = `{{ route('delete.petugas_indikator-pasienMasuk', ':id') }}`.replace(':id',
                    id_pasien_masuk);
                form.method = 'POST';
                form.innerHTML = '@csrf @method('DELETE')';
                document.body.appendChild(form);
                form.submit();

                // Tampilkan loading
                loadingStatus();
            }
        });
    }

    // Fungsi Input Data Pasien Pindah
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
                    option.textContent = bangsal.nama_bangsal + ' (' + kelasBangsal.nama_kelas + ' [' + kelasBangsal.jenis_kelas + '] )';
                    tujuanBangsalDropdown.appendChild(option);
                }
            });
        });

        // Sembunyikan tabel pencarian
        document.querySelector('.tabel-cari-pasien-pindah').style.display = 'none';

        // Tampilkan form input pasien pindah
        document.querySelector('.form-pasien-pindah').style.display = 'block';
    }

    // Fungsi edit data pasien pindah
    function editPasienPindah(pasien, dataBangsal) {
        // Ambil id pasien dari parameter
        let id_pasien_pindah = pasien.id_pindah;

        // debug parameter pasien
        //console.log(pasien);

        // Nonaktifkan tombol edit
        let editButton = document.getElementById(`editButton_Pindah-${id_pasien_pindah}`);
        if (editButton) {
            editButton.disabled = true; // Disable tombol sementara
        }

        // Set action form
        let form = document.getElementById("editPasienPindahForm");
        form.action = `{{ route('update.petugas_indikator-pasienPindah', ':id') }}`.replace(':id', id_pasien_pindah);

        // Reset dropdown sebelum mengisi ulang option bangsal
        let selectBangsal = document.getElementById('edit_tujuan_bangsal');
        selectBangsal.innerHTML = '<option value="">Pilih Bangsal Tujuan</option>';

        // set data bangsal asal dan kelas asal
        let bangsal_asal = pasien.bangsal_asal.nama_bangsal;
        let kelas_asal = pasien.kelas_bangsal_asal.nama_kelas + ' (' + pasien.kelas_bangsal_asal.jenis_kelas + ')';
        document.getElementById('edit_asal_bangsal').value = bangsal_asal + '[' + kelas_asal + ']';

        // Ambil data pasien dari server
        fetch(`/petugas_indikator/data-pasien/pindah/${id_pasien_pindah}/edit`)
            .then(response => response.json())
            .then(data => {
                // Isi data pada form
                document.getElementById("edit_fk_id_pasien_masuk").value = data.fk_id_pasien_masuk;
                document.getElementById("edit_no_rm_pindah").value = data.pasien_masuk.no_rm;
                document.getElementById("edit_nama_pasien_pindah").value = data.pasien_masuk.nama_pasien;
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

                // Tampilkan modal edit
                let modal = new bootstrap.Modal(document.getElementById('modalPasienPindah'));
                modal.show();
            })
            .catch(error => console.error("Gagal mengambil data:", error));

        // Fungsi untuk mengatur backdrop modal
        document.addEventListener('shown.bs.modal', function(event) {
            let modal = event.target;
            modal.scrollTop = 0;
            document.body.classList.add('modal-open');
            // Fecth data pasien pindah, ambil data pasien pindah sebelumnya
            fetch(`/petugas_indikator/data-pasien/pindah/${id_pasien_pindah}/sebelumnya`)
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

        // Fungsi untuk mengatur backdrop modal setelah modal ditutup
        document.addEventListener('hidden.bs.modal', function(event) {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            if (editButton) editButton.disabled = false; // Aktifkan kembali tombol edit
        });
    }

    // Fungsi bantuan untuk menyaring data bangsal
    // agar tidak ada bangsal dan kelas yang sama dengan asal
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

    // Fungsi hapus data pasien pindah
    function hapusDataPasienPindah(id_pasien_pindah) {
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
                form.action = `{{ route('delete.petugas_indikator-pasienPindah', ':id') }}`.replace(':id',
                    id_pasien_pindah);
                form.method = 'POST';
                form.innerHTML = '@csrf @method('DELETE')';
                document.body.appendChild(form);
                form.submit();

                // Tampilkan loading
                loadingStatus();
            }
        });
    }

    // Fungsi input data pasien keluar
    // Fungsi tambah Pasien Keluar
    function tambahPasienKeluar(pasien, waktu) {
        // set Nilai ke form
        document.getElementById('tambah_no_rm_keluar').value = pasien.no_rm;
        document.getElementById('tambah_nama_pasien_keluar').value = pasien.nama_pasien;
        document.getElementById('tambah_id_pasien_masuk_keluar').value = pasien.id_pasien_masuk;

        // set waktu masuk or pindah
        document.getElementById('waktu_masuk_or_pindah_input').value = waktu;

        // Sembunyikan tabel pencarian
        document.querySelector('.tabel-cari-pasien-keluar').style.display = 'none';

        // Tampilkan form input pasien pindah
        document.querySelector('.form-pasien-keluar').style.display = 'block';
    }

    // Fungsi edit data pasien keluar
    function editPasienKeluar(id_pasien_keluar, waktu) {
        let editButton = document.getElementById(`editButton_Keluar-${id_pasien_keluar}`);
        if (editButton) editButton.disabled = true;

        let form = document.getElementById("editPasienKeluarForm");
        form.action = `{{ route('update.petugas_indikator-pasienKeluar', ':id') }}`.replace(':id', id_pasien_keluar);

        // set variabel untuk waktu pindah atau masuk pasien
        document.getElementById('waktu_masuk_or_pindah').value = waktu;

        fetch(`/petugas_indikator/data-pasien/keluar/${id_pasien_keluar}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("fk_id_pasien_masuk_modalKeluar").value = data.fk_id_pasien_masuk;
                document.getElementById("edit_no_rm_keluar").value = data.pasien_masuk.no_rm;
                document.getElementById("edit_nama_pasien_keluar").value = data.pasien_masuk.nama_pasien;
                // function formatDateUTCtoWIB(datetime) ada pada public/js/app.js
                document.getElementById("edit_waktu_keluar").value = formatDateUTCtoWIB(data.waktu_keluar);

                let modal = new bootstrap.Modal(document.getElementById('modalPasienKeluar'));
                modal.show();
            })
            .catch(error => console.error("Gagal mengambil data:", error));

        // Fungsi untuk mengatur backdrop modal
        document.addEventListener('shown.bs.modal', function(event) {
            let modal = event.target;
            modal.scrollTop = 0;
            document.body.classList.add('modal-open');
        });

        // Fungsi untuk mengatur backdrop modal setelah modal ditutup
        document.addEventListener('hidden.bs.modal', function(event) {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            if (editButton) editButton.disabled = false; // Aktifkan kembali tombol edit
        });
    }

    // Fungsis hapus data pasien keluar
    function hapusDataPasienKeluar(id_pasien_keluar) {
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
                form.action = `{{ route('delete.petugas_indikator-pasienKeluar', ':id') }}`.replace(':id',
                    id_pasien_keluar);
                form.method = 'POST';
                form.innerHTML = '@csrf @method('DELETE')';
                document.body.appendChild(form);
                form.submit();

                // Tampilkan loading
                loadingStatus();
            }
        });
    }

    // Fungsi Inisialisasi DataTable untuk Input Pasien Pindah dan Keluar
    function initializeTable_input() {
        // Daftarkan format custom di moment.js untuk DataTables
        $.fn.dataTable.moment("DD MMMM YYYY (HH:mm)");

        const tables = [{
                id: '#tabel-cari-pasien-pindah-id',
                orderColumn: 3,
                scrollY: "35vh",
                colomWaktu: 3,
                hidenColom: [4, 5, 6]
            },
            {
                id: '#tabel-cari-pasien-keluar-id',
                orderColumn: 5,
                scrollY: "35vh",
                colomWaktu: [5, 6],
                hidenColom: [3, 4]
            }
        ];

        // Cari index yang harus dihapus
        const removeIndex = tables.findIndex(table => $.fn.DataTable.isDataTable(table.id));

        if (removeIndex !== -1) {
            tables.splice(removeIndex, 1); // Hapus elemen sesuai index yang ditemukan
        }

        function ambilCaptionTabel(id_tabel) {
            if (id_tabel == '#tabel-cari-pasien-pindah-id') {
                return 'Pasien Pindah';
            } else if (id_tabel == '#tabel-cari-pasien-keluar-id') {
                return 'Pasien Keluar';
            } else {
                return 'Data Pasien';
            }
        }

        tables.forEach(table => {
            window.tableInstances_input[table.id] = new DataTable(table.id, {
                columnDefs: [{
                    targets: Array.isArray(table.colomWaktu) ? table.colomWaktu : [table
                        .colomWaktu
                    ],
                    type: "datetime-moment",
                    render: function(data, type, row) {
                        return type === 'sort' ? moment(data, "DD MMMM YYYY (HH:mm)")
                            .format("YYYY-MM-DD HH:mm") : data;
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
                pageLength: 50, // Default menampilkan semua data
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ], // -1 berarti "semua data"
                scrollCollapse: true, // Aktifkan fitur scroll
                scrollX: true, // Aktifkan scroll horizontal
                scrollY: table.scrollY, // Atur tinggi scroll
                autoWidth: false, // Atur lebar tabel secara otomatis
                deferRender: true, // Tunda render untuk meningkatkan performa
                scroller: true, // Aktifkan fitur scroller
                stateSave: true,
                // Urutkan berdasarkan kolom yang ditentukan secara DESC
                order: [table.orderColumn, "desc"],

                // Button
                buttons: [{
                        extend: 'excel',
                        text: '<i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: function() {
                            return ambilCaptionTabel(table.id);
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: function() {
                            return ambilCaptionTabel(table.id);
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer-fill"></i> Print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: function() {
                            return ambilCaptionTabel(table.id);
                        }
                    },
                    {
                        text: '<i class="bi bi-caret-down-square"></i> Detail off',
                        action: function(e, dt, node, config) {
                            var columns = table.hidenColom;
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
                    targets: table.hidenColom,
                    visible: false
                }]
            });

            window.tableInstances_input[table.id].state.save();
        });
    }
    
</script>

<!-- Style -->
<style>
    .bg-pasien-masuk {
        background-color: rgb(52, 126, 168);
    }

    .bg-pasien-keluar {
        background-color: rgb(244, 91, 91);
    }

    .bg-pasien-pindah {
        background-color: rgb(241, 158, 4);
    }

    .bg-total-pasien {
        background-color: #6c5b3b;
    }

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

    .dataPasien-container {
        transition: opacity 0.4s ease-in-out;
    }

    .card-filter {
        background-color: #155E95;
        color: white;
        border: 0;
    }
</style>
