<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Api\V1\BaseRequest;

class ResetPasswordRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:6|max:20',
        ];
    }
}
