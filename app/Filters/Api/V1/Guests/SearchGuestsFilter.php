<?php

declare(strict_types=1);

namespace App\Filters\Api\V1\Guests;

use App\Filters\Filter;
use App\Filters\SearchableFilter;
use App\Http\Requests\Api\V1\GuestsIndexRequest;
use Closure;
use Illuminate\Database\Eloquent\Builder;

final class SearchGuestsFilter extends SearchableFilter implements Filter
{
    protected array $searchableFields = [
        'name',
        'surname',
        'email',
        'phone_number',
        'country_name'
    ];

    public function __construct(
        private readonly GuestsIndexRequest $request
    ) {
    }


    public function __invoke(Builder $builder, Closure $next): Builder
    {
        return $next($builder)
            ->when(
                value: $this->request->has('search'),
                callback: function (Builder $builder) {
                    $search = $this->transform($this->request->validated('search'));

                    return $builder->whereHas(
                        relation: 'country',
                        callback: function (Builder $builder) use ($search) {
                            $builder->where($search);
                        }
                    );
                }
            );
    }
}
