<?php

namespace App\Exports;

use App\Models\StokKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StokKeluarExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return StokKeluar::with(['barang', 'user'])->get()->map(function ($item) {
            return [
                'Tanggal Keluar' => $item->tanggal_keluar->format('Y-m-d'),
                'Barang' => $item->barang?->nama_barang,
                'Jumlah' => $item->jumlah,
                'Tujuan' => $item->tujuan_penggunaan,
                'User' => $item->user?->name,
            ];
        });
    }

    public function headings(): array
    {
        return ['Tanggal Keluar', 'Barang', 'Jumlah', 'Tujuan', 'User'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
