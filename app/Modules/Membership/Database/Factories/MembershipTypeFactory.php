<?php

namespace App\Modules\Membership\Database\Factories;

use App\Modules\Membership\Models\MembershipType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MembershipType> */
class MembershipTypeFactory extends Factory
{
    protected $model = MembershipType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'max_loans' => 3,
            'loan_days' => 7,
            'fine_per_day' => 1000,
        ];
    }
}
