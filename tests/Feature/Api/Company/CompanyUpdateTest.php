<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompanyUpdateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_updated_company_on_successfully_updating_the_company()
    {
        $company =factory(\App\Models\Company::class)->create();

        $data = [
            'company' => [
                'name' => 'Company new name',
            ]
        ];

        $response = $this->putJson("/api/companies/{$company->id}", $data, $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'company' => [
                    'name' => 'Company new name',
                ]
            ]);
    }

    /** @test */
    public function it_returns_appropriate_field_validation_errors_when_updating_the_company_with_invalid_inputs()
    {
        $company = factory(\App\Models\Company::class)->create();

        $data = [
            'company' => [
                'name' => '',
            ]
        ];

        $response = $this->putJson("/api/companies/{$company->id}", $data, $this->headers);

        $response->assertStatus(422)
            ->assertJson([
                "message"=>"The given data was invalid.",
                'errors' => [
                    'name' => ['The name field is required.'],
                ]
            ]);
    }

    /** @test */
//    public function it_returns_an_unauthorized_error_when_trying_to_update_compny_without_logging_in()
//    {
//        $company = $this->loggedInUser->products()->save(factory(\App\Models\Company::class)->make());
//
//        $data = [
//            'company' => [
//                'name' => 'new name',
//            ]
//        ];
//
//        $response = $this->putJson("/api/companies/{$company->id}", $data);
//
//        $response->assertStatus(401);
//    }


}
