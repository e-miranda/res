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
        'activo',
        'stock',
    ];
    public function tieneStock($cantidad):bool
    {
        return $this->stock >= $cantidad;
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    //
}
