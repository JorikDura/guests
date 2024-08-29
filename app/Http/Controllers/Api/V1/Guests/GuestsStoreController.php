<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Guests;

use App\Actions\Api\V1\Guests\GuestStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GuestStoreRequest;
use App\Http\Resources\Api\V1\GuestResource;

class GuestsStoreController extends Controller
{
    public function __invoke(
        GuestStoreAction $action,
        GuestStoreRequest $request
    ) {
        $guest = $action($request);

        return GuestResource::make($guest);
    }
}
