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
        Schema::table('alat_berats', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('nama_alat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alat_berats', function (Blueprint $table) {
                    $table->dropColumn('foto');
        });
    }
};
