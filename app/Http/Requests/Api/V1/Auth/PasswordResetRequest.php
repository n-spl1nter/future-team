<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Api\V1\BaseRequest;

class PasswordResetRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}
