<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peserta_id')
                ->constrained('peserta')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('user')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('kedisiplinan'); // 1-100
            $table->unsignedTinyInteger('keterampilan'); // 1-100
            $table->unsignedTinyInteger('kerjasama'); // 1-100
            $table->unsignedTinyInteger('inisiatif'); // 1-100
            $table->unsignedTinyInteger('komunikasi'); // 1-100
            $table->unsignedTinyInteger('nilai_akhir'); // Rata-rata

            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
