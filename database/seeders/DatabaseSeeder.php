<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Catalog\Database\Seeders\CatalogSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create(['name' => 'Admin Perpustakaan', 'email' => 'admin@perpus.test']);
        User::factory()->create(['name' => 'Pustakawan', 'email' => 'pustakawan@perpus.test']);

        $this->call([
            CatalogSeeder::class,
        ]);
    }
}
