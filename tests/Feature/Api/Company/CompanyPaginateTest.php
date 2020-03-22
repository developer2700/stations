<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompanyPaginateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_correct_companies_with_limit_and_offset()
    {

        $companies = factory(\App\Models\Company::class)->times(25)->create();

        $response = $this->getJson('/api/companies');

        $response->assertStatus(200)
            ->assertJson([
                'companiesCount' => 25
            ]);

        $this->assertCount(20, $response->json()['companies'], 'Expected companies to set default limit to 20');

        $this->assertEquals(
            \App\Models\Company::latest()->take(20)->pluck('name')->toArray(),
            array_column($response->json()['companies'], 'name'),
            'Expected latest 20 companies by default'
        );

        $response = $this->getJson('/api/companies?limit=10&offset=5');

        $response->assertStatus(200)
            ->assertJson([
                'companiesCount' => 25
            ]);

        $this->assertCount(10, $response->json()['companies'], 'Expected companies limit of 10 when set');

        $this->assertEquals(
            \App\Models\Company::latest()->skip(5)->take(10)->pluck('name')->toArray(),
            array_column($response->json()['companies'], 'name'),
            'Expected latest 10 companies with 5 offset'
        );
    }
}
