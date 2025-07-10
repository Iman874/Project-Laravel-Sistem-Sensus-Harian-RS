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
 * Class Perawat
 * 
 * @property int $id_perawat
 * @property string $username
 * @property string $password
 * @property string $nama
 * @property string $jenis_kelamin
 * @property string $penempatan
 * @property string $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Perawat extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'perawat';
    protected $primaryKey = 'id_perawat';

    protected $hidden = [
        'password'
    ];

    protected $fillable = [
        'username',
        'password',
        'nama',
        'jenis_kelamin',
        'penempatan',
        'role'
    ];
}