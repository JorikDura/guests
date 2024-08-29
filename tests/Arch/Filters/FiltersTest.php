<?php

use App\Filters\Filter;
use App\Filters\SearchableFilter;

arch('filters test')
    ->expect('App\Filters\Api')
    ->toUseStrictTypes()
    ->toExtend(Filter::class)
    ->toBeFinal()
    ->toHaveSuffix('Filter');

arch('filter interface test')
    ->expect(Filter::class)
    ->toBeInterface();

arch('searchable filter test')
    ->expect(SearchableFilter::class)
    ->toBeAbstract()
    ->toHaveMethod('transform')
    ->toUseStrictTypes();
