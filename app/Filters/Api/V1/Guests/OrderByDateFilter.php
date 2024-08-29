<?php

declare(strict_types=1);

namespace App\Filters\Api\V1\Guests;

use App\Filters\Filter;
use App\Http\Requests\Api\V1\GuestsIndexRequest;
use Closure;
use Illuminate\Database\Eloquent\Builder;

final readonly class OrderByDateFilter implements Filter
{
    public function __construct(
        private GuestsIndexRequest $request
    ) {
    }

    public function __invoke(Builder $builder, Closure $next): Builder
    {
        $orderByDate = $this->request->validated(key: 'order_by_date', default: true);

        return $next($builder)
            ->orderBy('created_at', $orderByDate ? 'desc' : 'asc');
    }
}
