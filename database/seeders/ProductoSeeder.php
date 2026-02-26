<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::insert([
            ['categoria_id' => 1, 'nombre' => 'medio', 'precio_venta' => 25.00, 'costo' => 15.00],
            ['categoria_id' => 1, 'nombre' => 'completo', 'precio_venta' => 35.00, 'costo' => 25.00],
            ['categoria_id' => 1, 'nombre' => 'coca cola', 'precio_venta' => 18.00, 'costo' => 10.00],
        ]);
    }
}
