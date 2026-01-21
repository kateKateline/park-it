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
        Schema::create('tb_deteksi_ai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->nullable()->constrained('tb_transaksi');
            $table->string('plat_terdeteksi')->nullable();
            $table->string('warna_terdeteksi')->nullable();
            $table->string('sumber')->comment('yolo / plate_recognizer');
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
