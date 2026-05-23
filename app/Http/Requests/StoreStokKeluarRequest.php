<?php

namespace App\Http\Requests;

use App\Models\Barang;
use Illuminate\Foundation\Http\FormRequest;

class StoreStokKeluarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $stok = Barang::find($this->input('barang_id'))?->stok ?? 0;
                    if ($value > $stok) {
                        $fail("Stok tidak mencukupi. Stok tersedia: {$stok}");
                    }
                },
            ],
            'tanggal_keluar' => 'required|date',
            'tujuan_penggunaan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ];
    }
}
