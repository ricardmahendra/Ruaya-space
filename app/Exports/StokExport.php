<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StokExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Barang::with('kategori')->get()->map(function ($barang) {
            return [
                'Kode Barang' => $barang->kode_barang,
                'Nama Barang' => $barang->nama_barang,
                'Kategori' => $barang->kategori?->nama_kategori,
                'Stok' => $barang->stok,
                'Reorder Point' => $barang->reorder_point,
                'Status' => $barang->status_stok,
            ];
        });
    }

    public function headings(): array
    {
        return ['Kode Barang', 'Nama Barang', 'Kategori', 'Stok', 'Reorder Point', 'Status'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
