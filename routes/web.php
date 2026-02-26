<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CajaController;
Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

//Route::middleware(['auth'])->get('/dashboard', function () {
//    return view('dashboard');
// })->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
# PROTEGER RUTAS ADMINISTRADOR
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
#PROTECCION RUTAS VENDEDOR
Route::middleware(['auth', 'role:vendedor'])->group(function () {
    Route::get('/vendedor', function () {
        return view('vendedor.dashboard');
    })->name('vendedor.dashboard');
});
# Redireccionamento automatico
Route::get('/redirect', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('vendedor.dashboard');
});
# RUTAS crud

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('mesas', MesaController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {    
    Route::resource('categorias', CategoriaController::class);
    Route::resource('productos', ProductoController::class);
});

# PRUEBA ROLES
Route::get('/test-role', function () {
    return 'OK ROLE';
})->middleware('role:admin');


require __DIR__.'/auth.php';

#ruta pedido

Route::middleware('auth')->group(function () {
    Route::post('/mesas/{mesa}/abrir', 
        [PedidoController::class, 'store']
    )->name('pedidos.abrir');
    Route::get('/pedidos/{pedido}', 
        [PedidoController::class, 'show']
    )->name('pedidos.show');
    Route::post('/pedidos/{pedido}/cerrar', 
        [PedidoController::class, 'cerrar']
    )->name('pedidos.cerrar');

});
# ruta Peditos

Route::post('/pedidos/{pedido}/agregar-producto',
    [PedidoController::class, 'agregarProducto']
)->name('pedidos.agregarProducto');

#RUTA DETALLE PEDIDO

Route::post('/detalle/{detalle}/actualizar',
    [PedidoController::class, 'actualizarDetalle']
)->name('detalle.actualizar');

Route::delete('/detalle/{detalle}',
    [PedidoController::class, 'eliminarDetalle']
)->name('detalle.eliminar');

#ruta Comprobante CERRAR PEDIDO - PDF
Route::get('/pedidos/{pedido}/comprobante',
    [PedidoController::class, 'comprobante']
)->name('pedidos.comprobante');

#RUTA DE CAJAS

Route::middleware('auth')->group(function () {
    Route::get('/caja', [CajaController::class, 'index'])->name('caja.index');
    Route::post('/caja/abrir', [CajaController::class, 'abrir'])->name('caja.abrir');
    Route::post('/caja/cerrar/{caja}', [CajaController::class, 'cerrar'])->name('caja.cerrar');
});

# Ruta usuario
Route::resource('usuarios', UserController::class)->middleware('auth');