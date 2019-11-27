<?php

namespace App\Http\Requests\Api\V1\Main;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:255',
            'conditions' => 'required|string|min:5|max:1000',
            'reasons' => 'required|string|min:5|max:400',
            'contact_data' => 'required|string|min:5|max:255',
            'additional_info' => 'required|string|min:5|max:1000',
            'photos' => 'required|array|min:2|max:5',
            'photos.*' => 'required|image|mimes:jpeg,bmp,png|dimensions:min_width=1280,min_height=800',
            'city_id' => 'required|integer|exists:_cities,city_id',
            'country_id' => 'required|integer',
            'start_at' => 'required|date_format:"Y-m-d H:i:s"|after:tomorrow',
            'end_at' => 'required|date_format:"Y-m-d H:i:s"|after:start_at',
            'terms' => 'required|accepted',
            'video_links' => 'nullable|array',
            'video_links.*' => 'url',
        ];
    }
}
