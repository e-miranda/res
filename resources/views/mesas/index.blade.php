<x-app-layout>
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Mesas</h1>

        <a href="{{ route('mesas.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Nueva Mesa
        </a>
    </div>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Número</th>
                <th class="p-3">Capacidad</th>
                <th class="p-3">Estado</th>
                <th class="p-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mesas as $mesa)
            <tr class="border-t">
                <td class="p-3">{{ $mesa->numero }}</td>
                <td class="p-3">{{ $mesa->capacidad }}</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded text-white
                        {{ $mesa->estado === 'libre' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ ucfirst($mesa->estado) }}
                    </span>
                </td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('mesas.edit', $mesa) }}"
                       class="text-blue-600">Editar</a>
                
                    @if($mesa->estado === 'libre')
                        <form method="POST" action="{{ route('pedidos.abrir', $mesa) }}">
                            @csrf
                            <button class="bg-green-600 text-white px-2 py-1 rounded">
                                Abrir Pedido
                            </button>
                        </form>
                    @else
                        <span class="text-red-600">Ocupada</span>
                    @endif
                </td>


            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
