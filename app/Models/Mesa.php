<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $fillable = ['numero', 'capacidad', 'estado',];

    public function estaLibre(): bool
    {
        return $this->estado === 'libre';
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function pedidoActivo()
    {
        return $this->hasOne(Pedido::class)
                    ->where('estado', 'abierto');
    }
}