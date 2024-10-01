<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPerJenisBantuanExport;
use App\Models\Databantuan;

class JenisBantuanReport extends Page
{
    use Forms\Concerns\InteractsWithForms;

    use AuthorizesRequests;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $title = 'Laporan Per Jenis Bantuan';

    protected static ?string $navigationLabel = 'Penerima Bantuan Per Jenis Bantuan';

    protected static ?string $modelLabel = 'Penerima Bantuan Per Jenis Bantuan';

    protected static ?string $pluralLabel = 'Penerima Bantuan Per Jenis Bantuan';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.jenis-bantuan-report';

    public $databantuans_id;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('databantuans_id')
                    ->label('Jenis Bantuan')
                    // ->relationship('sekolah', 'nama_sekolah')
                    ->options(Databantuan::all()->pluck('nama_bantuan', 'id'))
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
        return Excel::download(new LaporanPerJenisBantuanExport($this->databantuans_id), 'laporan_perjenisbantuan.xlsx');
    }

}
