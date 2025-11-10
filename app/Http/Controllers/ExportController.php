<?php

namespace App\Http\Controllers;

use App\Exports\ParametrosExport;
use App\Exports\UsuariosExport;
use App\Exports\ClientesExport;
use App\Exports\OperacionesExport;
use App\Models\Parametro;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Operacion;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function parametrosExcel()
    {
        $filename = 'parametros_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new ParametrosExport, $filename);
    }

    public function parametrosPdf()
    {
        $parametros = Parametro::orderBy('id', 'asc')->get();

        $pdf = Pdf::loadView('exports.parametros-pdf', [
            'parametros' => $parametros,
            'fecha' => Carbon::now()->format('d/m/Y H:i:s'),
            'total' => $parametros->count(),
        ]);

        $pdf->setPaper('a4', 'landscape');

        $filename = 'parametros_' . Carbon::now()->format('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function usuariosExcel()
    {
        $filename = 'usuarios_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new UsuariosExport, $filename);
    }

    public function usuariosPdf()
    {
        $usuarios = User::orderBy('id', 'asc')->get();

        $pdf = Pdf::loadView('exports.usuarios-pdf', [
            'usuarios' => $usuarios,
            'fecha' => Carbon::now()->format('d/m/Y H:i:s'),
            'total' => $usuarios->count(),
        ]);

        $pdf->setPaper('a4', 'landscape');

        $filename = 'usuarios_' . Carbon::now()->format('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function clientesExcel()
    {
        $filename = 'clientes_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new ClientesExport, $filename);
    }

    public function clientesPdf()
    {
        $clientes = Cliente::orderBy('id', 'asc')->get();

        $pdf = Pdf::loadView('exports.clientes-pdf', [
            'clientes' => $clientes,
            'fecha' => Carbon::now()->format('d/m/Y H:i:s'),
            'total' => $clientes->count(),
        ]);

        $pdf->setPaper('a4', 'landscape');

        $filename = 'clientes_' . Carbon::now()->format('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function operacionesExcel()
    {
        $filename = 'operaciones_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';
        return Excel::download(new OperacionesExport, $filename);
    }

    public function operacionesPdf()
    {
        $operaciones = Operacion::with(['cliente', 'usuario', 'parametroServicio'])
            ->orderBy('fecha', 'desc')
            ->get();

        $pdf = Pdf::loadView('exports.operaciones-pdf', [
            'operaciones' => $operaciones,
            'fecha' => Carbon::now()->format('d/m/Y H:i:s'),
            'total' => $operaciones->count(),
        ]);

        $pdf->setPaper('a4', 'landscape');

        $filename = 'operaciones_' . Carbon::now()->format('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
}
