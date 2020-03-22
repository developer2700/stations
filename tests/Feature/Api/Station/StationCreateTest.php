<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StationCreateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_station_on_successfully_creating_a_new_station()
    {
        $data = [
            'station' => [
                'name' => 'station 1',
            ]
        ];
        $response = $this->postJson('/api/stations', $data, $this->headers);
        $response->assertStatus(200)
            ->assertJson([
                'station' => [
                    'name' => $data['station']['name'],
                ]
            ]);
    }

  /** @test */
    public function it_returns_the_station_and_company_on_successfully_creating_a_new_station_with_given_company_id()
    {
        $company = factory(\App\Models\Company::class)->create();

        $data = [
            'station' => [
                'name' => 'station 1',
                'company_id' => $company->id,
            ]
        ];
        $response = $this->postJson('/api/stations', $data, $this->headers);
        $response->assertStatus(200)
            ->assertJson([
                'station' => [
                    'name' => $data['station']['name'],
                    'company_id' => $company->id,
                ]
            ]);
    }

    /** @test */
    public function it_returns_appropriate_field_validation_errors_when_creating_a_new_station_with_invalid_inputs()
    {
        $data = [
            'station' => [
                'name' => '',
            ]
        ];

        $response = $this->postJson('/api/stations', $data, $this->headers);

        $response->assertStatus(422)
            ->assertJson([
                "message"=> "The given data was invalid.",
                'errors' => [
                    'name' => ['The name field is required.'],
                ]
            ]);
        $data = [
            'station' => [
                'name' => 'station1',
                'company_id' => 'wrong_id',
            ]
        ];
        $response = $this->postJson('/api/stations', $data, $this->headers);

        $response->assertStatus(422)
            ->assertJson([
                "message"=> "The given data was invalid.",
                'errors' => [
                    'company_id' => ['The company id must be a number.'],
                ]
            ]);
    }

    /** @test */
    public function it_returns_a_422_invalid_error_while_creating_station_which_given_wrong_company_id()
    {
        $data = [
            'station' => [
                'name' => 'station1',
                'company_id' => 1001,
            ]
        ];
        $response = $this->postJson('/api/stations', $data, $this->headers);

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
