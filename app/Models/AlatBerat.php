<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;


#[Fillable(['nama_alat',
        'foto',
        'kategori_id',
        'kode_alat',
        'merk',
        'tahun_pembuatan',
        'stok_unit',
        'status',
        'kondisi',
        'harga_sewa',])]
class AlatBerat extends Model
{
    protected function casts(): array
    {
        return [
            'tahun_pembuatan' => 'integer',
            'stok_unit'       => 'integer',
            'harga_sewa'      => 'decimal:2',
        ];
    }


        public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'alat_berat_id');
    }

    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('status', 'tersedia')
                     ->where('stok_unit', '>', 0)
                     ->where('kondisi', 'baik');
    }

    public function scopeTidakTersedia(Builder $query): Builder
    {
        return $query->where('status', 'tidak tersedia');
    }

        public function isTersedia(): bool
    {
        return $this->status === 'tersedia'
            && $this->stok_unit > 0
            && $this->kondisi === 'baik';
    }
}
