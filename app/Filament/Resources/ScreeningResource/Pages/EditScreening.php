<?php

namespace App\Filament\Resources\ScreeningResource\Pages;

use App\Filament\Resources\ScreeningResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScreening extends EditRecord
{
    protected static string $resource = ScreeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
