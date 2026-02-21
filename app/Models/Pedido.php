<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'mesa_id',
        'estado',
        'total'
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

}
