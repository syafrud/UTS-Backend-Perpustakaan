<?php

namespace App\Modules\Catalog\Database\Seeders;

use App\Modules\Catalog\Models\Author;
use App\Modules\Catalog\Models\Book;
use App\Modules\Catalog\Models\Category;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect(['Pemrograman', 'Basis Data', 'Jaringan', 'Fiksi', 'Sejarah'])
            ->map(fn ($name) => Category::factory()->create(['name' => $name]));
        $authors = Author::factory(10)->create();

        Book::factory(20)
            ->sequence(fn ($s) => ['category_id' => $categories[$s->index % $categories->count()]->id])
            ->create()
            ->each(fn (Book $book) => $book->syncAuthors($authors->random(rand(1, 3))->pluck('id')->all()));

        // Buku stok 0 untuk demo validasi stok habis.
        Book::factory()->outOfStock()->create([
            'category_id' => $categories[0]->id,
            'title' => 'Laravel 13 untuk Pemula (Stok Habis)',
        ])->syncAuthors([$authors[0]->id]);
    }
}
