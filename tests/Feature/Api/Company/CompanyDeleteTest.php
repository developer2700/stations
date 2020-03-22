<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompanyDeleteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_a_200_success_response_on_successfully_removing_the_company()
    {
        $company = factory(\App\Models\Company::class)->create();

        $response = $this->deleteJson("/api/companies/{$company->id}", [], $this->headers);

        $response->assertStatus(200);

        $response = $this->getJson("/api/companies/{$company->id}");

        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_a_forbidden_error_when_trying_to_remove_company_which_has_children()
    {
        $company = factory(\App\Models\Company::class)->create();
        $companies = factory(\App\Models\Company::class)->times(3)
            ->create([
                'parent_company_id' => $company->id
            ]);
        $response = $this->deleteJson("/api/companies/{$company->id}", [], $this->headers);

        $response->assertStatus(403);
    }
}
