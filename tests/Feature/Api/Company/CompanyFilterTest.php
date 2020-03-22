<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompanyFilterTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_an_empty_array_of_companies_when_no_companies_exist_with_the_name()
    {
        $response = $this->getJson('/api/companies?name=test');

        $response->assertStatus(200)
            ->assertJson([
                'companies' => [],
                'companiesCount' => 0
            ]);

    }

    /** @test */
    public function it_returns_array_of_companies_when_companies_exist_by_given_name()
    {
        $companies = factory(\App\Models\Company::class)->times(3)->create(['name' => 'company1']);

        $response = $this->getJson('/api/companies?name=company1');

        $response->assertStatus(200)
            ->assertJson([
                'companies' => [
                    [
                        'id' => $companies[2]->id,
                        'name' => $companies[2]->name,
                    ],
                    [
                        'id' => $companies[1]->id,
                        'name' => $companies[1]->name,
                    ],
                    [
                        'id' => $companies[0]->id,
                        'name' => $companies[0]->name,
                    ],
                ],
                'companiesCount' => 3
            ]);
    }

    /** @test */
    public function it_returns_array_of_companies_when_companies_exist_by_given_id()
    {
        $companies = factory(\App\Models\Company::class)->times(3)->create(['name' => 'company1']);

        $response = $this->getJson('/api/companies?id=1');

        $response->assertStatus(200)
            ->assertJson([
                'companies' => [
                    [
                        'name' => $companies[2]->name,
                    ],
                ],
                'companiesCount' => 1
            ]);
    }

    /** @test */
    public function it_returns_array_of_companies_by_given_the_company_parent_id()
    {
        $company = factory(\App\Models\Company::class)->create();
        $companies = factory(\App\Models\Company::class)->times(3)
            ->create([
                'parent_company_id' => $company->id
            ]);

        $response = $this->getJson('/api/companies?parent_company_id='.$company->id);
        $response->assertStatus(200)
            ->assertJson([
                'companies' => [
                    [
                        'id' => $companies[2]->id,
                        'name' => $companies[2]->name,
                    ],
                    [
                        'id' => $companies[1]->id,
                        'name' => $companies[1]->name,
                    ],
                    [
                        'id' => $companies[0]->id,
                        'name' => $companies[0]->name,
                    ],
                ],
                'companiesCount' => 3
            ]);
    }

}
