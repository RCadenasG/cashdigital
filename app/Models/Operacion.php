<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operacion extends Model
{
    use HasFactory;

    protected $table = 'operaciones';

    protected $fillable = [
        'cliente_id',
        'user_id',
        'tipo_pago',
        'servicio',
        'monto_pago',
        'monto_comision',
        'fecha',
        'hora',
    ];

    protected $casts = [
        'monto_pago' => 'decimal:2',
        'monto_comision' => 'decimal:2',
        'fecha' => 'date',
        'hora' => 'datetime:H:i',
        'cliente_id' => 'integer',
        'user_id' => 'integer',
        'tipo_pago' => 'integer',
        'servicio' => 'integer',
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parametroServicio()
    {
        return $this->belongsTo(Parametro::class, 'servicio');
    }

    // Accessors
    public function getTipoPagoNombreAttribute(): string
    {
        return match($this->tipo_pago) {
            1 => 'Pago de Servicio',
            2 => 'Transferencia',
            default => 'Desconocido'
        };
    }

    public function getServicioNombreAttribute(): ?string
    {
        if ($this->tipo_pago === 1 && $this->parametroServicio) {
            return $this->parametroServicio->descripcion_corta;
        }
        return null;
    }

    public function getMontoTotalAttribute(): float
    {
        return $this->monto_pago + $this->monto_comision;
    }

    // Scopes
    public function scopeFiltrarPorFecha($query, $fechaInicio, $fechaFin)
    {
        if ($fechaInicio && $fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query;
    }

    public function scopeFiltrarPorTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo_pago', $tipo);
        }
        return $query;
    }

    public function scopeFiltrarPorCliente($query, $clienteId)
    {
        if ($clienteId) {
            return $query->where('cliente_id', $clienteId);
        }
        return $query;
    }
}
