<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTahunanExport;
use Illuminate\Contracts\View\View;

class TahunanReport extends Page
{
    use Forms\Concerns\InteractsWithForms;

    use AuthorizesRequests;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $title = 'Laporan Tahunan';

    protected static ?string $navigationLabel = 'Penerima Bantuan Tahunan';

    protected static ?string $modelLabel = 'Penerima Bantuan Tahunan';

    protected static ?string $pluralLabel = 'Penerima Bantuan Tahunan';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tahunan-report';

    public $tahun;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('tahun')
                ->label('Pilih Tahun')
                ->options($this->getAvailableYears())
                ->required(),
        ];
    }

    public function getAvailableYears(): array
    {
        // Buat array tahun dari database atau hardcode rentang tahun.
        $currentYear = date('Y')+1;
        $years = range($currentYear, $currentYear - 10);

        return array_combine($years, $years);
    }

    public function submit(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Export laporan berdasarkan tahun yang dipilih
        return Excel::download(new LaporanTahunanExport($this->tahun), 'laporan_' . $this->tahun . '.xlsx');
    }

    // public function render(): View
    // {
    //     return view('filament.pages.tahunan-report');
    // }


}
