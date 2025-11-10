<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'name',
        'email',
        'telefono',
        'direccion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'integer',
    ];

    public function isActivo(): bool
    {
        return $this->estado === 1;
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }
}
