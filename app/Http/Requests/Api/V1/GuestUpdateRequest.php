<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use App\Rules\GetCountryFromPhoneCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class GuestUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:96'],
            'surname' => ['nullable', 'string', 'max:96'],
            'phone_number' => [
                'nullable',
                'regex:/(?:[\+\d])\s(.*[\d\-\(\)\s])$/',
                'unique:guests,phone_number',
                new GetCountryFromPhoneCodeRule($this)
            ],
            'country_id' => ['nullable', 'exists:countries,id'],
            'email' => ['nullable', 'email', 'unique:guests,email'],
        ];
    }
}
