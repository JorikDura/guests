<?php

declare(strict_types=1);

namespace app\Http\Controllers\Api\V1\Countries;

use App\Actions\Api\V1\Countries\CountriesIndexAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CountryResource;

class CountriesIndexController extends Controller
{
    public function __invoke(CountriesIndexAction $action)
    {
        $countries = $action();

        return CountryResource::collection($countries);
    }
}
