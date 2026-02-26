
<x-app-layout>

    <h2 class="text-2xl font-bold mb-4">
        Pedido - Mesa {{ $pedido->mesa->numero }}
    </h2>

    {{-- FORMULARIO AGREGAR PRODUCTO --}}
    @if($pedido->estado === 'abierto')
        <div class="bg-white p-4 rounded shadow mb-6">

            <form method="POST" action="{{ route('pedidos.agregarProducto', $pedido) }}">
                @csrf

                <div class="grid grid-cols-3 gap-4">

                    <div>
                        <label class="block text-sm font-medium">Producto</label>
                        <select name="producto_id"
                                class="w-full border rounded p-2"
                                required>
                            <option value="">Seleccionar...</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">
                                    {{ $producto->nombre }} - Bs {{ number_format($producto->precio_venta,2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Cantidad</label>
                        <input type="number"
                               name="cantidad"
                               min="1"
                               max="{{ $producto->stock }}"
                               value="1"
                               class="w-full border rounded p-2"
                               required>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded w-full">
                            Agregar
                        </button>
                    </div>

                </div>
            </form>

        </div>
    @endif

    @if($pedido->estado === 'abierto')
        <form method="POST" action="{{ route('pedidos.cerrar', $pedido) }}">
            @csrf
            <button class="bg-red-600 text-white px-4 py-2 rounded">
                Cerrar Pedido
            </button>
        </form>
    @endif


    {{-- TABLA DETALLE --}}
    <div class="bg-white p-4 rounded shadow">

        <table class="w-full text-left">
            <thead class="border-b">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedido->detalles as $detalle)
                    <tr class="border-b">
                        <td>{{ $detalle->producto->nombre }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>Bs {{ number_format($detalle->precio_unitario,2) }}</td>
                        <td>Bs {{ number_format($detalle->subtotal,2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            No hay productos agregados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-right mt-4">
            <h3 class="text-xl font-bold">
                Total: Bs {{ number_format($pedido->total,2) }}
            </h3>
        </div>

    </div>

</x-app-layout>