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
        Schema::create('tb_pembayaran', function (Blueprint $table) {
        $table->increments('id'); 
        $table->unsignedInteger('id_pemesanan');
        $table->integer('id_transaksi');
        $table->integer('nominal');
        $table->enum('status_pembayaran', ['pending', 'diterima', 'ditolak']);
        $table->timestamp('dibayar_pada');
        $table->string('kode_qris', 255);
        $table->timestamps();

        // Foreign Key Constraint
        $table->foreign('id_pemesanan')->references('id_pemesanan')->on('tb_pemesanan')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
