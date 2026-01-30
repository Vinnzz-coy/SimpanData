<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')
                ->constrained('peserta')
                ->cascadeOnDelete();
            $table->string('file_path')->nullable();
            $table->date('diarsipkan_pada');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique('peserta_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};
