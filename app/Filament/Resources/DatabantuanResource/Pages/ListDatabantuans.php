<?php

namespace App\Filament\Resources\DatabantuanResource\Pages;

use App\Filament\Resources\DatabantuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDatabantuans extends ListRecords
{
    protected static string $resource = DatabantuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->visible(fn () => auth()->user()->hasAnyRole(['super_admin', 'panel_user'])),
        ];
    }
}
