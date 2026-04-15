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
        Schema::table('tb_users', function (Blueprint $table) {
            $table->boolean('is_tangguhkan')->default(false)->after('role');
        });

        Schema::table('tb_area_parkir', function (Blueprint $table) {
            $table->boolean('is_tangguhkan')->default(false)->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_users', function (Blueprint $table) {
            $table->dropColumn('is_tangguhkan');
        });

        Schema::table('tb_area_parkir', function (Blueprint $table) {
            $table->dropColumn('is_tangguhkan');
        });
    }
};
