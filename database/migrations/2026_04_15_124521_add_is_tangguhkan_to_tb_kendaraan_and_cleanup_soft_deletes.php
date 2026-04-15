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
        Schema::table('tb_kendaraan', function (Blueprint $table) {
            $table->boolean('is_tangguhkan')->default(false)->after('is_terdaftar');
            
            // Hapus soft deletes column jika ada
            if (Schema::hasColumn('tb_kendaraan', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_kendaraan', function (Blueprint $table) {
            $table->dropColumn('is_tangguhkan');
            $table->softDeletes();
        });
    }
};
