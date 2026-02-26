<x-app-layout>
<div class="p-6">

<h1 class="text-2xl font-bold mb-6">Sistema de Caja</h1>

@if($cajaActiva)

<div class="bg-green-100 p-4 rounded mb-6">
    <p><strong>Caja Abierta</strong></p>
    <p>Apertura: Bs {{ $cajaActiva->monto_apertura }}</p>
    <p>Fecha: {{ $cajaActiva->fecha_apertura }}</p>
</div>

<form method="POST" action="{{ route('caja.cerrar',$cajaActiva) }}">
    @csrf
    <input type="number" step="0.01" name="monto_cierre"
        placeholder="Monto contado en caja"
        class="border p-2 rounded w-full mb-4" required>

    <button class="bg-red-600 text-white px-4 py-2 rounded">
        Cerrar Caja
    </button>
</form>

@else

<form method="POST" action="{{ route('caja.abrir') }}">
    @csrf
    <input type="number" step="0.01" name="monto_apertura"
        placeholder="Monto inicial"
        class="border p-2 rounded w-full mb-4" required>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Abrir Caja
    </button>
</form>

@endif

<hr class="my-8">

<h2 class="text-xl font-bold mb-4">Historial</h2>

<table class="w-full">
<thead>
<tr class="border-b">
<th>ID</th>
<th>Apertura</th>
<th>Ventas</th>
<th>Cierre</th>
<th>Diferencia</th>
<th>Estado</th>
</tr>
</thead>
<tbody>
@foreach($historial as $c)
<tr class="border-b">
<td>{{ $c->id }}</td>
<td>{{ $c->monto_apertura }}</td>
<td>{{ $c->ventas_sistema }}</td>
<td>{{ $c->monto_cierre }}</td>
<td>{{ $c->diferencia }}</td>
<td>{{ $c->estado }}</td>
</tr>
@endforeach
</tbody>
</table>

</div>
</x-app-layout>