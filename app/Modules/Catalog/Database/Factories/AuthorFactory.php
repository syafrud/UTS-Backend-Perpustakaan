<?php

namespace App\Modules\Catalog\Database\Factories;

use App\Modules\Catalog\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Author> */
class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'bio' => fake()->sentence(12),
        ];
    }
}
