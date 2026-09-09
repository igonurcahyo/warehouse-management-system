<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage inventory');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'warehouse_id' => [
                'required',
                'integer',
                'exists:warehouses,id',
                Rule::unique('inventory')
                    ->where('product_id', $this->product_id)
                    ->ignore($this->route('inventory')),
            ],
            'quantity' => ['required', 'integer', 'min:0'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'warehouse_id.unique' => 'Produk ini sudah ada di gudang yang dipilih.',
        ];
    }
}
