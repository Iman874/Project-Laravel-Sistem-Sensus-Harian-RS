<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PetugasIndikator
 * 
 * @property int $id_petugas
 * @property string $username
 * @property string $password
 * @property string $nama
 * @property string $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PetugasIndikator extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'petugas_indikator';
    protected $primaryKey = 'username';
    public $incrementing = false;

    protected $casts = [
        'id_petugas' => 'int'
    ];

    protected $hidden = ['password'];

    protected $fillable = [
        'id_petugas',
        'password',
        'nama',
        'role'
    ];
}
