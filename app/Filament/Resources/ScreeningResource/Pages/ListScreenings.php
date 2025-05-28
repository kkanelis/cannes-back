<?php

namespace App\Filament\Resources\ScreeningResource\Pages;

use App\Filament\Resources\ScreeningResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScreenings extends ListRecords
{
    protected static string $resource = ScreeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
