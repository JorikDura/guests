<?php

declare(strict_types=1);

namespace App\Actions\Api\V1\Guests;

use App\Filters\Api\V1\Guests\OrderByDateFilter;
use App\Filters\Api\V1\Guests\SearchGuestsFilter;
use App\Http\Requests\Api\V1\GuestsIndexRequest;
use App\Models\Guest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;

final readonly class GuestsIndexAction
{
    public function __invoke(GuestsIndexRequest $request): LengthAwarePaginator
    {
        /** @var Builder $guestsQuery */
        $guestsQuery = Pipeline::send(Guest::query())
            ->through([
                SearchGuestsFilter::class,
                OrderByDateFilter::class
            ])
            ->thenReturn();

        return $guestsQuery->with(['country'])
            ->paginate()
            ->appends($request->query());
    }
}
