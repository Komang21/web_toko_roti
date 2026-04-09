<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add columns to produks
        Schema::table('produks', function (Blueprint $table) {
            $table->string('nama');
            $table->decimal('harga_jual', 10, 2);
            $table->integer('stok')->default(0);
        });

        // Add columns to bahan_bakus
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->string('nama');
            $table->integer('stok')->default(0);
            $table->decimal('harga', 10, 2);
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
        });

        // Add columns to pembelians 
        Schema::table('pembelians', function (Blueprint $table) {
            $table->date('tgl_pembelian');
            $table->decimal('total', 10, 2)->default(0);
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
        });

        // PembelianDetail table
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained()->onDelete('cascade');
            $table->foreignId('bahan_id')->constrained('bahan_bakus')->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('harga', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        // PenjualanDetail table
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained()->onDelete('cascade');
            $table->foreignId('produk_id')->constrained()->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('harga', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelian_details');
        Schema::dropIfExists('penjualan_details');
        
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['nama', 'harga_jual', 'stok']);
        });
        
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->dropColumn(['nama', 'stok', 'harga', 'supplier_id']);
        });
        
        Schema::table('pembelians', function (Blueprint $table) {
            $table->dropColumn(['tgl_pembelian', 'total', 'supplier_id']);
        });
    }
};

