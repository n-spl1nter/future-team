<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ActionUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:255',
            'about' => 'required|string|min:5',
            'success_secret' => 'required|string|min:5|max:400',
            'domains' => 'required|array|min:2|max:5',
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
