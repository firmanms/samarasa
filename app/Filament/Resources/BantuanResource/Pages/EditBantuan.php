<?php

namespace App\Filament\Resources\BantuanResource\Pages;

use App\Filament\Resources\BantuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditBantuan extends EditRecord
{
    protected static string $resource = BantuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->visible(fn () => auth()->user()->hasAnyRole(['super_admin', 'panel_user'])),
        ];
    }

    protected function beforeFill()
    {
        // Asumsikan bahwa pengguna memiliki metode atau properti untuk mendapatkan role
        $roles = Auth::user()->roles->pluck('name'); // Atau metode lain jika berbeda
        $roleNames = $roles->implode(', ');

        // Periksa apakah user yang sedang login memiliki hak akses untuk mengedit usulan
        if (!in_array($roleNames, ['super_admin', 'panel_user'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
