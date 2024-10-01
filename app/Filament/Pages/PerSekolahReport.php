<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPerSekolahExport;
use App\Models\Bantuan; // Import the Sekolah model
use App\Models\Sekolah;

class PerSekolahReport extends Page
{
    use Forms\Concerns\InteractsWithForms;

    use AuthorizesRequests;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $title = 'Laporan Per Sekolah';

    protected static ?string $navigationLabel = 'Penerima Bantuan Per Sekolah';

    protected static ?string $modelLabel = 'Penerima Bantuan Per Sekolah';

    protected static ?string $pluralLabel = 'Penerima Bantuan Per Sekolah';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.per-sekolah-report';

    public $sekolahs_id;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('sekolahs_id')
                    ->label('Sekolah')
                    // ->relationship('sekolah', 'nama_sekolah')
                    ->options(Sekolah::all()->pluck('nama_sekolah', 'id'))
                    ->searchable()
                    // ->disabled(fn ($record) => $record ? $record->exists : false) // Menandai sebagai disabled jika record ada
                    ->preload()
                    ->live()
                    ->required(),
        ];
    }

    public function submit(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Export laporan berdasarkan tahun yang dipilih
        return Excel::download(new LaporanPerSekolahExport($this->sekolahs_id), 'laporan_persekolah.xlsx');
    }

}
