<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Guests;

use App\Actions\Api\V1\Guests\GuestsIndexAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GuestsIndexRequest;
use App\Http\Resources\Api\V1\GuestResource;

class GuestsIndexController extends Controller
{
    public function __invoke(
        GuestsIndexAction $action,
        GuestsIndexRequest $request
    ) {
        $guests = $action($request);

        return GuestResource::collection($guests);
    }
}
