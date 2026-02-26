<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Mesa;
use App\Models\PedidoDetalle;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();

        // Ventas hoy

        $ventasHoy=0;
        $ventasMes=0;
        $pedidosAbiertos=0;
        $mesasOcupadas =0;
        $topProductos=0;
        $ventasSemana =0;
        $ventasHoy = Pedido::where('estado','cerrado')
            ->whereDate('created_at', $hoy)
            ->sum('total');

        // Ventas mes
        $ventasMes = Pedido::where('estado','cerrado')
            ->whereBetween('created_at', [$inicioMes, now()])
            ->sum('total');

        // Pedidos abiertos
        $pedidosAbiertos = Pedido::where('estado','abierto')->count();

        // Mesas ocupadas
        $mesasOcupadas = Mesa::where('estado','ocupada')->count();

        // Top productos
        $topProductos = PedidoDetalle::select(
                'producto_id',
                DB::raw('SUM(cantidad) as total_vendido')
            )
            ->with('producto')
            ->groupBy('producto_id')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        // Ventas últimos 7 días
        $ventasSemana = Pedido::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('SUM(total) as total')
            )
            ->where('estado','cerrado')
            ->where('created_at','>=', now()->subDays(7))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return view('dashboard', compact(
            'ventasHoy',
            'ventasMes',
            'pedidosAbiertos',
            'mesasOcupadas',
            'topProductos',
            'ventasSemana',
        ));
    }
}

