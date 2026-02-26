<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $fillable = ['user_id',
        'monto_apertura',
        'monto_cierre',
        'ventas_sistema',
        'diferencia',
        'estado',
        'fecha_apertura',
        'fecha_cierre'
        ];

}
