<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Guests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\GuestResource;
use App\Models\Guest;

class GuestsShowController extends Controller
{
    public function __invoke(Guest $guest)
    {
        return GuestResource::make($guest->loadMissing(['country']));
    }
}
