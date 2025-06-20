<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exames', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('laterality', ['OD', 'OE', 'AO'])->nullable();
            $table->string('comment');
            $table->enum('group', ['Individual', 'Grupo 1', 'Grupo 2', 'Grupo 3', 'Grupo 4', 'Grupo 5']);
            $table->timestamps();
        });

        Schema::create('pacotes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('observations')->nullable();
            $table->timestamps();
        });

        Schema::create('exame_pacote', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idExame')->constrained('exames')->onDelete('cascade');
            $table->foreignId('idPacote')->constrained('pacotes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exame_pacote');
        Schema::dropIfExists('pacotes');
        Schema::dropIfExists('exames');
    }
};
