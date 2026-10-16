<?php

namespace App\Filament\Resources\AlatBerats\Pages;

use App\Filament\Resources\AlatBerats\AlatBeratResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAlatBerat extends EditRecord
{
    protected static string $resource = AlatBeratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
