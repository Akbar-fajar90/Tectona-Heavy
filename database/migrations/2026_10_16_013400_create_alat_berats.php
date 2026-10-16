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
        Schema::create('alat_berats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->string('kode_alat')->unique();
            $table->string('merk');
            $table->year('tahun_pembuatan');
            $table->integer('stok_unit');
            $table->enum('status', ['tersedia', 'tidak tersedia'])->default('tersedia');
            $table->enum('kondisi', ['baik', 'rusak', 'perbaikan'])->default('baik');
            $table->decimal('harga_sewa', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_berats');
    }
};
