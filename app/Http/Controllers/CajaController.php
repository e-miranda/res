<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Pedido;
use Carbon\Carbon;

class CajaController extends Controller
{
    public function index()
    {
        $cajaActiva = Caja::where('estado','abierta')->first();
        $historial = Caja::latest()->take(10)->get();
        return view('caja.index', compact('cajaActiva','historial'));
    }
    public function abrir(Request $request)
    {
        if (Caja::where('estado','abierta')->exists()) {
            return back()->with('error','Ya existe una caja abierta.');
        }

        Caja::create([
            'user_id' => auth()->id(),
            'monto_apertura' => $request->monto_apertura,
            'fecha_apertura' => now(),
            'estado' => 'abierta'
        ]);

        return back()->with('success','Caja abierta correctamente.');
    }
    public function cerrar(Request $request, Caja $caja)
    {
        $ventasSistema = Pedido::where('estado','cerrado')
            ->whereBetween('created_at', [$caja->fecha_apertura, now()])
            ->sum('total');
        $diferencia = $request->monto_cierre - 
                      ($caja->monto_apertura + $ventasSistema);
        $caja->update([
            'monto_cierre' => $request->monto_cierre,
            'ventas_sistema' => $ventasSistema,
            'diferencia' => $diferencia,
            'estado' => 'cerrada',
            'fecha_cierre' => now()
        ]);
        return back()->with('success','Caja cerrada correctamente.');
    }

}