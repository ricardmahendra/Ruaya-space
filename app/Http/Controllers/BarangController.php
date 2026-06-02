<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use App\Models\Kategori;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%'.$request->search.'%')
                ->orWhere('kode_barang', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('export')) {
            $barangs = $query->orderBy('nama_barang')->get();

            $filename = 'barang-export-'.now()->format('Y-m-d').'.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function () use ($barangs) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Kode Barang', 'Nama Barang', 'Kategori', 'Stock', 'Satuan', 'Reorder Point', 'Status', 'Deskripsi']);

                foreach ($barangs as $barang) {
                    fputcsv($file, [
                        $barang->kode_barang,
                        $barang->nama_barang,
                        $barang->kategori?->nama_kategori,
                        $barang->stok,
                        $barang->satuan,
                        $barang->reorder_point,
                        $barang->status_stok,
                        $barang->deskripsi,
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $barangs = $query->orderBy('nama_barang')->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('barangs.index', compact('barangs', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('barangs.create', compact('kategoris'));
    }

    public function store(StoreBarangRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('barangs', 'public');
        }

        $barang = Barang::create($data);
        ActivityLogService::log('CREATE', "Menambahkan barang {$barang->nama_barang}", Barang::class, $barang->id);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('barangs.edit', compact('barang', 'kategoris'));
    }

    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('barangs', 'public');
        }

        $barang->update($data);
        ActivityLogService::log('UPDATE', "Memperbarui barang {$barang->nama_barang}", Barang::class, $barang->id);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->stokMasuks()->exists() || $barang->stokKeluars()->exists()) {
            return back()->with('error', 'Barang tidak dapat dihapus karena memiliki riwayat stok.');
        }

        Storage::disk('public')->delete($barang->gambar);
        $barang->delete();
        ActivityLogService::log('DELETE', "Menghapus barang {$barang->nama_barang}", Barang::class, $barang->id);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function detail(Barang $barang)
    {
        $barang->load('kategori', 'stokMasuks', 'stokKeluars', 'fifoHistories');
        return view('barangs.detail', compact('barang'));
    }

    public function searchApi(Request $request)
    {
        $items = Barang::where('nama_barang', 'like', '%'.$request->get('q').'%')
            ->orWhere('kode_barang', 'like', '%'.$request->get('q').'%')
            ->limit(10)
            ->get(['id', 'nama_barang', 'kode_barang', 'stok']);

        return response()->json($items);
    }
}
