<?php

namespace App\Http\Requests\Api\V1\User;

use App\Entities\Profile;
use App\Entities\User;
use Illuminate\Foundation\Http\FormRequest;

class CompleteProfileForSocialUserRequest extends FormRequest
{
    public function authorize()
    {
        /** @var User $user */
        $user = $this->user();
        return $user->isMember() && !$user->hasFilledProfile();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $defaultRules = [];
        if (is_null($this->user()->email)) {
            $defaultRules['email'] = 'required|email|unique:users,email';
        }
        return $defaultRules + Profile::getOnCreateValidationRules();
    }
}
