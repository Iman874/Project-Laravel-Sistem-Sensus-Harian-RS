<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Laporan;
use Illuminate\Support\Facades\Log;
use App\Models\PasienKeluar;
use App\Models\Bangsal;
use App\Models\PasienMasuk;
use App\Models\PasienPindah;
use App\Models\DataLaporan\BOR;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Laporan Terikirim
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::guard(session('guard'))->user();

        // Ambil variabel dengan pengecekan jika ada
        $role = $user->role ?? null;
        $nama = $user->nama ?? null;

        // Ambil data laporan
        $laporan = Laporan::all();

        // Enkripsi data
        $data = Crypt::encrypt([
            'laporan' => $laporan
        ]);

        return view('page.home', compact(
            'data',
            'role',
            'nama'
        ));
    }

    // Rekaptulasi Laporan
    public function rekapitulasi()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::guard(session('guard'))->user();
        $role = $user->role ?? null;
        $nama = $user->nama ?? null;
        $bangsal = Bangsal::all(); // Ambil data bangsal

        // Ambil data pasien terlama dan terbaru
        $tanggal = $this->get_dataPasienTanggal();
        $tanggal_terlama = $tanggal['tanggal_terlama'];
        $tanggal_terbaru = $tanggal['tanggal_terbaru'];

        $tanggal_terlama = Carbon::parse($tanggal_terlama)->startOfMonth()->format('Y-m-d');
        $tanggal_terbaru = Carbon::parse($tanggal_terbaru)->endOfMonth()->format('Y-m-d');

        // Buat Array untuk menampung jumlah hari per-periode perbulan
        $jumlah_hari_per_bulan = $this->get_hariPerbulan($tanggal_terlama, $tanggal_terbaru);
        $jumlah_bulan_periode = count($jumlah_hari_per_bulan); // Hitung total periode

        // Ambil data pasien sesuai dengan tanggal terlama dan terbaru
        $data_pasien = $this->get_dataPasienPerawatan('all', $tanggal_terlama, $tanggal_terbaru);

        // Hitung jumlah hari perawatan per bangsal
        $hari_perawatan_per_bangsal = BOR::jumlahHariPerawatan(
            $data_pasien['masuk'], $data_pasien['pindah'], $data_pasien['keluar'],
            $jumlah_hari_per_bulan, $jumlah_bulan_periode
        );

        $bor_per_bangsal = $this->get_BorPerbangsal($hari_perawatan_per_bangsal, $jumlah_hari_per_bulan, $bangsal); // Bor per bangsal
        $bor_all_periode = $this->get_Bor_perPeriode($hari_perawatan_per_bangsal, $jumlah_hari_per_bulan, $bangsal); // Bor per periode

        // Ambil data periode
        $periode = $this->get_periode();

        // Enkripsi data
        $data = Crypt::encrypt([
            'bor' => $bor_per_bangsal,
            'totalBOR' => $bor_all_periode,
            'periode' => $periode
        ]);

        return view('page.home', compact(
            'data',
            'role',
            'nama',
            'bangsal' 
        ));
    }

    public function getDataRekapitulasi(Request $request)
    {
        $awal = Carbon::parse($request->query('tanggal_awal'));
        $akhir = Carbon::parse($request->query('tanggal_akhir'));
        $bangsal = Bangsal::all();

        // Ambil data pasien terlama dan terbaru
        $tanggal = $this->get_dataPasienTanggal();
        $tanggal_terlama = $tanggal['tanggal_terlama'];
        $tanggal_terbaru = $tanggal['tanggal_terbaru'];

        $periode[] = [
            'awal' => $awal->format('Y-m-d'),
            'akhir' => $akhir->format('Y-m-d')
        ];

        $jumlah_hari_per_bulan = $this->get_hariPerbulan($periode[0]['awal'], $periode[0]['akhir']);
        $jumlah_bulan_periode = count($jumlah_hari_per_bulan); // Hitung total periode

        $data_pasien = $this->get_dataPasienPerawatan('all', $periode[0]['awal'], $periode[0]['akhir']);
        $hari_perawatan_per_bangsal = BOR::jumlahHariPerawatan(
            $data_pasien['masuk'], $data_pasien['pindah'], $data_pasien['keluar'],
            $jumlah_hari_per_bulan, $jumlah_bulan_periode
        );

        $bor_per_bangsal = []; // Inisialisasi array untuk menyimpan hasil BOR per bangsal

        foreach ($hari_perawatan_per_bangsal as $kdBangsal => $jumlah_hari_perawatan) {
            $bor = BOR::HitungBOR(
                $jumlah_hari_perawatan,
                $bangsal->where('kd_bangsal', $kdBangsal)->first()->total_tempat_tidur ?? 0,
                $jumlah_hari_per_bulan
            );

            $bor_per_bangsal[] = [
                'periode' => $periode[0]['awal'] . ' s.d ' . $periode[0]['akhir'],
                'nama_bangsal' => $bangsal->where('kd_bangsal', $kdBangsal)->first()->nama_bangsal,
                'kd_bangsal' => $kdBangsal,
                'total_tempat_tidur' => $bangsal->where('kd_bangsal', $kdBangsal)->first()->total_tempat_tidur ?? 0,
                'hasil_bor' => $bor
            ];
        }

        // Hitung BOR periode
        $bor_per_periode = $this->get_Bor_perPeriode($hari_perawatan_per_bangsal, $jumlah_hari_per_bulan, $bangsal);

        return response()->json([
            'bor' => $bor_per_bangsal,
            'totalBOR' => $bor_per_periode
        ]);
    }

    private function get_dataPasienPerawatan($periode, $awal = null, $akhir = null)
    {
        $pasien_masuk_per_bangsal = [];
        $pasien_pindah_per_bangsal = [];
        $pasien_keluar_per_bangsal = [];

        $bangsal = Bangsal::all();

        if ($periode === 'all') {
            foreach ($bangsal as $value) {
                $kdBangsal = $value->kd_bangsal;

                $pasien_masuk_per_bangsal[$kdBangsal] = PasienMasuk::where('fk_kd_bangsal', $kdBangsal)
                ->when($awal && $akhir, function ($query) use ($awal, $akhir) {
                    $query->whereBetween('waktu_masuk', [$awal, $akhir]);
                })
                    ->with('pasien_pindahs')
                    ->get(['fk_kd_bangsal', 'waktu_masuk']) ?: collect();

                $pasien_pindah_per_bangsal[$kdBangsal] = PasienPindah::where(function ($query) use ($kdBangsal) {
                        $query->where('fk_asal_bangsal', $kdBangsal)
                            ->orWhere('fk_tujuan_bangsal', $kdBangsal);
                    })
                ->when($awal && $akhir, function ($query) use ($awal, $akhir) {
                    $query->whereBetween('waktu_pindah', [$awal, $akhir]);
                })
                    ->with('pasien_masuk')
                    ->get(['fk_asal_bangsal', 'fk_tujuan_bangsal', 'waktu_pindah']) ?: collect();

                $pasien_keluar_per_bangsal[$kdBangsal] = PasienKeluar::whereHas('pasien_masuk', function ($query) use ($kdBangsal) {
                        $query->where('fk_kd_bangsal', $kdBangsal);
                    })
                ->when($awal && $akhir, function ($query) use ($awal, $akhir) {
                    $query->whereBetween('waktu_keluar', [$awal, $akhir]);
                })
                    ->with('pasien_masuk')
                    ->get(['fk_id_pasien_masuk', 'waktu_keluar']) ?: collect();
            }
        } else {
            // Cek apakah 6 bulan (format: YYYY-MM/6) atau per tahun (format: YYYY)
            if (str_contains($periode, '/6')) {
                [$tahun_bulan_awal, $range] = explode('/', $periode);
                [$tahun, $bulan_mulai] = explode('-', $tahun_bulan_awal);

                $bulan_mulai = intval($bulan_mulai);
                $range = intval($range);
                $bulan_akhir = $bulan_mulai + $range - 1;

                foreach ($bangsal as $value) {
                    $kdBangsal = $value->kd_bangsal;
                    for ($bulan = $bulan_mulai; $bulan <= $bulan_akhir; $bulan++) {
                        $pasien_masuk_per_bangsal[$kdBangsal][$bulan] = PasienMasuk::where('fk_kd_bangsal', $kdBangsal)
                            ->whereYear('waktu_masuk', $tahun)
                            ->whereMonth('waktu_masuk', $bulan)
                            ->with('pasien_pindahs')
                            ->get(['fk_kd_bangsal', 'waktu_masuk']) ?: collect();

                        $pasien_pindah_per_bangsal[$kdBangsal][$bulan] = PasienPindah::where(function ($query) use ($kdBangsal) {
                            $query->where('fk_asal_bangsal', $kdBangsal)
                                ->orWhere('fk_tujuan_bangsal', $kdBangsal);
                        })->whereYear('waktu_pindah', $tahun)
                        ->whereMonth('waktu_pindah', $bulan)
                        ->with('pasien_masuk')
                        ->get(['fk_asal_bangsal', 'fk_tujuan_bangsal', 'waktu_pindah']) ?: collect();

                        $pasien_keluar_per_bangsal[$kdBangsal][$bulan] = PasienKeluar::whereHas('pasien_masuk', function ($query) use ($kdBangsal) {
                            $query->where('fk_kd_bangsal', $kdBangsal);
                        })->whereYear('waktu_keluar', $tahun)
                        ->whereMonth('waktu_keluar', $bulan)
                        ->with('pasien_masuk')
                        ->get(['fk_id_pasien_masuk', 'waktu_keluar']) ?: collect();
                    }
                }
            } else {
                // Per tahun, ambil Januari - Desember
                $tahun = intval($periode);

                foreach ($bangsal as $value) {
                    $kdBangsal = $value->kd_bangsal;
                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                        $pasien_masuk_per_bangsal[$kdBangsal][$bulan] = PasienMasuk::where('fk_kd_bangsal', $kdBangsal)
                            ->whereYear('waktu_masuk', $tahun)
                            ->whereMonth('waktu_masuk', $bulan)
                            ->with('pasien_pindahs')
                            ->get(['fk_kd_bangsal', 'waktu_masuk']) ?: collect();

                        $pasien_pindah_per_bangsal[$kdBangsal][$bulan] = PasienPindah::where(function ($query) use ($kdBangsal) {
                            $query->where('fk_asal_bangsal', $kdBangsal)
                                ->orWhere('fk_tujuan_bangsal', $kdBangsal);
                        })->whereYear('waktu_pindah', $tahun)
                        ->whereMonth('waktu_pindah', $bulan)
                        ->with('pasien_masuk')
                        ->get(['fk_asal_bangsal', 'fk_tujuan_bangsal', 'waktu_pindah']) ?: collect();

                        $pasien_keluar_per_bangsal[$kdBangsal][$bulan] = PasienKeluar::whereHas('pasien_masuk', function ($query) use ($kdBangsal) {
                            $query->where('fk_kd_bangsal', $kdBangsal);
                        })->whereYear('waktu_keluar', $tahun)
                        ->whereMonth('waktu_keluar', $bulan)
                        ->with('pasien_masuk')
                        ->get(['fk_id_pasien_masuk', 'waktu_keluar']) ?: collect();
                    }
                }
            }
        }

        return [
            'masuk' => $pasien_masuk_per_bangsal,
            'pindah' => $pasien_pindah_per_bangsal,
            'keluar' => $pasien_keluar_per_bangsal
        ];
    }

    private function get_periode()
    {
        $pasien_masuk_terlama = PasienMasuk::orderBy('waktu_masuk', 'asc')->first();
        $pasien_masuk_terbaru = PasienMasuk::orderBy('waktu_masuk', 'desc')->first();
        $pasien_pindah_terbaru = PasienPindah::orderBy('waktu_pindah', 'desc')->first();
        $pasien_keluar_terbaru = PasienKeluar::orderBy('waktu_keluar', 'desc')->first();
    
        $tanggal_terbaru = [];
    
        if ($pasien_masuk_terbaru) $tanggal_terbaru[] = $pasien_masuk_terbaru->waktu_masuk;
        if ($pasien_pindah_terbaru) $tanggal_terbaru[] = $pasien_pindah_terbaru->waktu_pindah;
        if ($pasien_keluar_terbaru) $tanggal_terbaru[] = $pasien_keluar_terbaru->waktu_keluar;
    
        $pasien_terbaru = max($tanggal_terbaru);
        $periode = [];
    
        if ($pasien_masuk_terlama && $pasien_terbaru) {
            $waktu_awal = Carbon::parse($pasien_masuk_terlama->waktu_masuk)->startOfMonth();
            $waktu_akhir = Carbon::parse($pasien_terbaru)->endOfMonth();
            $total_bulan = $waktu_awal->diffInMonths($waktu_akhir) + 1;
    
            $periode_6_bulanan = [];
            $current = $waktu_awal->copy();
            while ($current->lt($waktu_akhir)) {
                $akhir = $current->copy()->addMonths(5)->endOfMonth();
                if ($akhir->gt($waktu_akhir)) {
                    $akhir = $waktu_akhir;
                }
    
                $periode_6_bulanan[] = [
                    'mulai' => $current->copy(),
                    'akhir' => $akhir->copy(),
                    'label' => $current->format('F Y') . ' - ' . $akhir->format('F Y'),
                    'value' => $current->format('Y-m-d') . '|' . $akhir->format('Y-m-d')
                ];
    
                $current = $current->copy()->addMonths(6)->startOfMonth();
            }
    
            $periode_tahunan = [];
            for ($i = 0; $i < floor(count($periode_6_bulanan) / 2); $i++) {
                $first = $periode_6_bulanan[$i * 2];
                $second = $periode_6_bulanan[$i * 2 + 1];
                $periode_tahunan[] = [
                    'label' => $first['mulai']->format('F Y') . ' - ' . $second['akhir']->format('F Y'),
                    'value' => $first['mulai']->format('Y-m-d') . '|' . $second['akhir']->format('Y-m-d')
                ];
            }
    
            // Sisa bulan jika ada (kurang dari 6 bulan di akhir)
            $sisa_index = floor(count($periode_6_bulanan) / 2) * 2;
            if (isset($periode_6_bulanan[$sisa_index])) {
                $sisa = $periode_6_bulanan[$sisa_index];
                $periode[] = [
                    'label' => $sisa['label'],
                    'value' => $sisa['value']
                ];
            }
    
            // Tambahkan semua periode 6 bulan
            foreach ($periode_6_bulanan as $p) {
                $periode[] = [
                    'label' => $p['label'],
                    'value' => $p['value']
                ];
            }
    
            // Tambahkan periode tahunan
            foreach ($periode_tahunan as $t) {
                $periode[] = $t;
            }
    
            // Tambahkan 1 periode keseluruhan
            $periode[] = [
                'label' => $waktu_awal->format('F Y') . ' - ' . $waktu_akhir->format('F Y'),
                'value' => $waktu_awal->format('Y-m-d') . '|' . $waktu_akhir->format('Y-m-d')
            ];
        } else {
            $periode[] = "Tidak ada data pasien";
        }
    
        return $periode;
    }
    

    private function get_hariPerbulan($awal = null, $akhir = null)
    {
        $tahun_sekarang = now()->year;
    
        $start = $awal ? Carbon::parse($awal)->startOfMonth() : Carbon::create($tahun_sekarang, 1, 1)->startOfMonth();
        $end = $akhir ? Carbon::parse($akhir)->endOfMonth() : Carbon::create($tahun_sekarang, 12, 31)->endOfMonth();
    
        $result = [];
    
        while ($start->lte($end)) {
            $result[] = [
                'jumlah_hari' => $start->daysInMonth,
                'awal' => $start->copy()->startOfMonth()->toDateString(),
                'akhir' => $start->copy()->endOfMonth()->toDateString(),
            ];
            $start->addMonth();
        }
    
        return $result;
    }    

    function get_dataPasienTanggal()
    {
        // Ambil pasien masuk paling lama
        $pasien_masuk_terlama = PasienMasuk::orderBy('waktu_masuk', 'asc')->first();

        // Ambil pasien terbaru dari masing-masing sumber
        $pasien_masuk_terbaru = PasienMasuk::orderBy('waktu_masuk', 'desc')->first();
        $pasien_pindah_terbaru = PasienPindah::orderBy('waktu_pindah', 'desc')->first();
        $pasien_keluar_terbaru = PasienKeluar::orderBy('waktu_keluar', 'desc')->first();

        // Ambil tanggal-tanggalnya
        $tanggal_masuk  = $pasien_masuk_terbaru?->waktu_masuk;
        $tanggal_pindah = $pasien_pindah_terbaru?->waktu_pindah;
        $tanggal_keluar = $pasien_keluar_terbaru?->waktu_keluar;

        // Tentukan tanggal terbaru
        // Bandingkan untuk cari tanggal terbaru
        $tanggal_terbaru = collect([
            $tanggal_masuk,
            $tanggal_pindah,
            $tanggal_keluar,
        ])->filter()->max(); // filter() untuk buang null, lalu ambil maksimal


        // Tentukan tanggal terlama
        $tanggal_terlama = $pasien_masuk_terlama
            ? $pasien_masuk_terlama->waktu_masuk
            : now();

        // Format ke Y-m-d
        return [
            'tanggal_terlama' => Carbon::parse($tanggal_terlama)->format('Y-m-d'),
            'tanggal_terbaru' => Carbon::parse($tanggal_terbaru)->format('Y-m-d')
        ];
    }

    function get_BorPerbangsal($hari_perawatan_perbangsal, $jumlah_hari_perbulan, $dataBangsal)
    {
        $bor_per_bangsal = [];

        foreach ($hari_perawatan_perbangsal as $kdBangsal => $jumlah_hari_perawatan) {
            $tempat_tidur = $dataBangsal->where('kd_bangsal', $kdBangsal)->first()->total_tempat_tidur ?? 0;

            $bor_per_bangsal[$kdBangsal] = BOR::HitungBOR(
                $jumlah_hari_perawatan,
                $tempat_tidur,
                $jumlah_hari_perbulan
            );
        }

        return $bor_per_bangsal;
    }

    function get_Bor_perPeriode($hari_perawatan_perbangsal, $jumlah_hari_perbulan, $dataBangsal)
    {
        $total_hari_perawatan = 0;
        $total_tempat_tidur = 0;

        foreach ($hari_perawatan_perbangsal as $kdBangsal => $jumlah_hari_perawatan) {
            $tempat_tidur = $dataBangsal->where('kd_bangsal', $kdBangsal)->first()->total_tempat_tidur ?? 0;

            $total_hari_perawatan += $jumlah_hari_perawatan;
            $total_tempat_tidur += $tempat_tidur;
        }

        return BOR::HitungBOR($total_hari_perawatan, $total_tempat_tidur, $jumlah_hari_perbulan);
    }

}
