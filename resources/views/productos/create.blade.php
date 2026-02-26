<x-app-layout>
<div class="p-6 max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Crear Producto</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('productos.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-medium mb-1">Categoría</label>
            <select name="categoria_id"
                class="w-full border rounded p-2"
                required>
                <option value="">Seleccione</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Nombre</label>
            <input type="text"
                name="nombre"
                class="w-full border rounded p-2"
                required>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Precio</label>
            <input type="number"
                step="0.01"
                name="precio"
                class="w-full border rounded p-2"
                required>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Stock</label>
            <input type="number"
                name="stock"
                min="0"
                class="w-full border rounded p-2"
                required>
        </div>

        <div class="mb-6">
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="activo" value="1" checked>
                <span>Activo</span>
            </label>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('productos.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
               Cancelar
            </a>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Guardar
            </button>
        </div>

    </form>

</div>
</x-app-layout>
