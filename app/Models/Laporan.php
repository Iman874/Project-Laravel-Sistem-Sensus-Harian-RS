<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Laporan
 * 
 * @property int $id_laporan
 * @property string $id_petugas
 * @property string $id_kepala_instalasi
 * @property string $nama_laporan
 * @property Carbon $tanggal_kirim
 * @property Carbon $tanggal_dibaca
 * @property string $komentar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Laporan extends Model
{
	protected $table = 'laporan';
	protected $primaryKey = 'id_laporan';

	protected $casts = [
		'tanggal_kirim' => 'datetime',
		'tanggal_dibaca' => 'datetime'
	];

	protected $fillable = [
		'id_petugas',
		'id_kepala_instalasi',
		'nama_laporan',
		'tanggal_kirim',
		'tanggal_dibaca',
		'komentar'
	];
}
