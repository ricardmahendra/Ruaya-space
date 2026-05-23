<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->paginate(12);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
        ]);

        $supplier = Supplier::create($data);
        ActivityLogService::log('CREATE', "Menambahkan supplier {$supplier->nama_supplier}", Supplier::class, $supplier->id);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
        ]);

        $supplier->update($data);
        ActivityLogService::log('UPDATE', "Memperbarui supplier {$supplier->nama_supplier}", Supplier::class, $supplier->id);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        ActivityLogService::log('DELETE', "Menghapus supplier {$supplier->nama_supplier}", Supplier::class, $supplier->id);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
