<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parametro;

class ParametroSeeder extends Seeder
{
    public function run(): void
    {
        $parametros = [
            // Estados
            [
                'tabla' => 'ESTADO',
                'secuencia' => 1,
                'descripcion_corta' => 'ACT',
                'descripcion_larga' => 'Activo',
            ],
            [
                'tabla' => 'ESTADO',
                'secuencia' => 2,
                'descripcion_corta' => 'INA',
                'descripcion_larga' => 'Inactivo',
            ],

            // Servicios
            [
                'tabla' => 'SERVICIOS',
                'secuencia' => 1,
                'descripcion_corta' => 'Luz',
                'descripcion_larga' => 'Servicio de Energía Eléctrica',
            ],
            [
                'tabla' => 'SERVICIOS',
                'secuencia' => 2,
                'descripcion_corta' => 'Agua',
                'descripcion_larga' => 'Servicio de Agua Potable',
            ],
            [
                'tabla' => 'SERVICIOS',
                'secuencia' => 3,
                'descripcion_corta' => 'Internet',
                'descripcion_larga' => 'Servicio de Internet',
            ],
            [
                'tabla' => 'SERVICIOS',
                'secuencia' => 4,
                'descripcion_corta' => 'Teléfono',
                'descripcion_larga' => 'Servicio Telefónico',
            ],
            [
                'tabla' => 'SERVICIOS',
                'secuencia' => 5,
                'descripcion_corta' => 'Cable',
                'descripcion_larga' => 'Servicio de Televisión por Cable',
            ],

            // Comisiones
            [
                'tabla' => 'COMISION',
                'secuencia' => 1,
                'descripcion_corta' => 'SERVICIO',
                'descripcion_larga' => '2.00', // Comisión fija para servicios
            ],
            [
                'tabla' => 'COMISION',
                'secuencia' => 2,
                'descripcion_corta' => 'TRANSFER',
                'descripcion_larga' => '100', // Factor para transferencias
            ],
        ];

        foreach ($parametros as $parametro) {
            Parametro::updateOrCreate(
                [
                    'tabla' => $parametro['tabla'],
                    'secuencia' => $parametro['secuencia']
                ],
                [
                    'descripcion_corta' => $parametro['descripcion_corta'],
                    'descripcion_larga' => $parametro['descripcion_larga']
                ]
            );
        }
    }
}
