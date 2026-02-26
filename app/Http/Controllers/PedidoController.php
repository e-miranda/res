<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Mesa;
use App\Models\Producto;
use App\Models\PedidoDetalle;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function cerrar(Pedido $pedido)
    {
        abort_if($pedido->estado === 'cerrado', 403);
        $pedido->update(['estado' => 'cerrado']);
        $pedido->mesa->update(['estado' => 'libre']);
        return redirect()->route('pedidos.comprobante', $pedido);
    }
    public function comprobante(Pedido $pedido)
    {
        $pedido->load('mesa', 'detalles.producto');
        $pdf = Pdf::loadView('pedidos.comprobante', compact('pedido'));
        return $pdf->download('comprobante_pedido_'.$pedido->id.'.pdf');
    }

    public function show(Pedido $pedido){
        $productos= Producto::where('activo',true)->get();
        return view('pedidos.show',compact('pedido','productos'));
    
    }

    public function agregarProducto(Request $request, Pedido $pedido)
    {
        abort_if($pedido->estado !== 'abierto', 403);

        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        $cantidad = $request->cantidad;

        // 🔴 Validar stock
        if (!$producto->tieneStock($cantidad)) {
            return back()->withErrors([
                'stock' => 'Stock insuficiente'
            ]);
        }

        $subtotal = $producto->precio_venta * $cantidad;

        PedidoDetalle::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'precio_unitario' => $producto->precio_venta,
            'subtotal' => $subtotal,
        ]);

        // 🔴 Descontar stock
        $producto->decrement('stock', $cantidad);

        $pedido->update([
            'total' => $pedido->detalles()->sum('subtotal')
        ]);

        return back()->with('success', 'Producto agregado');
    }

    public function actualizarDetalle(Request $request, PedidoDetalle $detalle)
    {
        $pedido = $detalle->pedido;

        abort_if($pedido->estado !== 'abierto', 403);

        $nuevaCantidad = (int) $request->cantidad;
        abort_if($nuevaCantidad < 1, 403);

        $diferencia = $nuevaCantidad - $detalle->cantidad;

        $producto = $detalle->producto;

        // 🔴 Si aumenta cantidad
        if ($diferencia > 0) {
            if (!$producto->tieneStock($diferencia)) {
                return back()->withErrors([
                    'stock' => 'Stock insuficiente'
                ]);
            }
            $producto->decrement('stock', $diferencia);
        }

        // 🔴 Si disminuye cantidad
        if ($diferencia < 0) {
            $producto->increment('stock', abs($diferencia));
        }

        $detalle->update([
            'cantidad' => $nuevaCantidad,
            'subtotal' => $detalle->precio_unitario * $nuevaCantidad
        ]);

        $pedido->update([
            'total' => $pedido->detalles()->sum('subtotal')
        ]);

        return back()->with('success', 'Cantidad actualizada');
    }


    public function eliminarDetalle(PedidoDetalle $detalle)
    {
        $pedido = $detalle->pedido;

        abort_if($pedido->estado !== 'abierto', 403);

        // 🔴 Devolver stock
        $detalle->producto->increment('stock', $detalle->cantidad);

        $detalle->delete();

        $pedido->update([
            'total' => $pedido->detalles()->sum('subtotal')
        ]);

        return back()->with('success', 'Producto eliminado');
    }

}
