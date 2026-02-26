<x-app-layout>
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Productos</h1>

        <a href="{{ route('productos.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            Nuevo Producto
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Categoría</th>
                    <th class="p-3">Precio</th>
                    <th class="p-3">Stock</th>
                    <th class="p-3">Estado</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr class="border-b">
                    <td class="p-3">{{ $producto->nombre }}</td>
                    <td class="p-3">
                        {{ $producto->categoria->nombre ?? '—' }}
                    </td>
                    <td class="p-3">Bs {{ number_format($producto->precio_venta,2) }}</td>
                    <td class="p-3">
                        @if($producto->stock > 0)
                            <span class="text-green-600 font-semibold">
                                {{ $producto->stock }}
                            </span>
                        @else
                            <span class="text-red-600 font-bold">
                                Sin stock
                            </span>
                        @endif
                    </td>
                    <td class="p-3">
                        {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                    </td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('productos.edit',$producto) }}"
                           class="bg-blue-600-900 text-black px-3 py-1 rounded">                           
                            Editar
                        </a>

                        <form action="{{ route('productos.destroy',$producto) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded"
                                onclick="return confirm('¿Eliminar producto?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>
