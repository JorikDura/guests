<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

readonly class GetCountryFromPhoneCodeRule implements ValidationRule
{
    private const string PHONE_NUMBER_SEPARATOR = ' ';

    public function __construct(
        private Request $request
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $country = $this->request->get('country_id');

        if (!is_null($country)) {
            return;
        }

        $phoneCode = strtok(
            string: $value,
            token: self::PHONE_NUMBER_SEPARATOR
        );

        $country = Country::select('id')
            ->where('dial_code', $phoneCode)
            ->first() ?? throw ValidationException::withMessages([
            'phone_number' => [
                "This is unexpected. We don't have your country.",
                "Please note that you can specify it manually via country field."
            ],
        ]);

        $this->request->merge(['country_id' => $country->id]);
    }
}
