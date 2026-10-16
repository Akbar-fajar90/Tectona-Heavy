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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('alat_berat_id')
                  ->constrained('alat_berats')
                  ->onDelete('restrict');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('restrict');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->integer('durasi_hari'); 

            $table->enum('skema_pembayaran', ['lunas', 'dp', 'cicilan', '50_50'])
                  ->default('lunas');
            $table->decimal('total_harga', 15, 2);
            $table->decimal('jumlah_dp', 15, 2)->nullable(); 
            $table->integer('jumlah_cicilan')->nullable(); 

            $table->enum('status', ['proses', 'disetujui', 'dipinjam', 'ditolak', 'dibatalkan', 'selesai'])
                  ->default('proses');
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'tanggal_pinjam']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
