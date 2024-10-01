<?php

namespace App\Exports;

use App\Models\Usulan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanUsulanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $index = 0; // Menyimpan nomor urut
    protected $tahun;
    protected $status;

    public function __construct($tahun, $status)
    {
        $this->tahun = $tahun;
        $this->status = $status;
    }

    public function collection()
    {
        return Usulan::with(['sekolah', 'databantuan'])
        ->where('tahun', $this->tahun) // Filter berdasarkan tahun
        ->where('status', $this->status) // Filter berdasarkan status
        ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Satuan Pendidikan',
            'NPSN',
            'Bentuk',
            'Kecamatan',
            'Bantuan',
            'Tahun',
            'Sumber Dana',
            'Status',
            'Catatan',
            'Riwayat Bantuan',
            // Tambahkan kolom lain sesuai kebutuhan
        ];
    }

    public function map($model): array
    {
        $this->index++; // Menambah nomor urut setiap kali data dimapping

        return [
            $this->index, // Nomor urut yang ter-generate
            $model->sekolah->nama_sekolah ?? 'N/A',
            $model->sekolah->npsn ?? 'N/A',
            $model->sekolah->bentuk ?? 'N/A',
            $model->sekolah->kecamatan ?? 'N/A',
            $model->databantuan->nama_bantuan ?? 'N/A',
            $model->tahun ?? 'N/A',
            is_array($model->sumberdana) ? implode(', ', $model->sumberdana) : $model->sumberdana ?? 'N/A',
            $model->status ?? 'N/A',
            $model->catatan ?? 'N/A',
            $model->bantuan_list ?? 'N/A',
        ];
    }
}
