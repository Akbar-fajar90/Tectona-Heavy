<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class JadwalPembayaran extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'angsuran_ke',
        'jumlah_angsuran',
        'tanggal_jatuh_tempo',
        'status',
        'pembayaran_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_jatuh_tempo' => 'date',
            'jumlah_angsuran'     => 'decimal:2',
            'angsuran_ke'         => 'integer',
        ];
    }

    // =====================
    // RELASI
    // =====================

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function pembayaran(): BelongsTo
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id');
    }

    // =====================
    // SCOPE
    // =====================

    public function scopeBelumBayar(Builder $query): Builder
    {
        return $query->whereIn('status', ['belum_bayar', 'sebagian']);
    }

    public function scopeTerlambat(Builder $query): Builder
    {
        return $query->where('status', 'belum_bayar')
                     ->where('tanggal_jatuh_tempo', '<', now());
    }
}