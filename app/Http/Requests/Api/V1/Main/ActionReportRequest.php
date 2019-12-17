<?php

namespace App\Http\Requests\Api\V1\Main;

use App\Entities\Action;
use App\Http\Requests\Api\V1\BaseRequest;

class ActionReportRequest extends BaseRequest
{
    public function authorize()
    {
        /** @var Action $action */
        $action = $this->route()->parameter('action');
        return $action->user_id === $this->user()->id && !$action->report;
    }

    public function rules()
    {
        return [
            'photos' => 'required|array|min:2|max:25',
            'photos.*' => 'required|image|mimes:jpeg,bmp,png|dimensions:min_width=1280,min_height=700|max:10240',
            'video_links' => 'nullable|array|max:5',
            'video_links.*' => 'url',
        ];
    }
}
