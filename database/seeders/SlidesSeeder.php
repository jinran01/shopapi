<?php

namespace Database\Seeders;

use App\Models\Slides;
use Illuminate\Database\Seeder;

class SlidesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slides::factory()->count(4)->create();
    }
}
