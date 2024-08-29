<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Country
 */
class CountryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->country_name,
            'code' => $this->dial_code
        ];
    }
}
