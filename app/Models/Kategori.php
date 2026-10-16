<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;



#[Fillable(['nama_kategori'])]
class Kategori extends Model
{
    public function alatBerats(): HasMany
    {
        return $this->hasMany(AlatBerat::class, 'kategori_id');
    }
}
