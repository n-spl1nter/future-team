<?php

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\Api\V1\BaseRequest;
use Illuminate\Validation\Validator;

class ChangePasswordRequest extends BaseRequest
{
    protected function isValidPassword(string $password):bool
    {
        return \Hash::check($password, \Auth::user()->password);
    }

    public function rules()
    {
        return [
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|max:20|confirmed',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $password = $validator->getData()['current_password'];
            if ($password && !$this->isValidPassword($password)) {
                $validator->errors()->add('current_password', __('auth.wrong_password'));
            }
        });
    }
}
