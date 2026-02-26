<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante</title>
    <style>
        body { font-family: DejaVu Sans; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>

    <h2>Comprobante de Pedido</h2>

    <p><strong>Pedido #:</strong> {{ $pedido->id }}</p>
    <p><strong>Mesa:</strong> {{ $pedido->mesa->numero }}</p>
    <p><strong>Fecha:</strong> {{ $pedido->created_at }}</p>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cant</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Bs {{ number_format($detalle->precio_unitario,2) }}</td>
                    <td>Bs {{ number_format($detalle->subtotal,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="margin-top:15px;">
        Total: Bs {{ number_format($pedido->total,2) }}
    </h3>

</body>
</html>