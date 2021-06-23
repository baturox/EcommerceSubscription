<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\CompanyPackage;
use App\Models\Package;

class CompanyPackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyPackage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'package_id' => Package::factory(),
            'company_id' => Company::factory(),
            'start_date' => $this->faker->dateTimeThisMonth(),
            'end_date' =>  $this->faker->dateTimeThisMonth(),
            'status' => 'active'
        ];
    }
}
