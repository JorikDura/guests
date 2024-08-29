<?php

declare(strict_types=1);

namespace App\Actions\Api\V1\Guests;

use App\Http\Requests\Api\V1\GuestStoreRequest;
use App\Models\Guest;

final readonly class GuestStoreAction
{
    public function __invoke(GuestStoreRequest $request): Guest
    {
        $data = $request->validated();

        if (!array_key_exists('country_id', $data)) {
            $data['country_id'] = $request->get('country_id');
        }

        unset($request);

        return Guest::create($data)
            ->load(['country']);
    }
}
