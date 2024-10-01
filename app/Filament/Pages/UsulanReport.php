<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanUsulanExport;

class UsulanReport extends Page
{
    use Forms\Concerns\InteractsWithForms;

    use AuthorizesRequests;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $title = 'Laporan Usulan';

    protected static ?string $navigationLabel = 'Usulan';

    protected static ?string $modelLabel = 'Usulan';

    protected static ?string $pluralLabel = 'Usulan';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.usulan-report';

    public $tahun;

    public $status;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('tahun')
                ->label('Pilih Tahun')
                ->options($this->getAvailableYears())
                ->required(),
            Forms\Components\Select::make('status')
                ->label('Pilih Status')
                ->options([
                    'Pending' => 'Pending',
                    'Proses' => 'Proses',
                    'Diterima' => 'Diterima',
                    'Ditolak' => 'Ditolak',
                ])
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
        return Excel::download(new LaporanUsulanExport($this->tahun, $this->status), 'laporan_usulan_tahun' . $this->tahun . '_usulan_'. $this->status .'.xlsx');
    }
}
