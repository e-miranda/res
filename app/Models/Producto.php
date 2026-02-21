<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'categoria_id',
        'nombre',
        'precio_venta',
        'costo',
        'activo'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    //
}
