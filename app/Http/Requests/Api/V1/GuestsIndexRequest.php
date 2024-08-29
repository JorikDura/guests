<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class GuestsIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'array'],
            'search.*' => ['nullable', 'string'],
            'order_by_date' => ['nullable', 'boolean']
        ];
    }
}
