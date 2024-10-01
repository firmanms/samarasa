<?php

namespace App\Exports;

use App\Models\Bantuan;
use App\Models\Sekolah;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanRekapitulasiExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $index = 0; // Menyimpan nomor urut

    public function collection()
    {
        // Mendapatkan tahun saat ini
    $currentYear = date('Y')+1;
    // Membuat array tahun dari tahun sekarang hingga 10 tahun ke belakang
    $years = range($currentYear, $currentYear - 10);

    // Mulai query
    $query = Sekolah::leftJoin('bantuans', 'sekolahs.id', '=', 'bantuans.sekolahs_id')
        ->leftJoin('databantuans', 'bantuans.databantuans_id', '=', 'databantuans.id')
        ->whereIn('sekolahs.bentuk', ['KB', 'SPS', 'TK', 'TPA', '-']) // Memfilter kategori
        ->select(
            'sekolahs.nama_sekolah',
            'sekolahs.npsn',
            'sekolahs.bentuk',
            'sekolahs.kecamatan'
        );

    // Menambahkan kolom untuk setiap tahun
    foreach ($years as $year) {
        $query->addSelect(DB::raw('GROUP_CONCAT(CASE WHEN bantuans.tahun = ' . $year . ' THEN databantuans.nama_bantuan END) AS `Tahun ' . $year . '`'));
    }

    // Menyelesaikan query
    return $query
        ->groupBy('sekolahs.id', 'sekolahs.nama_sekolah', 'sekolahs.npsn', 'sekolahs.bentuk', 'sekolahs.kecamatan')
        ->orderBy('sekolahs.nama_sekolah') // Mengurutkan berdasarkan nama sekolah
        ->get();
    }

    public function headings(): array
{
    // Mendapatkan tahun saat ini
    $currentYear = date('Y')+1;
    // Membuat array tahun dari tahun sekarang hingga 10 tahun ke belakang
    $years = range($currentYear, $currentYear - 10);

    // Membuat array heading
    $headings = [
        'No',
        'Nama Satuan Pendidikan',
        'NPSN',
        'Bentuk',
        'Kecamatan',
    ];

    // Menambahkan tahun ke heading
    foreach ($years as $year) {
        $headings[] = 'Tahun ' . $year;
    }

    return $headings;
}
public function map($model): array
{
    $this->index++; // Menambah nomor urut setiap kali data dimapping

    // Mendapatkan tahun saat ini
    $currentYear = date('Y')+1;
    // Membuat array tahun dari tahun sekarang hingga 10 tahun ke belakang
    $years = range($currentYear, $currentYear - 10);

    $data = [
        $this->index, // Nomor urut yang ter-generate
        $model->nama_sekolah ?? '',
        $model->npsn ?? '',
        $model->bentuk_pendidikan ?? '',
        $model->kecamatan ?? '',
    ];

    // Mengambil data bantuan per tahun
    foreach ($years as $year) {
        $data[] = $model->{'Tahun ' . $year} ?? '';
    }

    return $data;
}
}
