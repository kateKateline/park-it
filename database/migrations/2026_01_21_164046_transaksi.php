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
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('tb_kendaraan');
            $table->foreignId('area_parkir_id')->constrained('tb_area_parkir');
            $table->foreignId('petugas_id')->constrained('tb_users');

            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable();
            $table->integer('durasi_menit')->nullable();
            $table->integer('total_bayar')->nullable();

            $table->enum('status', ['masuk', 'selesai']);
            $table->enum('metode_pembayaran', ['cash'])->default('cash');

            $table->string('qr_code')->unique();
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
