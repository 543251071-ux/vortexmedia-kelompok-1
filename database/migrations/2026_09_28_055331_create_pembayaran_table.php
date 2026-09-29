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
       Schema::create('tb_pemesanan', function (Blueprint $table) {
        $table->increments('id_pemesanan'); // INT AUTO_INCREMENT PRIMARY KEY
        $table->integer('kode_pemesanan');
        $table->unsignedInteger('id_user'); // Foreign key ke tb_user
        $table->unsignedInteger('computer_id'); // Foreign key ke tb_komputer
        $table->date('tanggal_pemesanan');
        $table->time('waktu_mulai');
        $table->integer('lama_pemesanan');
        $table->time('waktu_akhir');
        $table->integer('nominal');
        $table->enum('status', [
            'belum dibayar', 
            'diterima', 
            'dibatalkan', 
            'selesai'
        ]);
        $table->string('alasan_ditolak', 100)->nullable(); // NULLABLE
        $table->timestamps();

        // Foreign Key Constraints
        $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
        $table->foreign('computer_id')->references('id_komputer')->on('tb_komputer')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
    