<?php

namespace App\Filament\Resources\AlatBerats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;

class AlatBeratsTable
{
    public static function configure(Table $table): Table
    {
         return $table
        ->columns([
            ImageColumn::make('foto')
                ->label('Foto')
                ->disk('public')
                ->visibility('public')
                ->height(200)
                ->width('100%')
                ->extraImgAttributes(['class' => 'object-cover rounded-lg']),

            TextColumn::make('nama_alat')
                ->label('Nama Alat')
                ->searchable()
                ->sortable()
                ->weight('bold')
                ->size('lg'),

            TextColumn::make('merk')
                ->label('Merk')
                ->searchable(),

            TextColumn::make('kategori.nama')
                ->label('Kategori')
                ->badge()
                ->sortable(),

            TextColumn::make('tahun_pembuatan')
                ->label('Tahun')
                ->sortable(),

            TextColumn::make('harga_sewa')
                ->label('Harga Sewa')
                ->money('IDR')
                ->sortable(),

            TextColumn::make('stok_unit')
                ->label('Stok')
                ->suffix(' unit')
                ->sortable(),

            TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'tersedia' => 'success',
                    'tidak tersedia' => 'danger',
                    default => 'gray',
                }),

            TextColumn::make('kondisi')
                ->label('Kondisi')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'baik' => 'success',
                    'rusak' => 'danger',
                    'perbaikan' => 'warning',
                    default => 'gray',
                }),
        ])
        ->defaultSort('nama_alat')
            ->searchOnBlur()
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
