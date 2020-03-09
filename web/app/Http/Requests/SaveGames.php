<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SaveGames extends FormRequest
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
            'games' => 'array',
            'games.*.id' => 'numeric|required',
            'games.*.name' => 'string|required',
            'games.*.published_year' => 'date_format:Y|required',
            'games.*.min_players' => 'min:1|numeric|required',
            'games.*.max_players' => 'min:1|numeric|required|gte:games.*.min_players',
            'games.*.min_playtime' => 'min:1|numeric|required',
            'games.*.max_playtime' => 'min:1|numeric|required|gte:games.*.min_players',
        ];
    }
}
