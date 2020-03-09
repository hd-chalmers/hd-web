<?php

namespace App\Http\Requests\Pricelist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NewProduct extends FormRequest
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
        return [
            'name' => 'required|string',
            'purchase_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric',
            'active' => 'boolean|required',
            'package' => 'required|numeric',
            'pant' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'barcodes.*.barcode' => 'unique:barcodes,barcode|required',
            'barcodes.*.variant_name' => 'string|nullable|sometimes',
        ];
    }
}
