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
        Schema::create('tb_komputer', function (Blueprint $table) {
            $table->increments('id_komputer'); // INT AUTO_INCREMENT PRIMARY KEY
            $table->integer('nomor_komputer');
            $table->string('spek_komputer', 255);
            $table->enum('status_komputer', ['dipakai', 'kosong', 'dipesan', 'maintenance']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_komputer');
    }
};