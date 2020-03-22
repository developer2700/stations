<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StationPaginateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_correct_stations_with_limit_and_offset()
    {

        $stations = factory(\App\Models\Station::class)->times(25)->create();

        $response = $this->getJson('/api/stations');
        $response->assertStatus(200)
            ->assertJson([
                'stationsCount' => 25
            ]);

        $this->assertCount(20, $response->json()['stations'], 'Expected stations to set default limit to 20');

        $this->assertEquals(
            \App\Models\Station::latest()->take(20)->pluck('name')->toArray(),
            array_column($response->json()['stations'], 'name'),
            'Expected latest 20 stations by default'
        );

        $response = $this->getJson('/api/stations?limit=10&offset=5');

        $response->assertStatus(200)
            ->assertJson([
                'stationsCount' => 25
            ]);

        $this->assertCount(10, $response->json()['stations'], 'Expected stations limit of 10 when set');

        $this->assertEquals(
            \App\Models\Station::latest()->skip(5)->take(10)->pluck('name')->toArray(),
            array_column($response->json()['stations'], 'name'),
            'Expected latest 10 stations with 5 offset'
        );
    }
}
