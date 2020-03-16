<?php

namespace App\Http\Requests\Pricelist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'id'                      => 'required|numeric',
            'name'                    => 'required|string',
            'purchase_price'          => 'required|numeric|min:0',
            'discount'                => 'nullable|numeric',
            'active'                  => 'boolean|required',
            'package_size'            => 'required|numeric',
            'pant'                    => 'required|boolean',
            'category_id'             => 'required|exists:categories,id',
            'barcodes.*.variant_name' => 'string|nullable|sometimes',
        ];
        foreach ($this->post('barcodes') as $index => $barcode) {
            if ($barcode['id'] ?? false) {
                $rules['barcodes.' . $index . '.barcode'] = [
                    'required',
                    'string',
                    Rule::unique('barcodes', 'barcode')->ignore($barcode['id']),
                ];
            } else {
                $rules['barcodes.' . $index . '.barcode'] = 'required|string|unique:barcodes,barcode';
            }
        }
        return $rules;
    }
}
