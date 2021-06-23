<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\User;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'site_url' => $this->faker->url,
            'company_name' => $this->faker->company,
            'email' => $this->faker->safeEmail,
            'password' => Hash::make($this->faker->password),
            'canceled_at' => null,
        ];
    }
}
