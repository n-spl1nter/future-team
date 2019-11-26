<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Entities\CompanyProfile;
use App\Entities\Profile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        $baseRules = [
            'email' => 'required|email|unique:users,email',
            'type' => ['required', Rule::in(['member', 'company'])]
        ];
        if (request()->get('type') == 'member') {
            return $baseRules + Profile::getOnCreateValidationRules();
        }
        return $baseRules + CompanyProfile::getOnCreateValidationRules();
    }
}
