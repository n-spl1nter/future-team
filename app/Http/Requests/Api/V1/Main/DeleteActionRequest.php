<?php

namespace App\Http\Requests\Api\V1\Main;

use App\Entities\Action;
use Illuminate\Foundation\Http\FormRequest;

class DeleteActionRequest extends FormRequest
{
    public function authorize()
    {
        /** @var Action $action */
        $action = $this->route()->parameter('action');
        return $action->user_id === $this->user()->id;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
