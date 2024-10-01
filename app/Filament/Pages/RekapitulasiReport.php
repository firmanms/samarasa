<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanRekapitulasiExport;

class RekapitulasiReport extends Page
{
    use Forms\Concerns\InteractsWithForms;

    use AuthorizesRequests;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $title = 'Laporan Rekapitulasi';

    protected static ?string $navigationLabel = 'Penerima Bantuan Rekap';

    protected static ?string $modelLabel = 'Penerima Bantuan Rekap';

    protected static ?string $pluralLabel = 'Penerima Bantuan Rekap';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.rekapitulasi-report';

    public function submit(): \Symfony\Component\HttpFoundation\BinaryFileResponse
{
    $currentDate = now()->format('d-m-Y');

    // Generate the filename with the current date
    $filename = "laporanpenerimabantuanrekap_{$currentDate}.xlsx";

    return Excel::download(new LaporanRekapitulasiExport, $filename);
}
}
