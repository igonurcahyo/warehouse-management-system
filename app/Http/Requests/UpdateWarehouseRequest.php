<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage warehouses');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('warehouses')->ignore($this->route('warehouse')),
            ],
            'location' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0'],
        ];
    }
}
