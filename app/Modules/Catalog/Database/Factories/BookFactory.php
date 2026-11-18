<?php

namespace App\Modules\Catalog\Database\Factories;

use App\Modules\Catalog\Models\Book;
use App\Modules\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Book> */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'title' => rtrim(fake()->sentence(3), '.'),
            'isbn' => fake()->unique()->isbn13(),
            'publisher' => fake()->company(),
            'published_year' => fake()->numberBetween(1990, 2026),
            'stock' => fake()->numberBetween(1, 10),
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(['stock' => 0]);
    }
}
