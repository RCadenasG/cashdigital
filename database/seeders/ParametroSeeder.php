<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parametro;

class ParametroSeeder extends Seeder
{
    public function run(): void
    {
        $parametros = [
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
        ];

        foreach ($parametros as $parametro) {
            Parametro::updateOrCreate(
                ['tabla' => $parametro['tabla'],
                'secuencia' => $parametro['secuencia']],
                ['descripcion_corta' => $parametro['descripcion_corta'],
                'descripcion_larga' => $parametro['descripcion_larga']]
            );
        }

    }
}
