<?php

namespace App\Modules\Membership\Database\Factories;

use App\Modules\Membership\Models\Member;
use App\Modules\Membership\Models\MembershipType;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Member> */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'membership_type_id' => MembershipType::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('08##########'),
            'address' => fake()->address(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
