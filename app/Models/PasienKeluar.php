<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasienKeluar
 * 
 * @property int $fk_id_pasien_masuk
 * @property Carbon $waktu_keluar
 * @property string $cara_keluar
 * @property int $fk_id_logs
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property LogsTabelPasien $logs_tabel_pasien
 * @property PasienMasuk $pasien_masuk
 *
 * @package App\Models
 */
class PasienKeluar extends Model
{
	protected $table = 'pasien_keluar';
	protected $primaryKey = 'fk_id_pasien_masuk';

	protected $casts = [
		'waktu_keluar' => 'datetime',
		'fk_id_logs' => 'int'
	];

	protected $fillable = [
		'fk_id_pasien_masuk',
		'waktu_keluar',
		'cara_keluar', // cara keluar pasien (hidup, mati, dipindahkan)
		'fk_id_logs'
	];

	public function logs_tabel_pasien()
	{
		return $this->belongsTo(LogsTabelPasien::class, 'fk_id_logs');
	}

	public function pasien_masuk()
	{
		return $this->hasOne(PasienMasuk::class, 'id_pasien_masuk');
	}

	// Fungsi untuk mengambil data pasien masuk dengan relasi
	public function scopeWithAllRelations($query)
	{
		$relations = [
			'pasien_masuk', 
			'logs_tabel_pasien',
			'pasien_masuk.pasien_pindahs',
			'pasien_masuk.pasien_pindahs.bangsal_tujuan', // Relasi dalam pasien_masuk
			'pasien_masuk.pasien_pindahs.kelas_bangsal_asal' // Relasi dalam pasien_masuk
		];

    	return $query->with($relations);
	}

	// Fungsi untuk mengambil data bangsal & kelas terakhir pasien
	public function bangsal_terakhir()
	{
		$pasien_masuk = $this->pasien_masuk;

		if (!$pasien_masuk) {
			return null;
		}

		$pasien_pindah = $pasien_masuk->pasien_pindahs;

		// Jika pasien tidak pernah pindah, ambil bangsal & kelas dari pasien_masuk
		if ($pasien_pindah->isEmpty()) {
			return [
				'bangsal' => $pasien_masuk->bangsal,
				'kelas' => $pasien_masuk->kelas_bangsal
			];
		}

		// Jika pernah pindah, ambil data pindah terbaru berdasarkan waktu_pindah
		$pindah_terakhir = $pasien_pindah->sortByDesc('waktu_pindah')->first();

		return [
			'bangsal' => $pindah_terakhir->bangsal_tujuan,
			'kelas' => $pindah_terakhir->kelas_bangsal_tujuan ?? $pasien_masuk->kelas_bangsal, // Jika tidak ada kelas di bangsal tujuan, pakai dari pasien_masuk
		];
	}

	// Fungsi untuk data pasien keluar yang tidak pernah pindah
	public function scopeNotPindah($query)
	{
		return $query->whereDoesntHave('pasien_masuk.pasien_pindahs');
	}
	
	// Fungsi untuk cek apakah pasien keluar pernah pindah
	public function scopeHasPindah($query)
	{
		return $query->whereHas('pasien_masuk', function ($q) {
			$q->whereHas('pasien_pindahs');
		});
	}

	// Fungsi untuk mengambil relasi bangsal tujuan pindah terakhir
	public function scopeWithBangsalTujuan($query){
		$relations = [
			'pasien_masuk.pasien_pindahs',
			'pasien_masuk.pasien_pindahs.bangsal_tujuan',
			'pasien_masuk.pasien_pindahs.kelas_bangsal_tujuan'
		];
		return $query->with($relations);
	}

	// Fungsi untuk mengambil relasi pasien pindah waktu pindah
	public function scopeWithWaktuPindah($query){
		$relations = [
			'pasien_masuk.pasien_pindahs'
		];
		return $query->with($relations);
	}
}
