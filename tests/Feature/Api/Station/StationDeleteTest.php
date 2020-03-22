<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StationDeleteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_a_200_success_response_on_successfully_removing_the_station()
    {
        $station = factory(\App\Models\Station::class)->create();

        $response = $this->deleteJson("/api/stations/{$station->id}", [], $this->headers);

        $response->assertStatus(200);

        $response = $this->getJson("/api/stations/{$station->id}");

        $response->assertStatus(404);
    }

}
