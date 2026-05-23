<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStokMasukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'harga_beli' => 'required|numeric|min:0',
            'batch_code' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ];
    }
}
