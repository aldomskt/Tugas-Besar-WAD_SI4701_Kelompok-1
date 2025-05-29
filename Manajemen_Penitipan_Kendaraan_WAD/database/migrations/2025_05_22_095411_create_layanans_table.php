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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->string('jenis_kendaraan');
            $table->integer('harga_motor');
            $table->integer('harga_mobil');
            $table->integer('harga')->storedAs('CASE 
                WHEN jenis_kendaraan = "motor" THEN harga_motor 
                WHEN jenis_kendaraan = "mobil" THEN harga_mobil 
                ELSE 0 END');
            $table->string('durasi');
            $table->text('deskripsi');
            $table->string('status')->default('aktif');
            $table->foreignId('penjaga_id')->constrained('penjagas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
