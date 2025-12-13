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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('invoice_code')->unique(); // Contoh: INV-202501001
        $table->decimal('total_price', 12, 2);
        // Status pesanan penting untuk Admin Dapur/Kasir
        $table->enum('status', ['pending', 'paid', 'cooking', 'served', 'completed', 'cancelled'])->default('pending');
        $table->timestamps();
        });
        // Tabel detail barang apa saja yang dibeli dalam 1 order
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->integer('quantity');
        $table->decimal('price_at_purchase', 12, 2); // Simpan harga saat beli (jika harga produk berubah nanti, history aman)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
