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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->foreignId('users_id');
            $table->foreignId('products_id');
            $table->integer('rents_index')->nullable();
            $table->string('size')->nullable();
            $table->integer('qty')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('jasa_kirim')->nullable();
            $table->string('pembayaran')->nullable();
            $table->string('catatan')->nullable();
            $table->double('total')->nullable();
            $table->enum('status', ['pending', 'paid', 'sent'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
