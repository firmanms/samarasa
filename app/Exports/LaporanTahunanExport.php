<?php

namespace App\Exports;

use App\Models\Bantuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanTahunanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $index = 0; // Menyimpan nomor urut

    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Bantuan::with(['sekolah', 'databantuan'])
                        ->join('sekolahs', 'bantuans.sekolahs_id', '=', 'sekolahs.id')
                        ->orderBy('bantuans.tahun') // Mengurutkan berdasarkan tahun
                        ->orderBy('sekolahs.nama_sekolah') // Mengurutkan berdasarkan nama sekolah dari relasi
                        ->select('bantuans.*') // Memilih kolom dari tabel utama
                        ->where('bantuans.tahun', $this->tahun)
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
            'Sumber Dana'
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
        ];
    }
}
