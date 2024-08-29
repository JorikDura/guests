<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Validation\ValidationException;

abstract class SearchableFilter
{
    protected array $searchableFields = [];

    protected function transform(array $values, $operator = 'LIKE'): array
    {
        $result = [];

        foreach ($values as $key => $value) {
            if (!in_array($key, $this->searchableFields)) {
                throw ValidationException::withMessages([
                    "search[$key]" => "no such field :$key"
                ]);
            }

            $result[] = [$key, $operator, "%$value%"];
        }

        return $result;
    }
}
