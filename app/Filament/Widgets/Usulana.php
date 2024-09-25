<?php

namespace App\Filament\Widgets;

use App\Models\Usulan as Usulan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Usulana extends BaseWidget
{
    public function getTitle(): string
    {
        return 'Statistik Usulan';
    }

    public function getUsulanData()
    {
        return Usulan::all();;
    }
    protected function getStats(): array
    {
        $usulanData = $this->getUsulanData();
        //dd($usulanData);
        $totalPending=$usulanData->where('status','pending')->count();
        $totalProses=$usulanData->where('status','process')->count();
        $totalDiterima=$usulanData->where('status','success')->count();
        $totalDitolak=$usulanData->where('status','danger')->count();
        return [
            Stat::make('Usulan Pending', $totalPending),
            Stat::make('Usulan Proses', $totalProses),
            Stat::make('Usulan Diterima', $totalDiterima),
            Stat::make('Usulan Ditolak', $totalDitolak),
        ];
    }
}
