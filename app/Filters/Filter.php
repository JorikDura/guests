<?php

declare(strict_types=1);

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    public function __invoke(Builder $builder, Closure $next): Builder;
}
