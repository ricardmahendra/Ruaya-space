<?php

namespace App\Exports;

use App\Models\StokMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StokMasukExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return StokMasuk::with(['barang', 'supplier', 'user'])->get()->map(function ($item) {
            return [
                'Tanggal Masuk' => $item->tanggal_masuk->format('Y-m-d'),
                'Barang' => $item->barang?->nama_barang,
                'Supplier' => $item->supplier?->nama_supplier,
                'Jumlah' => $item->jumlah,
                'Batch Code' => $item->batch_code,
                'User' => $item->user?->name,
            ];
        });
    }

    public function headings(): array
    {
        return ['Tanggal Masuk', 'Barang', 'Supplier', 'Jumlah', 'Batch Code', 'User'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
