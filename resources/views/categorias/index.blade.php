<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold mb-4">Categorías</h1>

<a href="{{ route('categorias.create') }}"
class="bg-blue-600 text-white px-4 py-2 rounded">
Nueva Categoría
</a>

<table class="w-full mt-4">
<thead>
<tr class="border-b">
<th>Nombre</th>

<th>Acciones</th>
</tr>
</thead>
<tbody>
@foreach($categorias as $categoria)
<tr class="border-b">
<td>{{ $categoria->nombre }}</td>
<td>
<a class="bg-green-600 text-white  rounded" href="{{ route('categorias.edit',$categoria) }}">Editar</a>
</td>
</tr>
@endforeach
</tbody>
</table>

</div>
</x-app-layout>