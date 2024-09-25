<?php

namespace App\Filament\Resources\DatasaranaResource\Pages;

use App\Filament\Resources\DatasaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDatasaranas extends ListRecords
{
    protected static string $resource = DatasaranaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->visible(fn () => auth()->user()->hasAnyRole(['super_admin', 'panel_user'])),
        ];
    }
}
