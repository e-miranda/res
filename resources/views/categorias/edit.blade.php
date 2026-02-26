<x-app-layout>
<div class="p-6 max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Editar Categoría</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('categorias.update', $categoria) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium mb-1">Nombre</label>
            <input type="text"
                name="nombre"
                value="{{ old('nombre', $categoria->nombre) }}"
                class="w-full border rounded p-2"
                required>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Descripción</label>
            <textarea name="descripcion"
                class="w-full border rounded p-2"
                rows="3">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        </div>

        <div class="mb-6">
            <label class="flex items-center space-x-2">
                <input type="checkbox"
                    name="activa"
                    value="1"
                    {{ $categoria->activa ? 'checked' : '' }}>
                <span>Activa</span>
            </label>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('categorias.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
               Cancelar
            </a>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Actualizar
            </button>
        </div>

    </form>

</div>
</x-app-layout>
