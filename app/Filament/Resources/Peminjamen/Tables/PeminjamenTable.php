<?php

namespace App\Filament\Resources\Peminjamen\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
class PeminjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
           ->columns([
            TextColumn::make('id')->label('ID')->sortable(),
            TextColumn::make('user.name')->label('Peminjam')->searchable(),
            TextColumn::make('alatBerat.nama_alat')->label('Alat')->searchable(),
            TextColumn::make('tanggal_pinjam')->date('d M Y')->sortable(),
            TextColumn::make('tanggal_kembali')->date('d M Y')->sortable(),
            TextColumn::make('durasi_hari')->label('Hari')->suffix(' hari'),
            TextColumn::make('total_harga')->money('IDR'),
            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state) => match ($state) {
                    'proses'    => 'warning',
                    'disetujui' => 'info',
                    'dipinjam'  => 'primary',
                    'selesai'   => 'success',
                    'ditolak',
                    'dibatalkan' => 'danger',
                }),
        ])
        ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(function ($record): bool {
                        /** @var User $user */
                        $user = Auth::user();
                        return $user->isAdmin()
                            || ($user->isPetugas() && $record->status === 'proses');
                    }),

                Action::make('setujui')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(function ($record): bool {
                        /** @var User $user */
                        $user = Auth::user();
                        return $user->isPetugas() && $record->status === 'proses';
                    })
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $record->update([
                            'status'      => 'disetujui',
                            'approved_by' => Auth::id(),
                        ]);
                        Notification::make()
                            ->title('Peminjaman disetujui')
                            ->success()
                            ->send();
                    }),

                Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(function ($record): bool {
                        /** @var User $user */
                        $user = Auth::user();
                        return $user->isPetugas() && $record->status === 'proses';
                    })
                    ->requiresConfirmation()
                    ->form([
                        Textarea::make('alasan')
                            ->required()
                            ->label('Alasan Penolakan'),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->update([
                            'status'      => 'ditolak',
                            'approved_by' => Auth::id(),
                        ]);
                        Notification::make()
                            ->title('Peminjaman ditolak')
                            ->body($data['alasan'])
                            ->danger()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
