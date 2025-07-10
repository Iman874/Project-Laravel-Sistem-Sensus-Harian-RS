<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LogsTabelPasien
 * 
 * @property int $id_logs
 * @property string $action
 * @property string $role
 * @property string $id_role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|PasienKeluar[] $pasien_keluars
 * @property Collection|PasienMasuk[] $pasien_masuks
 * @property Collection|PasienPindah[] $pasien_pindahs
 *
 * @package App\Models
 */
class LogsTabelPasien extends Model
{
	protected $table = 'logs_tabel_pasien';
	protected $primaryKey = 'id_logs';

	protected $fillable = [
		'action',
		'role',
		'id_role',
	];

	public function pasien_keluars()
	{
		return $this->hasMany(PasienKeluar::class, 'fk_id_logs');
	}

	public function pasien_masuks()
	{
		return $this->hasMany(PasienMasuk::class, 'fk_id_logs');
	}

	public function pasien_pindahs()
	{
		return $this->hasMany(PasienPindah::class, 'fk_id_logs');
	}
}
