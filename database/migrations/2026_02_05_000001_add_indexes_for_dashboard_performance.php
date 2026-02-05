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
        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->index(['status', 'area_parkir_id']);
            $table->index(['status', 'waktu_masuk']);
            $table->index(['status', 'waktu_keluar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_transaksi', function (Blueprint $table) {
            $table->dropIndex(['status', 'area_parkir_id']);
            $table->dropIndex(['status', 'waktu_masuk']);
            $table->dropIndex(['status', 'waktu_keluar']);
        });
    }
};
