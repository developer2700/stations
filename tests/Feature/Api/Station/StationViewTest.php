<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Company;
use App\Models\Station;

class StationViewTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_station_by_id()
    {
        $station = factory(Station::class)->state('with-company')->create();

        $response = $this->getJson("/api/stations/{$station->id}");
        $json = $station->toArray();
        $json['location'] = $station->location->jsonSerialize()->jsonSerialize();
        $json['company'] = $station->company->toArray();

        $response->assertSuccessful()
            ->assertJson([
                'station'=>$json
                ]);
    }

    /** @test */
    public function it_returns_a_not_found_error_when_trying_to_get_none_existing_station()
    {
        $response = $this->getJson("/api/stations/wrong-id");

        $response->assertStatus(404);
    }
}
