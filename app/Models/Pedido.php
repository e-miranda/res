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
    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
    public function recalcularTotal()
    {
        $this->update([
            'total' => $this->detalles()->sum('subtotal')
        ]);
    }
    public function getTieneProductosAttribute(){
        return $this->detalles()->exists();
    }
    

}
