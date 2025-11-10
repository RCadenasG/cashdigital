<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono', 9)->nullable()->after('email');
            $table->integer('estado')->nullable()->after('remember_token');
            $table->index('email');
        }); 
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropColumn(['telefono']);
            $table->dropColumn(['estado']);
        });
    }
};
