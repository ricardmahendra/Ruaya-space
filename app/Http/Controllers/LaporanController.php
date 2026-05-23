<?php

namespace App\Http\Controllers;

use App\Exports\StokExport;
use App\Exports\StokKeluarExport;
use App\Exports\StokMasukExport;
use App\Models\Barang;
use App\Models\FifoHistory;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function stok(Request $request)
    {
        $barangs = Barang::with('kategori')
            ->when($request->filled('date_from'), fn($query) => $query->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($query) => $query->whereDate('created_at', '<=', $request->date_to))
            ->paginate(12);

        return view('laporan.stok', compact('barangs'));
    }

    public function masuk(Request $request)
    {
        $stokMasuks = StokMasuk::with(['barang', 'supplier', 'user'])
            ->when($request->filled('date_from'), fn($query) => $query->whereDate('tanggal_masuk', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($query) => $query->whereDate('tanggal_masuk', '<=', $request->date_to))
            ->orderBy('tanggal_masuk', 'desc')
            ->paginate(12);

        return view('laporan.masuk', compact('stokMasuks'));
    }

    public function keluar(Request $request)
    {
        $stokKeluars = StokKeluar::with('barang', 'user')
            ->when($request->filled('date_from'), fn($query) => $query->whereDate('tanggal_keluar', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($query) => $query->whereDate('tanggal_keluar', '<=', $request->date_to))
            ->orderBy('tanggal_keluar', 'desc')
            ->paginate(12);

        return view('laporan.keluar', compact('stokKeluars'));
    }

    public function fifo(Request $request)
    {
        $histories = FifoHistory::with(['barang', 'stokMasuk', 'stokKeluar'])
            ->orderBy('tanggal_pengambilan', 'desc')
            ->paginate(12);

        return view('laporan.fifo', compact('histories'));
    }

    public function menipis(Request $request)
    {
        $barangs = Barang::with('kategori')
            ->whereColumn('stok', '<=', 'reorder_point')
            ->paginate(12);

        return view('laporan.menipis', compact('barangs'));
    }

    public function exportPdf(string $type, Request $request)
    {
        $data = $this->getDataLaporan($type, $request);
        $view = view("laporan.pdf.{$type}", $data);

        if (! class_exists(Pdf::class)) {
            return back()->with('error', 'Ekspor PDF memerlukan paket barryvdh/laravel-dompdf.');
        }

        $pdf = Pdf::loadView("laporan.pdf.{$type}", $data);
        return $pdf->download("laporan-{$type}-".now()->format('Y-m-d').'.pdf');
    }

    public function exportExcel(string $type, Request $request)
    {
        if (! class_exists(Excel::class)) {
            return back()->with('error', 'Ekspor Excel memerlukan paket maatwebsite/excel.');
        }

        return Excel::download($this->getExportClass($type), "laporan-{$type}-".now()->format('Y-m-d').'.xlsx');
    }

    protected function getDataLaporan(string $type, Request $request): array
    {
        return match ($type) {
            'stok' => ['barangs' => Barang::with('kategori')->get()],
            'masuk' => ['stokMasuks' => StokMasuk::with(['barang', 'supplier', 'user'])->get()],
            'keluar' => ['stokKeluars' => StokKeluar::with(['barang', 'user'])->get()],
            'fifo' => ['histories' => FifoHistory::with(['barang', 'stokMasuk', 'stokKeluar'])->get()],
            'menipis' => ['barangs' => Barang::with('kategori')->whereColumn('stok', '<=', 'reorder_point')->get()],
            default => ['barangs' => Barang::take(0)->get()],
        };
    }

    protected function getExportClass(string $type)
    {
        return match ($type) {
            'stok' => new StokExport,
            'masuk' => new StokMasukExport,
            'keluar' => new StokKeluarExport,
            default => new StokExport,
        };
    }
}
