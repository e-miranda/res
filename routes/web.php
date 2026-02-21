<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use Spatie\Permission\Middleware\RoleMiddleware;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

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
