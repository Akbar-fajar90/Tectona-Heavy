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
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JadwalPembayaransRelationManager extends RelationManager
{
    protected static string $relationship = 'jadwalPembayarans';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('angsuran_ke')
                    ->required()
                    ->numeric(),
                TextInput::make('jumlah_angsuran')
                    ->required()
                    ->numeric(),
                DatePicker::make('tanggal_jatuh_tempo')
                    ->required(),
                Select::make('status')
                    ->options([
            'belum_bayar' => 'Belum bayar',
            'sebagian' => 'Sebagian',
            'lunas' => 'Lunas',
            'terlambat' => 'Terlambat',
        ])
                    ->default('belum_bayar')
                    ->required(),
                Select::make('pembayaran_id')
                    ->relationship('pembayaran', 'id')
                    ->default(null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('angsuran_ke')
            ->columns([
                TextColumn::make('angsuran_ke')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah_angsuran')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tanggal_jatuh_tempo')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('pembayaran.id')
                    ->searchable(),
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
