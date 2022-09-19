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
            'name' => 'Sport',
            'identifier' => 'sport'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'S/A',
            'identifier' => 's/a',
            'description' => 'Some nuts necessary'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'A/S',
            'identifier' => 'a/s',
            'description' => 'Own protection necessary, some bolts'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'A',
            'identifier' => 'a',
            'description' => 'Some artificial places'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'N',
            'identifier' => 'n',
            'description' => 'Natural protectioon only, no bolts and pegs'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'SS',
            'identifier' => 'ss',
            'description' => 'Sandstone textile protection, sling and UFOs between optional rings'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'T',
            'identifier' => 't',
            'description' => 'Toproping'
        ]);
        ClimbingStyle::factory()->create([
            'name' => 'B',
            'identifier' => 'b',
            'description' => 'Bouldering'
        ]);
    }
}
