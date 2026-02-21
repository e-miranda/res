<x-app-layout title="Crear Mesa">
    <h1 class="text-xl font-bold mb-4">Nueva Mesa</h1>

    <form method="POST" action="{{ route('mesas.update', $mesa) }} "
          class="bg-white p-4 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <input name="numero" placeholder="Número" value="{{ $mesa->numero }}" 
               class="w-full border p-2 rounded">
        <input name="capacidad" type="number" placeholder="Capacidad" value="{{ $mesa->capacidad }}" 
               class="w-full border p-2 rounded">
        <select name="estado">
            <option value="libre">Libre</option>
            <option value="ocupada">Ocupada</option>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Guardar
        </button>
    </form>
</x-app-layout>
