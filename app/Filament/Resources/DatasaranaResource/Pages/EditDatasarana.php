<?php

namespace App\Filament\Resources\DatasaranaResource\Pages;

use App\Filament\Resources\DatasaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDatasarana extends EditRecord
{
    protected static string $resource = DatasaranaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->visible(fn () => auth()->user()->hasAnyRole(['super_admin', 'panel_user'])),
        ];
    }
}
