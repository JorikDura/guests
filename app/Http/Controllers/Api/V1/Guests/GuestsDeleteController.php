<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Guests;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Symfony\Component\HttpFoundation\Response;

class GuestsDeleteController extends Controller
{
    public function __invoke(Guest $guest)
    {
        $guest->delete();

        return response()->noContent(status: Response::HTTP_OK);
    }
}
