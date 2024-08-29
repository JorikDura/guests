<?php

use App\Models\Country;
use App\Models\Guest;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

describe('guests tests', function () {
    beforeEach(function () {
        $countries = Country::factory(3)
            ->create();

        $guests = Guest::factory(5)->create([
            'country_id' => $countries->random()->id,
            'name' => 'Tester',
            'surname' => 'Testirovich'
        ]);

        $this->country = $countries->random();

        $this->guest = $guests->random();

        $this->guestNames = [
            'name' => $this->guest->name,
            'surname' => $this->guest->surname
        ];
    });

    it('get guests', function () {
        getJson('api/v1/guests')
            ->assertSuccessful()
            ->assertSee($this->guestNames);
    });

    it('get guest by search', function () {
        getJson("api/v1/guests?search[name]={$this->guest->name}&search[surname]={$this->guest->surname}")
            ->assertSuccessful()
            ->assertSee($this->guestNames);
    });

    it('get failure guest with invalid search field', function () {
        getJson("api/v1/guests?search[invalidField]=ImInvalid")
            ->assertUnprocessable();
    });

    it('get guest via id', function () {
        getJson("api/v1/guests/{$this->guest->id}")
            ->assertSuccessful()
            ->assertSee($this->guestNames);
    });

    it('get failure via guest invalid id', function () {
        getJson('api/v1/guests/111111')
            ->assertNotFound();
    });

    it('add new guest', function () {
        $data = [
            'name' => 'ViaTest',
            'surname' => 'Testirovich',
            'phone_number' => '+7 999-999-99-99',
            'country_id' => $this->country->id,
            'email' => fake()->email()
        ];

        postJson(
            uri: 'api/v1/guests',
            data: $data
        )->assertSuccessful()->assertSee($data);

        assertDatabaseHas(
            table: 'guests',
            data: $data
        );
    });

    it('update guest', function () {
        $guest = Guest::factory()->create([
            'country_id' => $this->country->id
        ]);

        $data = [
            'name' => 'AnotherTester',
            'surname' => 'Testirovich'
        ];

        postJson(
            uri: "api/v1/guests/$guest->id",
            data: $data + ['_method' => 'PUT']
        )->assertSuccessful()->assertSee($data);

        assertDatabaseHas(
            table: 'guests',
            data: [
                'id' => $guest->id,
                'country_id' => $guest->country_id
            ] + $data
        );
    });

    it('delete guest', function () {
        $guest = Guest::factory()->create([
            'country_id' => $this->country->id,
        ]);

        deleteJson("api/v1/guests/$guest->id")
            ->assertSuccessful();

        assertDatabaseMissing(
            table: 'guests',
            data: [
                'id' => $guest->id,
                'name' => $guest->name,
                'surname' => $guest->surname
            ]
        );
    });
});
