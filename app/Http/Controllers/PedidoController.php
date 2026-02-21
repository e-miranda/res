<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function store(Mesa $mesa)
    {
        // 1️⃣ Validar que la mesa esté libre
        abort_if(!$mesa->estaLibre(), 403, 'Mesa no disponible');

        // 2️⃣ Crear pedido
        $pedido = Pedido::create([
            'mesa_id' => $mesa->id,
            'estado' => 'abierto',
            'total' => 0
        ]);

        // 3️⃣ Cambiar estado mesa
        $mesa->update([
            'estado' => 'ocupada'
        ]);

        return redirect()
            ->route('pedidos.show', $pedido)
            ->with('success', 'Pedido abierto correctamente');
    }

}
