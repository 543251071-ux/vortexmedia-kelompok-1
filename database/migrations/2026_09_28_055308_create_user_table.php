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
        Schema::create('tb_user', function (Blueprint $table) {
        $table->id('id_user'); // INT AUTO_INCREMENT PRIMARY KEY
        $table->string('nama', 40); 
        $table->string('nomor_telepon', 20); // Menggunakan string untuk nomor telepon
        $table->string('email', 40);
        $table->string('password', 255); // Ukuran 255 disarankan untuk hash password
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
