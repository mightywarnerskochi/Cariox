<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with the Cariox website content.
     */
    public function run(): void
    {
        $this->call([
            CarioxSiteContentSeeder::class,
            CarioxProductCatalogueSeeder::class,
            CarioxPlaceholderCleanupSeeder::class,
            CarioxTestimonialSeeder::class,
        ]);
    }
}
