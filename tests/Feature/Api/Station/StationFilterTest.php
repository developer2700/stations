<?php

namespace Tests\Feature\Api;

use App\Models\Station;
use App\Models\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Grimzy\LaravelMysqlSpatial\Types\Point;

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

    /** @test */
    public function it_returns_stations_which_belongs_to_a_nested_company()
    {
        $company = factory(Company::class)->create();
        $station = factory(Station::class)->create(['company_id'=>$company->id]);

        $company2 = factory(Company::class)->create(['parent_company_id'=>$company->id]);
        $station2 = factory(Station::class)->create(['company_id'=>$company2->id]);


        $response = $this->getJson('/api/stations?nested_company_id_stations='.$company->id);

        $response->assertStatus(200)
            ->assertJson([
                'stations' => [
                    [
                        'id' => $station2->id,
                        'name' => $station2->name,
                    ],
                    [
                        'id' => $station->id,
                        'name' => $station->name,
                    ],
                ],
                'stationsCount' => 2
            ]);
    }

    /** @test */
    public function it_returns_stations_which_are_close_to_given_locations_by_radius_distance()
    {
        //Kassisaba and  Kalamaja are 2.5km far
        $Kassisaba =['latitude'=>59.432357,'longitude'=> 24.726164];
        $Kalamaja =['latitude'=>59.450142,'longitude'=> 24.737538];
        //6km
        $Pae =['latitude'=>59.436050,'longitude'=> 24.8215618];

        $station1 = factory(Station::class)->create([
            'name' => 'Kassisaba in Estonia',
            'location' => new Point($Kassisaba['latitude'], $Kassisaba['longitude']),
        ]);
        $station2 = factory(Station::class)->create([
            'name' => 'Kalamaja in Estonia',
            'location' => new Point($Kalamaja['latitude'], $Kalamaja['longitude'])
        ]);
        $station3 = factory(Station::class)->create([
            'name' => 'Pae in Estonia',
            'location' => new Point($Pae['latitude'], $Pae['longitude'])
        ]);

        $query_string="&latitude={$Kassisaba['latitude']}&longitude={$Kassisaba['longitude']}&radius=2500";
        $response = $this->getJson("/api/stations?close_radius=1{$query_string}");


        $response->assertStatus(200)
            ->assertJson([
                'stations' => [
                    [
                        'id' => $station2->id,
                        'name' => $station2->name,
                    ],
                    [
                        'id' => $station1->id,
                        'name' => $station1->name,
                    ],

                ],
                'stationsCount' => 2
            ]);
    }

}
