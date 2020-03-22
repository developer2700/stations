<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompanyViewTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_company_by_id_if_valid_and_not_found_error_if_invalid()
    {
        $company = factory(\App\Models\Company::class)->create();

        $response = $this->getJson("/api/companies/{$company->id}");

        $response->assertStatus(200)
            ->assertJson([
                'company' => [
                    'name' => $company->name,
                    'created_at' => $company->created_at,
                    'parent_company_id' => $company->parent_company_id,
                ]
            ]);

        $response = $this->getJson('/api/companies/wrong_id');

        $response->assertStatus(404);
    }

}
