<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'country_name',
        'dial_code'
    ];

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
}
