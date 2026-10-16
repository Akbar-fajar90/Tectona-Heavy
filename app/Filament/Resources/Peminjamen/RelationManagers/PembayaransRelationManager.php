<?php

namespace App\Filament\Resources\Peminjamen\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PembayaransRelationManager extends RelationManager
{
    protected static string $relationship = 'pembayarans';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis_pembayaran')
                    ->options(['dp' => 'Dp', 'cicilan' => 'Cicilan', 'pelunasan' => 'Pelunasan'])
                    ->required(),
                TextInput::make('angsuran_ke')
                    ->numeric()
                    ->default(null),
                TextInput::make('jumlah_bayar')
                    ->required()
                    ->numeric(),
                DatePicker::make('tanggal_bayar')
                    ->required(),
                Select::make('metode_bayar')
                    ->options(['tunai' => 'Tunai', 'transfer' => 'Transfer', 'qris' => 'Qris'])
                    ->default('transfer')
                    ->required(),
                TextInput::make('bukti_bayar')
                    ->default(null),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'terverifikasi' => 'Terverifikasi', 'ditolak' => 'Ditolak'])
                    ->default('pending')
                    ->required(),
                TextInput::make('verified_by')
                    ->numeric()
                    ->default(null),
                Textarea::make('catatan')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('jenis_pembayaran')
            ->columns([
                TextColumn::make('jenis_pembayaran')
                    ->badge(),
                TextColumn::make('angsuran_ke')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah_bayar')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tanggal_bayar')
                    ->date()
                    ->sortable(),
                TextColumn::make('metode_bayar')
                    ->badge(),
                TextColumn::make('bukti_bayar')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('verified_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
