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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function stok(Request $request)
    {
        $period = $this->resolveReportPeriod($request);

        $barangs = Barang::with('kategori')
            ->withSum(['stokMasuks as total_masuk' => function ($query) use ($period) {
                $query->whereBetween('tanggal_masuk', [$period['from'], $period['to']]);
            }], 'jumlah')
            ->withSum(['stokKeluars as total_keluar' => function ($query) use ($period) {
                $query->whereBetween('tanggal_keluar', [$period['from'], $period['to']]);
            }], 'jumlah')
            ->paginate(12);

        $barangs->getCollection()->transform(function ($barang) {
            $barang->total_masuk = $barang->total_masuk ?: 0;
            $barang->total_keluar = $barang->total_keluar ?: 0;
            $barang->usage_percentage = ($barang->total_masuk + $barang->total_keluar) > 0
                ? round(($barang->total_keluar / ($barang->total_masuk + $barang->total_keluar)) * 100, 2)
                : 0;

            return $barang;
        });

        return view('laporan.stok', [
            'barangs' => $barangs,
            'periodLabel' => $period['label'],
            'selectedMonth' => $period['month'],
            'selectedYear' => $period['year'],
            'dateFrom' => $request->input('date_from'),
            'dateTo' => $request->input('date_to'),
        ]);
    }

    protected function resolveReportPeriod(Request $request): array
    {
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $from = Carbon::createFromFormat('Y-m-d', $request->date_from)->startOfDay();
            $to = Carbon::createFromFormat('Y-m-d', $request->date_to)->endOfDay();

            return [
                'from' => $from,
                'to' => $to,
                'label' => "Periode {$from->format('d/m/Y')} - {$to->format('d/m/Y')}",
                'month' => null,
                'year' => null,
            ];
        }

        $month = preg_match('/^\d{1,2}$/', $request->input('month', '')) ? intval($request->input('month')) : now()->month;
        $year = preg_match('/^\d{4}$/', $request->input('year', '')) ? intval($request->input('year')) : now()->year;
        $month = max(1, min(12, $month));

        $date = Carbon::create($year, $month, 1);

        return [
            'from' => $date->copy()->startOfMonth(),
            'to' => $date->copy()->endOfMonth()->endOfDay(),
            'label' => "Bulan {$date->format('F Y')}",
            'month' => $date->format('m'),
            'year' => $date->format('Y'),
        ];
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
            'stok' => $this->getStokLaporanData($request),
            'masuk' => ['stokMasuks' => StokMasuk::with(['barang', 'supplier', 'user'])->get()],
            'keluar' => ['stokKeluars' => StokKeluar::with(['barang', 'user'])->get()],
            'fifo' => ['histories' => FifoHistory::with(['barang', 'stokMasuk', 'stokKeluar'])->get()],
            'menipis' => ['barangs' => Barang::with('kategori')->whereColumn('stok', '<=', 'reorder_point')->get()],
            default => ['barangs' => Barang::take(0)->get()],
        };
    }

    protected function getStokLaporanData(Request $request): array
    {
        $period = $this->resolveReportPeriod($request);

        $barangs = Barang::with('kategori')
            ->withSum(['stokMasuks as total_masuk' => function ($query) use ($period) {
                $query->whereBetween('tanggal_masuk', [$period['from'], $period['to']]);
            }], 'jumlah')
            ->withSum(['stokKeluars as total_keluar' => function ($query) use ($period) {
                $query->whereBetween('tanggal_keluar', [$period['from'], $period['to']]);
            }], 'jumlah')
            ->get();

        $barangs->transform(function ($barang) {
            $barang->total_masuk = $barang->total_masuk ?: 0;
            $barang->total_keluar = $barang->total_keluar ?: 0;
            $barang->usage_percentage = ($barang->total_masuk + $barang->total_keluar) > 0
                ? round(($barang->total_keluar / ($barang->total_masuk + $barang->total_keluar)) * 100, 2)
                : 0;

            return $barang;
        });

        return [
            'barangs' => $barangs,
            'periodLabel' => $period['label'],
        ];
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
