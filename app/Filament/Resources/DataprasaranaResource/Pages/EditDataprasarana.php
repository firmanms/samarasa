<?php

namespace App\Filament\Resources\DataprasaranaResource\Pages;

use App\Filament\Resources\DataprasaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataprasarana extends EditRecord
{
    protected static string $resource = DataprasaranaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->visible(fn () => auth()->user()->hasAnyRole(['super_admin', 'panel_user'])),
        ];
    }
}
