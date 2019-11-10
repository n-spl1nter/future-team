<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateActionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:255',
            'about' => 'required|string|min:5',
            'success_secret' => 'required|string|min:5|max:400',
            'domains' => 'required|array|min:2|max:5',
            'domains.*' => 'required|string|min:2|max:255',
            'photos' => 'required|array|min:2|max:5',
            'photos.*' => 'required|image|mimes:jpeg,bmp,png|dimensions:min_width=1280,min_height=800',
            'city_id' => 'required|integer|exists:_cities,city_id',
            'start_at' => 'required|date_format:"Y-m-d H:i:s"|after:tomorrow',
            'end_at' => 'required|date_format:"Y-m-d H:i:s"|after:start_at',
            'terms' => 'required|accepted',
        ];
    }
}
