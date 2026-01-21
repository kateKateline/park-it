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
        Schema::create('tb_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor')->unique();
            $table->string('warna')->nullable();
            $table->string('jenis_kendaraan'); // mobil, motor
            $table->string('merk')->nullable();
            $table->string('pemilik')->nullable(); // untuk parkir terintegrasi
            $table->boolean('is_terdaftar')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
