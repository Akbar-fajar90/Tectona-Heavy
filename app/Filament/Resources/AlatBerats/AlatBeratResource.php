<?php

namespace App\Filament\Resources\AlatBerats;

use App\Filament\Resources\AlatBerats\Pages\CreateAlatBerat;
use App\Filament\Resources\AlatBerats\Pages\EditAlatBerat;
use App\Filament\Resources\AlatBerats\Pages\ListAlatBerats;
use App\Filament\Resources\AlatBerats\Schemas\AlatBeratForm;
use App\Filament\Resources\AlatBerats\Tables\AlatBeratsTable;
use App\Models\AlatBerat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AlatBeratResource extends Resource
{
    protected static ?string $model = AlatBerat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $recordTitleAttribute = 'Alat Berat';

    public static function form(Schema $schema): Schema
    {
        return AlatBeratForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlatBeratsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAlatBerats::route('/'),
            'create' => CreateAlatBerat::route('/create'),
            'edit' => EditAlatBerat::route('/{record}/edit'),
        ];
    }
}
