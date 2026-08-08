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
        Schema::create('stoks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('produk_id')->references('id')->on('produks')->onDelete('cascade');
            $table->enum('type', ['in', 'out']);
            $table->integer('jumlah');
            $table->decimal('harga_modal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};
