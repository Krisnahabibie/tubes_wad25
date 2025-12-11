<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('judul_promo')->unique();
            $table->text('deskripsi_promo');
            $table->string('gambar_promo')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->decimal('diskon_persen', 5, 2); // Contoh: 15.00 untuk diskon 15%
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
