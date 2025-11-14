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

// Rutas de health check
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});

Route::get('/up', function () {
    return response('ok', 200);
});

Route::get('/test', function () {
    return response()->json(['message' => 'Test OK', 'app' => 'CashDigital']);
});

Route::get('/debug', function () {
    try {
        return response()->json([
            'php' => phpversion(),
            'laravel' => app()->version(),
            'db' => DB::connection()->getPdo() ? 'Connected' : 'Not connected',
            'storage_writable' => is_writable(storage_path()),
            'app_key' => config('app.key') ? 'Set' : 'Not set',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});

Route::get('/test-view', function () {
    try {
        return view('welcome');
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'View error',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => explode("\n", $e->getTraceAsString())
        ], 500);
    }
});

Route::get('/test-auth-view', function () {
    try {
        // Verificar que el layout existe
        if (!view()->exists('layouts.guest')) {
            return response()->json(['error' => 'Layout layouts.guest no existe']);
        }

        // Verificar componentes
        $components = ['input-label', 'text-input', 'input-error', 'primary-button', 'auth-session-status'];
        foreach ($components as $component) {
            if (!view()->exists("components.$component")) {
                return response()->json(['error' => "Componente components.$component no existe"]);
            }
        }

        return view('auth.login');
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => array_slice(explode("\n", $e->getTraceAsString()), 0, 10)
        ], 500);
    }
});

Route::get('/simple-login', function () {
    return <<<'HTML'
    <!DOCTYPE html>
    <html>
    <head>
        <title>CashDigital - Login</title>
        <style>
            body { font-family: Arial; max-width: 400px; margin: 50px auto; padding: 20px; }
            input { width: 100%; padding: 10px; margin: 10px 0; }
            button { width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        </style>
    </head>
    <body>
        <h2>CashDigital Login</h2>
        <form method="POST" action="/login">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Log in</button>
        </form>
    </body>
    </html>
    HTML;
});

// Ruta raíz
Route::get('/', function () {
    return response()->json([
        'status' => 'online',
        'app' => 'CashDigital',
        'version' => '1.0.0',
        'endpoints' => [
            'login' => url('/login'),
            'dashboard' => url('/dashboard'),
            'health' => url('/health'),
        ]
    ], 200);
});
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
