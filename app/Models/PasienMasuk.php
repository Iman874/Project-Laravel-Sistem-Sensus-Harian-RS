<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasienMasuk
 * 
 * @property int $id_pasien_masuk
 * @property string $nama_pasien
 * @property string $jenis_kelamin
 * @property Carbon $waktu_masuk
 * @property int $fk_id_logs
 * @property int $fk_kd_bangsal
 * @property int $fk_id_kelas
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property KelasBangsal $kelas_bangsal
 * @property LogsTabelPasien $logs_tabel_pasien
 * @property Bangsal $bangsal
 * @property PasienKeluar $pasien_keluar
 * @property Collection|PasienPindah[] $pasien_pindahs
 *
 * @package App\Models
 */
class PasienMasuk extends Model
{
	protected $table = 'pasien_masuk';
	protected $primaryKey = 'id_pasien_masuk';

	protected $casts = [
		'waktu_masuk' => 'datetime',
		'fk_id_logs' => 'int',
		'fk_kd_bangsal' => 'int',
		'fk_id_kelas' => 'int'
	];

	protected $fillable = [
		'no_rm',
		'nama_pasien',
		'jenis_kelamin',
		'waktu_masuk',
		'fk_id_logs',
		'fk_kd_bangsal',
		'fk_id_kelas'
	];

	public function kelas_bangsal()
	{
		return $this->belongsTo(KelasBangsal::class, 'fk_id_kelas');
	}

	public function logs_tabel_pasien()
	{
		return $this->belongsTo(LogsTabelPasien::class, 'fk_id_logs');
	}

	public function bangsal()
	{
		return $this->belongsTo(Bangsal::class, 'fk_kd_bangsal');
	}

	public function pasien_keluar()
	{
		return $this->hasOne(PasienKeluar::class, 'fk_id_pasien_masuk', 'id_pasien_masuk');
	}

	public function pasien_pindahs()
	{
		return $this->hasMany(PasienPindah::class, 'fk_id_pasien_masuk', 'id_pasien_masuk');
	}

	// Fungsi untuk mengambil data pasien masuk dengan relasi
	public function scopeWithAllRelations($query)
	{
		$relations = [];
		foreach ((new \ReflectionClass($this))->getMethods() as $method) {
			if ($method->class === get_class($this) && !$method->isStatic()) {
				$returnType = $method->getReturnType();
				if ($returnType && is_subclass_of($returnType->getName(), \Illuminate\Database\Eloquent\Relations\Relation::class)) {
					$relations[] = $method->name;
				}
			}
		}
		return $query->with($relations);
	}

	// Fungsi untuk mengambil data bangsal terbaru dari pasien masuk berdasarkan relasi pasien_pindah
	public function bangsal_terbaru()
	{
		// Pastikan pasien_pindahs adalah Collection
		$pasien_pindah = $this->pasien_pindahs()->with(['bangsal_tujuan', 'kelas_bangsal_tujuan'])->get();

		// Jika pasien tidak pernah pindah, ambil bangsal & kelas dari pasien_masuk
		if ($pasien_pindah->isEmpty()) {
			return [
				'bangsal' => $this->bangsal ?? null,
				'kelas' => $this->kelas_bangsal ?? null
			];
		}

		// Jika pernah pindah, ambil data pindah terbaru berdasarkan waktu_pindah
		$pasien_pindah_terbaru = $pasien_pindah->sortByDesc('waktu_pindah')->first();

		return [
			'bangsal' => $pasien_pindah_terbaru->bangsal_tujuan ?? null,
			'kelas' => $pasien_pindah_terbaru->kelas_bangsal_tujuan ?? null
		];
	}

}
