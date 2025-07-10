<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelRS extends Model
{
    protected $fillable = [
        'tanggal',
        'BOR',
        'LOS',
        'TOI',
        'BTO',
    ];
    protected $table = 'model_rs';

}
