<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCommittee extends FormRequest
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
            'year'                     => "numeric|min:2000|max:2050|required",
            'description'              => 'string|nullable',
            'background_image'         => 'image|nullable',
            'group_photo'              => 'image|nullable',
            'front_image'              => 'image|nullable',
            'member'                   => 'array|required|min:3',
            'member.*.name'            => 'string|required',
            'member.*.id'              => 'numeric|nullable',
            'member.*.role'            => 'string|required',
            'member.*.quote'           => 'string|nullable',
            'member.*.description'     => 'string|nullable',
            'member.*.favourite_game'  => 'string|nullable',
            'member.*.favourite_sugar' => 'string|nullable',
            'member.*.image'           => 'image|nullable',
        ];
    }

    public function messages() {
        return [
        ];
    }
}
