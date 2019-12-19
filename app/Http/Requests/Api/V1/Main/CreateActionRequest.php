<?php

namespace App\Http\Requests\Api\V1\Main;

use App\Http\Requests\Api\V1\BaseRequest;

class CreateActionRequest extends BaseRequest
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
            'about' => 'required|string|min:5',
            'success_secret' => 'required|string|min:5|max:400',
            'domains' => 'required|array|min:2|max:5',
            'domains.*' => 'required|string|min:2|max:400',
            'photos' => 'required|array|min:2|max:25',
            'photos.*' => 'required|image|mimes:jpeg,bmp,png|dimensions:min_width=1280,min_height=700|max:10240',
            'city_id' => 'required|integer|exists:_cities,city_id',
            'country_id' => 'required|integer',
            'start_at' => 'required|date_format:"Y-m-d H:i:s"',
            'end_at' => 'required|date_format:"Y-m-d H:i:s"|after:start_at',
            'terms' => 'required|accepted',
            'video_links' => 'nullable|array|max:5',
            'video_links.*' => 'url',
        ];
    }

    public function messages()
    {
        $messages = [];
        foreach ($this->file('photos') as $key => $photo) {
            $messages["photos.$key.dimensions"] = __('validation.wrongPhotoDimensions', [
                'index' => $key + 1,
                'resolution' => '1280x700px',
            ]);
        }
        return $messages;
    }
}
