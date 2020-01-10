<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventChangeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:255',
            'conditions' => 'required|string|min:5|max:1000',
            'reasons' => 'required|string|min:5|max:400',
            'contact_data' => 'required|string|min:5|max:255',
            'additional_info' => 'required|string|min:5|max:1000',
            'domains' => 'required|array|min:1|max:3',
            'domains.*' => 'required|string|min:2|max:400',
            'city_id' => 'required|integer|exists:_cities,city_id',
            'country_id' => 'required|integer',
            'start_at' => 'required|date_format:"Y-m-d H:i:s"',
            'end_at' => 'required|date_format:"Y-m-d H:i:s"|after:start_at',
            'video_links' => 'nullable|array|max:5',
            'video_links.*' => 'url',
        ];
    }
}
