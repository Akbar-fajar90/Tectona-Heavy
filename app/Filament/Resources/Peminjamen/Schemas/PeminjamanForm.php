<?php

namespace App\Filament\Resources\Peminjamen\Schemas;
use App\Models\AlatBerat;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;



class PeminjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Alat Berat')
                ->schema([
                    Select::make('alat_berat_id')
                        ->label('Alat')
                        ->relationship('alatBerat', 'nama_alat')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            $alat = AlatBerat::find($state);
                            if ($alat) {
                                $set('total_harga', $alat->harga_sewa * ($get('durasi_hari') ?? 1));
                            }
                        }),

                    DatePicker::make('tanggal_pinjam')
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::hitungTotal($get, $set)),

                    DatePicker::make('tanggal_kembali')
                        ->required()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::hitungTotal($get, $set)),

                    TextInput::make('durasi_hari')
                        ->numeric()
                        ->disabled()
                        ->dehydrated(),
                ])->columns(2),

            Section::make('Pengiriman')
                ->schema([
                    Textarea::make('alamat_pengiriman')
                        ->required()
                        ->default(fn () => Auth::user()?->alamat)
                        ->columnSpanFull(),

                    Textarea::make('catatan_peminjam')
                        ->columnSpanFull(),
                ]),

            Section::make('Skema Pembayaran')
                ->schema([
                    Select::make('skema_pembayaran')
                        ->options([
                            'lunas'   => 'Lunas',
                            'dp'      => 'DP',
                            '50_50'   => '50% Awal - 50% Akhir',
                            'cicilan' => 'Cicilan',
                        ])
                        ->default('lunas')
                        ->required()
                        ->live(),

                    TextInput::make('jumlah_dp')
                        ->numeric()
                        ->prefix('Rp')
                        ->visible(fn (Get $get) => in_array($get('skema_pembayaran'), ['dp', '50_50', 'cicilan']))
                        ->required(fn (Get $get) => in_array($get('skema_pembayaran'), ['dp', '50_50', 'cicilan'])),

                    TextInput::make('jumlah_cicilan')
                        ->numeric()
                        ->visible(fn (Get $get) => $get('skema_pembayaran') === 'cicilan')
                        ->required(fn (Get $get) => $get('skema_pembayaran') === 'cicilan'),

                    TextInput::make('total_harga')
                        ->numeric()
                        ->prefix('Rp')
                        ->disabled()
                        ->dehydrated(),
                ])->columns(2),
        ]);
    }

    protected static function hitungTotal(Get $get, Set $set): void
    {
        $pinjam   = $get('tanggal_pinjam');
        $kembali  = $get('tanggal_kembali');
        $alat     = AlatBerat::find($get('alat_berat_id'));

        if (!$pinjam || !$kembali || !$alat) {
            return;
        }

        $durasi = \Carbon\Carbon::parse($pinjam)->diffInDays(\Carbon\Carbon::parse($kembali)) + 1;
        $set('durasi_hari', $durasi);
        $set('total_harga', $alat->harga_sewa * $durasi);

    }
}
