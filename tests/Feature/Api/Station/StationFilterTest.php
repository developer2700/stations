<?php

namespace Tests\Feature\Api;

use App\Models\Station;
use App\Models\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StationFilterTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_an_empty_array_of_stations_when_no_station_exist_with_the_name()
    {
        $response = $this->getJson('/api/stations?name=test');

        $response->assertStatus(200)
            ->assertJson([
                'stations' => [],
                'stationsCount' => 0
            ]);

    }

    /** @test */
    public function it_returns_array_of_stations_when_stations_exist_by_given_name()
    {
        $stations = factory(Station::class)->times(3)->create(['name' => 'station1']);

        $response = $this->getJson('/api/stations?name=station1');

        $response->assertStatus(200)
            ->assertJson([
                'stations' => [
                    [
                        'id' => $stations[2]->id,
                        'name' => $stations[2]->name,
                    ],
                    [
                        'id' => $stations[1]->id,
                        'name' => $stations[1]->name,
                    ],
                    [
                        'id' => $stations[0]->id,
                        'name' => $stations[0]->name,
                    ],
                ],
                'stationsCount' => 3
            ]);
    }

    /** @test */
    public function it_returns_station_when_exist_by_given_id()
    {
        $station = factory(Station::class)->create();

        $response = $this->getJson('/api/stations?id='.$station->id);

        $response->assertStatus(200)
            ->assertJson([
                'stations' => [
                    [
                        'id' => $station->id,
                        'name' => $station->name,
                    ],
                ],
                'stationsCount' => 1
            ]);
    }

}
