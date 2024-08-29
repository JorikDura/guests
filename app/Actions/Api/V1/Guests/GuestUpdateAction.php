<?php

declare(strict_types=1);

namespace App\Actions\Api\V1\Guests;

use App\Http\Requests\Api\V1\GuestUpdateRequest;
use App\Models\Guest;

/**
 * Update guest
 */
final readonly class GuestUpdateAction
{
    public function __invoke(
        Guest $guest,
        GuestUpdateRequest $request
    ): Guest {
        $data = $request->validated();

        if ($this->isCountryIdExists($data, $countryId = $request->input('country_id'))) {
            $data['country_id'] = $countryId;
        }

        return tap($guest, function (Guest $guest) use ($data) {
            $guest->update($data);
            return $guest->load(['country']);
        });
    }

    private function isCountryIdExists(array $data, $countryId): bool
    {
        return !array_key_exists('country_id', $data)
            && !is_null($countryId);
    }
}
