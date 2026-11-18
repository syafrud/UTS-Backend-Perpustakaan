<?php

namespace App\Modules\Membership\Database\Seeders;

use App\Modules\Membership\Models\Member;
use App\Modules\Membership\Models\MembershipType;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        $types = collect([
            ['name' => 'Reguler', 'max_loans' => 2, 'loan_days' => 7, 'fine_per_day' => 1000],
            ['name' => 'Mahasiswa', 'max_loans' => 3, 'loan_days' => 14, 'fine_per_day' => 500],
            ['name' => 'Premium', 'max_loans' => 5, 'loan_days' => 21, 'fine_per_day' => 2000],
        ])->map(fn ($t) => MembershipType::create($t));

        $types->each(fn ($type) => Member::factory(5)->for($type, 'type')->create());

        // Anggota nonaktif untuk demo error handling.
        Member::factory()->inactive()->for($types[0], 'type')->create(['name' => 'Anggota Nonaktif (Demo)']);
    }
}
