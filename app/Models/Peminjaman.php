<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Peminjaman extends Model
{
    protected $fillable = [
        'alat_berat_id',
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'durasi_hari',
        'skema_pembayaran',
        'total_harga',
        'jumlah_dp',
        'jumlah_cicilan',
        'status',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam'  => 'date',
            'tanggal_kembali' => 'date',
            'durasi_hari'     => 'integer',
            'total_harga'     => 'decimal:2',
            'jumlah_dp'       => 'decimal:2',
            'jumlah_cicilan'  => 'integer',
        ];
    }

    // =====================
    // RELASI
    // =====================

    public function alatBerat(): BelongsTo
    {
        return $this->belongsTo(AlatBerat::class, 'alat_berat_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'peminjaman_id');
    }

    public function jadwalPembayarans(): HasMany
    {
        return $this->hasMany(JadwalPembayaran::class, 'peminjaman_id');
    }

    // =====================
    // SCOPE
    // =====================

    public function scopeProses(Builder $query): Builder
    {
        return $query->where('status', 'proses');
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->whereIn('status', ['disetujui', 'dipinjam']);
    }

    public function scopeSelesai(Builder $query): Builder
    {
        return $query->where('status', 'selesai');
    }

    // =====================
    // HELPER
    // =====================

    public function totalDibayar(): float
    {
        return (float) $this->pembayarans()
                            ->where('status', 'terverifikasi')
                            ->sum('jumlah_bayar');
    }

    public function sisaTagihan(): float
    {
        return (float) $this->total_harga - $this->totalDibayar();
    }

    public function isLunas(): bool
    {
        return $this->sisaTagihan() <= 0;
    }
}