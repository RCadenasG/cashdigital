<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->integer('tipo_pago')->default(0)->comment('1=Servicio, 2=Transferencia');
            $table->integer('servicio')->nullable();
            $table->decimal('monto_pago', 7, 2)->default(0.00);
            $table->decimal('monto_comision', 7, 2)->default(0.00);
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->timestamps();

            // Índices para mejorar rendimiento
            $table->index('cliente_id');
            $table->index('user_id');
            $table->index('tipo_pago');
            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operaciones');
    }
};
