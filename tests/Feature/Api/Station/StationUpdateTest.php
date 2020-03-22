<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StationUpdateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_updated_station_on_successfully_updating_the_station()
    {
        $station = factory(\App\Models\Station::class)->create();

        $data = [
            'station' => [
                'name' => 'station new name',
            ]
        ];

        $response = $this->putJson("/api/stations/{$station->id}", $data, $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'station' => [
                    'name' => 'station new name',
                ]
            ]);
    }

    /** @test */
    public function it_returns_appropriate_field_validation_errors_when_updating_the_station_with_invalid_inputs()
    {
        $station = factory(\App\Models\Station::class)->create();

        $data = [
            'station' => [
                'name' => '',
            ]
        ];

        $response = $this->putJson("/api/stations/{$station->id}", $data, $this->headers);

        $response->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                'errors' => [
                    'name' => ['The name field is required.'],
                ]
            ]);
        $data = [
            'station' => [
                'name' => 'station new name',
                'company_id' => 'wrong_id_type',
            ]
        ];
        $response = $this->putJson("/api/stations/{$station->id}", $data, $this->headers);

        $response->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                'errors' => [
                    'company_id' => ['The company id must be a number.'],
                ]
            ]);
    }

    /** @test */
    public function it_returns_a_422_invalid_error_while_update_station_which_given_company_id_not_exist()
    {
        $station = factory(\App\Models\Station::class)->state('with-company')->create();
        $data = [
            'station' => [
                'name' => 'new station name',
                'company_id' => 1001, // wrong id
            ]
        ];
        $response = $this->putJson("/api/stations/{$station->id}", $data, $this->headers);

        $response->assertStatus(422)
            ->assertJson([
                "message"=> "The given data was invalid.",
                'errors' => [
                    'company_id' => ['The selected company id is invalid.'],
                ]
            ]);
        $response->assertStatus(422);
    }

}
