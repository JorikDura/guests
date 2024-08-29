<?php

declare(strict_types=1);

namespace App\Actions\Api\V1\Countries;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

final readonly class CountriesIndexAction
{
    public function __invoke(): Collection
    {
        return Country::all();
    }
}
