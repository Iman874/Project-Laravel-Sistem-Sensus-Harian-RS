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
 * Class KepalaInstalasi
 * 
 * @property int $id_kepala_instalasi
 * @property string $username
 * @property string $password
 * @property string $nama
 * @property string $gelar
 * @property string $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class KepalaInstalasi extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'kepala_instalasi';
    protected $primaryKey = 'username';
    public $incrementing = false;

    protected $casts = [
        'id_kepala_instalasi' => 'int'
    ];

    protected $hidden = ['password'];

    protected $fillable = [
        'id_kepala_instalasi',
        'password',
        'nama',
        'gelar',
        'role'
    ];
}