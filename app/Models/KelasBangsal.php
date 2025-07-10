<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Class KelasBangsal
 * 
 * @property int $id_kelas
 * @property string $nama_kelas
 * @property string|null $jenis_kelas
 * @property int $jumlah_tempat_tidur
 * @property int $fk_kd_bangsal
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Bangsal $bangsal
 * @property Collection|PasienMasuk[] $pasien_masuks
 * @property Collection|PasienPindah[] $pasien_pindahs
 *
 * @package App\Models
 */
class KelasBangsal extends Model
{
	// update total tempat tidur semua bangsal ketika kelas bangsal diupdate
	protected static function boot()
    {
        parent::boot();

		static::created(function ($kelasBangsal) {
			static::updateTotalTempatTidur();

			// log info
			Log::info('event create', $kelasBangsal->toArray());
		});
		
		static::updated(function ($kelasBangsal) {
			static::updateTotalTempatTidur();

			// log info
			Log::info('event update', $kelasBangsal->toArray());
		});
    }

	protected static function updateTotalTempatTidur() {	
		// Ambil semua Bangsal yang ada
		$bangsals = Bangsal::all();

		foreach ($bangsals as $bangsal) {
			// Hitung ulang total tempat tidur untuk setiap Bangsal
			$totalTempatTidur = KelasBangsal::where('fk_kd_bangsal', $bangsal->kd_bangsal)->sum('jumlah_tempat_tidur');
	
			Log::info("Mengupdate total tempat tidur untuk Bangsal ID: " . $bangsal->kd_bangsal . " dengan nilai: " . $totalTempatTidur);
	
			// Perbarui total tempat tidur di Bangsal
			$bangsal->update(['total_tempat_tidur' => $totalTempatTidur]);
		}
	}
	
	protected $table = 'kelas_bangsal';
	protected $primaryKey = 'id_kelas';

	protected $casts = [
		'jumlah_tempat_tidur' => 'int',
		'fk_kd_bangsal' => 'int'
	];

	protected $fillable = [
		'nama_kelas',
		'jenis_kelas',
		'jumlah_tempat_tidur',
		'fk_kd_bangsal'
	];

	public function bangsal()
	{
		return $this->belongsTo(Bangsal::class, 'fk_kd_bangsal');
	}

	public function pasien_masuks()
	{
		return $this->hasMany(PasienMasuk::class, 'fk_id_kelas');
	}

	public function pasien_pindahs()
	{
		return $this->hasMany(PasienPindah::class, 'fk_id_kelas');
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
