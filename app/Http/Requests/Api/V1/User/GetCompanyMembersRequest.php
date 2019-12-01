<?php

namespace App\Http\Requests\Api\V1\User;

use App\Entities\User;
use App\Http\Requests\Api\V1\BaseRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Validator;

class GetCompanyMembersRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            if (empty($validator->getData()['user_id'])) {
                return;
            }
            $user = User::findOrFail($validator->getData()['user_id']);
            if (!$user->isCompany()) {
                throw new ModelNotFoundException();
            }
        });
    }
}
