<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasienPindah
 * 
 * @property int $id_pindah
 * @property int $fk_id_pasien_masuk
 * @property int $fk_asal_bangsal
 * @property int $fk_tujuan_bangsal
 * @property int $fk_id_kelas
 * @property int $fk_id_kelas_asal
 * @property int $fk_id_kelas_tujuan
 * @property Carbon $waktu_pindah
 * @property int $fk_id_logs
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Bangsal $bangsal
 * @property KelasBangsal $kelas_bangsal
 * @property LogsTabelPasien $logs_tabel_pasien
 * @property PasienMasuk $pasien_masuk
 *
 * @package App\Models
 */
class PasienPindah extends Model
{
	protected $table = 'pasien_pindah';
	protected $primaryKey = 'id_pindah';

	protected $casts = [
		'fk_id_pasien_masuk' => 'int',
		'fk_asal_bangsal' => 'int',
		'fk_tujuan_bangsal' => 'int',
		'fk_id_kelas' => 'int',
		'fk_id_kelas_asal' => 'int',
		'fk_id_kelas_tujuan' => 'int',
		'waktu_pindah' => 'datetime',
		'fk_id_logs' => 'int'
	];

	protected $fillable = [
		'fk_id_pasien_masuk',
		'fk_asal_bangsal',
		'fk_tujuan_bangsal',
		'fk_id_kelas_asal',
		'fk_id_kelas_tujuan',
		'waktu_pindah',
		'fk_id_logs'
	];

	public function bangsal_tujuan()
	{
		return $this->belongsTo(Bangsal::class, 'fk_tujuan_bangsal');
	}

	public function bangsal_asal()
	{
		return $this->belongsTo(Bangsal::class, 'fk_asal_bangsal');
	}

	public function kelas_bangsal_asal()
	{
		return $this->belongsTo(KelasBangsal::class, 'fk_id_kelas_asal');
	}

	public function kelas_bangsal_tujuan()
	{
		return $this->belongsTo(KelasBangsal::class, 'fk_id_kelas_tujuan');
	}

	public function logs_tabel_pasien()
	{
		return $this->belongsTo(LogsTabelPasien::class, 'fk_id_logs');
	}

	public function pasien_masuk()
	{
		return $this->belongsTo(PasienMasuk::class, 'fk_id_pasien_masuk');
	}

	public function pasien_keluar()
	{
		return $this->belongsTo(PasienKeluar::class, 'fk_id_pasien_masuk');
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

	public function scopeWithBangsalAsal($query)
	{
		return $query->with('bangsal_asal');
	}

	public function scopeWithBangsalTujuan($query)
	{
		return $query->with('bangsal_tujuan');
	}
}
