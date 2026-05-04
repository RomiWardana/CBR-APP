<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kasus_gejala', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kasus_id')
                ->constrained('kasus')
                ->onDelete('cascade');

            $table->foreignId('gejala_id')
                ->constrained('gejala')
                ->onDelete('cascade');

            $table->float('bobot')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasus_gejala');
    }
};