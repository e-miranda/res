<x-app-layout>
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    {{-- MÉTRICAS PRINCIPALES --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white shadow p-4 rounded">
            <p class="text-gray-500">Ventas Hoy</p>
            <h2 class="text-2xl font-bold text-green-600">
                Bs {{ number_format($ventasHoy,2) }}
            </h2>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <p class="text-gray-500">Ventas Mes</p>
            <h2 class="text-2xl font-bold text-blue-600">
                Bs {{ number_format($ventasMes,2) }}
            </h2>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <p class="text-gray-500">Pedidos Abiertos</p>
            <h2 class="text-2xl font-bold text-yellow-600">
                {{ $pedidosAbiertos }}
            </h2>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <p class="text-gray-500">Mesas Ocupadas</p>
            <h2 class="text-2xl font-bold text-red-600">
                {{ $mesasOcupadas }}
            </h2>
        </div>

    </div>

    {{-- TOP PRODUCTOS --}}
    <div class="mt-8 bg-white shadow p-6 rounded">
        <h2 class="text-xl font-bold mb-4">Top 5 Productos</h2>

        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th>Producto</th>
                    <th>Cantidad Vendida</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProductos as $item)
                    <tr class="border-b">
                        <td>{{ $item->producto->nombre }}</td>
                        <td>{{ $item->total_vendido }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>