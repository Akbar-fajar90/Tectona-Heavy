<?php

namespace App\Filament\Resources\AlatBerats\Pages;

use App\Filament\Resources\AlatBerats\AlatBeratResource;
use Filament\Resources\Pages\ListRecords;
use Wezlo\FilamentGridList\Concerns\HasGridList;
use Wezlo\FilamentGridList\GridListConfiguration;
class ListAlatBerats extends ListRecords
{
    use HasGridList;

    protected static string $resource = AlatBeratResource::class;

    public function gridList(GridListConfiguration $config): GridListConfiguration
    {
        return $config
            ->gridColumns([
                'default' => 1,
                'sm' => 2,
                'lg' => 3,
                'xl' => 4,
            ])
            ->gap(6)
            ->recordsPerPage(12)
            ->recordsPerPageOptions([12, 24, 48]);
    }
}
