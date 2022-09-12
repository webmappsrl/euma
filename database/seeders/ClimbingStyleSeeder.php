<?php

namespace Database\Seeders;

use App\Models\ClimbingStyle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClimbingStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClimbingStyle::factory()->create([
            'name' => 'Sport'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'S/A',
            'description' => 'Some nuts necessary'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'A/S',
            'description' => 'Own protection necessary, some bolts'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'A',
            'description' => 'Some artificial places'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'N',
            'description' => 'Natural protectioon only, no bolts and pegs'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'SS',
            'description' => 'Sandstone textile protection, sling and UFOs between optional rings'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'T',
            'description' => 'Toproping'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'B',
            'description' => 'Bouldering'
        ]);
    }
}
