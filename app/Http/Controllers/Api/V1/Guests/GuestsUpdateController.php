<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Guests;

use App\Actions\Api\V1\Guests\GuestUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GuestUpdateRequest;
use App\Http\Resources\Api\V1\GuestResource;
use App\Models\Guest;

class GuestsUpdateController extends Controller
{
    public function __invoke(
        Guest $guest,
        GuestUpdateAction $action,
        GuestUpdateRequest $request
    ) {
        $guest = $action(
            guest: $guest,
            request: $request
        );

        return GuestResource::make($guest);
    }
}
