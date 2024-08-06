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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desginers_id');
            $table->string('nm_produk');
            $table->string('type');
            $table->string('size');
            $table->string('warna');
            $table->string('brand')->nullable();
            $table->integer('stock');
            $table->double('harga');
            $table->double('harga_next');
            $table->text('deskripsi_singkat');
            $table->longText('deskripsi');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
