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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')
                  ->constrained('peminjamans')
                  ->onDelete('cascade');

            $table->enum('jenis_pembayaran', ['dp', 'cicilan', 'pelunasan']);
            $table->integer('angsuran_ke')->nullable(); 
            $table->decimal('jumlah_bayar', 15, 2);
            $table->date('tanggal_bayar');
            $table->enum('metode_bayar', ['tunai', 'transfer', 'qris'])
                  ->default('transfer');
            $table->string('bukti_bayar')->nullable(); 

            $table->enum('status', ['pending', 'terverifikasi', 'ditolak'])
                  ->default('pending');
            $table->foreignId('verified_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->index(['peminjaman_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
