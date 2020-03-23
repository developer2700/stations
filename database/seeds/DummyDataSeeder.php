<?php

use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Populate the database with dummy data for testing.
     * Complete dummy data generation including relationships.
     *
     * @param \Faker\Generator $faker
     */
    public function run(\Faker\Generator $faker)
    {
        // create some headquarters company
        factory(\App\Models\Company::class)->times(10)->create()
            ->each(function ($company) use ($faker) {
                // create some child companies  for them
                factory(\App\Models\Company::class, $faker->numberBetween(0, 10))->create(['parent_company_id' => $company->id]);
            });

        // create some stations
        factory(\App\Models\Station::class, 60)->state('with-company')->create();

    }
}
