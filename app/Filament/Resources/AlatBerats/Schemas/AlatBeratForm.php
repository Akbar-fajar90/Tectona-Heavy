<?php

namespace App\Filament\Resources\AlatBerats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class AlatBeratForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_alat')
                    ->required(),
                FileUpload::make('foto')
                ->label('Foto Alat Berat')
                ->image()
                ->disk('public')
                ->directory('alat-berat/foto')
                ->visibility('public')
                ->imageEditor()
                ->maxSize(5120) 
                ->columnSpanFull(),
                Select::make('kategori_id')
                    ->relationship('kategori', 'id')
                    ->required(),
                TextInput::make('kode_alat')
                    ->required(),
                TextInput::make('merk')
                    ->required(),
                TextInput::make('tahun_pembuatan')
                    ->required(),
                TextInput::make('stok_unit')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['tersedia' => 'Tersedia', 'tidak tersedia' => 'Tidak tersedia'])
                    ->default('tersedia')
                    ->required(),
                Select::make('kondisi')
                    ->options(['baik' => 'Baik', 'rusak' => 'Rusak', 'perbaikan' => 'Perbaikan'])
                    ->default('baik')
                    ->required(),
                TextInput::make('harga_sewa')
                    ->required()
                    ->numeric(),
            ]);
    }
}
