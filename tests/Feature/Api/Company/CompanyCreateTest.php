<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompanyCreateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_the_company_on_successfully_creating_a_new_company()
    {
        $data = [
            'company' => [
                'name' => 'company 1',
            ]
        ];

        $response = $this->postJson('/api/companies', $data, $this->headers);
        $response->assertStatus(200)
            ->assertJson([
                'company' => [
                    'name' => $data['company']['name'],
                ]
            ]);
    }

    /** @test */
    public function it_returns_appropriate_field_validation_errors_when_creating_a_new_company_with_invalid_inputs()
    {
        $data = [
            'company' => [
                'name' => '',
            ]
        ];

        $response = $this->postJson('/api/companies', $data, $this->headers);

        $response->assertStatus(422)
            ->assertJson([
                "message"=> "The given data was invalid.",
                'errors' => [
                    'name' => ['The name field is required.'],
                ]
            ]);
    }

    /** @test */
//    public function it_returns_an_unauthorized_error_when_trying_to_add_company_without_logging_in()
//    {
//        $response = $this->postJson('/api/companies', []);
//
//        $response->assertStatus(401);
//    }
}
