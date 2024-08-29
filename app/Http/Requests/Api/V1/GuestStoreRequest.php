<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use App\Rules\GetCountryFromPhoneCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class GuestStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:96'],
            'surname' => ['required', 'string', 'max:96'],
            'phone_number' => [
                'required',
                'regex:/(?:[\+\d])\s(.*[\d\-\(\)\s])$/',
                'unique:guests,phone_number',
                new GetCountryFromPhoneCodeRule($this)
            ],
            'country_id' => ['nullable', 'exists:countries,id'],
            'email' => ['nullable', 'email', 'unique:guests,email'],
        ];
    }
}
