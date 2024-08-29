<?php

use App\Models\Country;

use function Pest\Laravel\getJson;

describe('countries test', function () {
    it('get countries', function () {
        $country = Country::factory(15)
            ->create()
            ->random();

        getJson('api/v1/countries')
            ->assertSuccessful()
            ->assertSee($country->attributesToArray());
    });
});
