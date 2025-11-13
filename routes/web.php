<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Livewire\ParametrosIndex;
use App\Livewire\ParametrosForm;
use App\Livewire\UsuariosIndex;
use App\Livewire\UsuariosForm;
use App\Livewire\RolesIndex;
use App\Livewire\RolesForm;
use App\Livewire\ClientesIndex;
use App\Livewire\ClientesForm;
use App\Livewire\OperacionesIndex;
use App\Livewire\OperacionesForm;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProfileController;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('parametros')->name('parametros.')->group(function () {
        Route::get('/', ParametrosIndex::class)->name('index');
        Route::get('/crear', ParametrosForm::class)->name('create');
        Route::get('/{id}/editar', ParametrosForm::class)->name('edit');
    });

    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', UsuariosIndex::class)->name('index');
        Route::get('/crear', UsuariosForm::class)->name('create');
        Route::get('/{id}/editar', UsuariosForm::class)->name('edit');
    });

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', RolesIndex::class)->name('index');
        Route::get('/create', RolesForm::class)->name('create');
        Route::get('/{id}/edit', RolesForm::class)->name('edit');
    });

    Route::prefix('clientes')->name('clientes.')->group(function () {
        Route::get('/', ClientesIndex::class)->name('index');
        Route::get('/crear', ClientesForm::class)->name('create');
        Route::get('/{id}/editar', ClientesForm::class)->name('edit');
        Route::get('/{id}', function($id) {
            $cliente = \App\Models\Cliente::findOrFail($id);
            return view('clientes.show', compact('cliente'));
        })->name('show');
    });

    Route::prefix('operaciones')->name('operaciones.')->group(function () {
        Route::get('/', OperacionesIndex::class)->name('index');
        Route::get('/crear', OperacionesForm::class)->name('create');
        Route::get('/{id}/editar', OperacionesForm::class)->name('edit');
        Route::get('/{id}', function($id) {
            $operacion = \App\Models\Operacion::with(['cliente', 'usuario', 'parametroServicio'])->findOrFail($id);
            return view('operaciones.show', compact('operacion'));
        })->name('show');
    });

    Route::prefix('exportar')->name('export.')->group(function () {
        Route::get('parametros/excel', [ExportController::class, 'parametrosExcel'])->name('parametros.excel');
        Route::get('parametros/pdf', [ExportController::class, 'parametrosPdf'])->name('parametros.pdf');
        Route::get('usuarios/excel', [ExportController::class, 'usuariosExcel'])->name('usuarios.excel');
        Route::get('usuarios/pdf', [ExportController::class, 'usuariosPdf'])->name('usuarios.pdf');
        Route::get('clientes/excel', [ExportController::class, 'clientesExcel'])->name('clientes.excel');
        Route::get('clientes/pdf', [ExportController::class, 'clientesPdf'])->name('clientes.pdf');
        Route::get('operaciones/excel', [ExportController::class, 'operacionesExcel'])->name('operaciones.excel');
        Route::get('operaciones/pdf', [ExportController::class, 'operacionesPdf'])->name('operaciones.pdf');
    });

    Route::get('/dbtest', function () {
        try {
            DB::connection()->getPdo();
            return '✅ Conexión a base de datos exitosa';
        } catch (\Exception $e) {
            return '❌ Error de conexión: ' . $e->getMessage();
        }
    });
});

require __DIR__.'/auth.php';
