<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bangsal
 * 
 * @property int $kd_bangsal
 * @property string $nama_bangsal
 * @property int $total_tempat_tidur
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|KelasBangsal[] $kelas_bangsals
 * @property Collection|PasienMasuk[] $pasien_masuks
 * @property Collection|PasienPindah[] $pasien_pindahs
 *
 * @package App\Models
 */
class Bangsal extends Model
{
	protected $table = 'bangsal';
	protected $primaryKey = 'kd_bangsal';

	protected $casts = [
		'total_tempat_tidur' => 'int'
	];

	protected $fillable = [
		'nama_bangsal',
		'total_tempat_tidur'
	];

	public function kelas_bangsals()
	{
		return $this->hasMany(KelasBangsal::class, 'fk_kd_bangsal', 'kd_bangsal');
	}

	public function pasien_masuks()
	{
		return $this->hasMany(PasienMasuk::class, 'fk_kd_bangsal');
	}

	public function pasien_pindahs()
	{
		return $this->hasMany(PasienPindah::class, 'fk_tujuan_bangsal');
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
}
