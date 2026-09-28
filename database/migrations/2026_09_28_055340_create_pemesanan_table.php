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
        $table->increments('id'); // INT AUTO_INCREMENT PRIMARY KEY
        $table->unsignedInteger('id_pemesanan'); // Foreign key ke tb_pemesanan
        $table->integer('id_transaksi');
        $table->integer('nominal'); // Disesuaikan menjadi integer (sesuai nominal di tb_pemesanan)
        $table->enum('status_pembayaran', ['pending', 'settlement', 'expire', 'cancel']);
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
