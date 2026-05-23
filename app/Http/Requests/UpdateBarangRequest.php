<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_barang' => 'required|string|unique:barangs,kode_barang,'.$this->route('barang')->id,
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan' => 'required|string|max:50',
            'stok_minimal' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'average_usage' => 'required|numeric|min:0',
            'lead_time' => 'required|integer|min:1',
            'safety_stock' => 'required|integer|min:0',
            'tanggal_expired' => 'nullable|date',
            'lokasi_rak' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ];
    }
}
