<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\CompanyPayment;

class CompanyPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyPayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'price' => $this->faker->randomFloat(0, 10, 200),
            'status' => $this->faker->randomElement(["success","fail"]),
        ];
    }
}
