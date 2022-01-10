<?php

namespace App\Http\Requests;

use Illuminate\Routing\Route;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PlaylistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Route $route)
    {
        return [
            // 'thumbnail' => ['required', 'image', 'mimes:jpeg,jpg,png'],
            'thumbnail' => ['image', 'mimes:jpeg,jpg,png', Rule::requiredIf($route->getActionName() == "App\Http\Controllers\Screencast\PlaylistController@create")],
            'name' => 'required',
            'price' => ['required', 'numeric'],
            'description' => 'required',
        ];
    }
}
