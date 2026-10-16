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
        Schema::create('jadwal_pembayarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')
                  ->constrained('peminjamans')
                  ->onDelete('cascade');

            $table->integer('angsuran_ke'); // 1, 2, 3, ...
            $table->decimal('jumlah_angsuran', 15, 2);
            $table->date('tanggal_jatuh_tempo');

            $table->enum('status', ['belum_bayar', 'sebagian', 'lunas', 'terlambat'])
                  ->default('belum_bayar');

            $table->foreignId('pembayaran_id')
                  ->nullable()
                  ->constrained('pembayarans')
                  ->nullOnDelete();

            $table->timestamps();

            $table->unique(['peminjaman_id', 'angsuran_ke']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pembayarans');
    }
};
