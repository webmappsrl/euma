<?php

namespace Database\Seeders;

use App\Models\ClimbingRockType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClimbingRockTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClimbingRockType::factory()->create([
            'name' => 'Limestone',
            'description' => 'All seabed sedimentary fossils'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Granite',
            'description' => 'All quality from white hard - brown poor'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Green hard gneiss',
            'description' => 'Often in natural folds'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Schist',
            'description' => 'Low quality gneiss, flakey and poor'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'General volcanic rocks',
            'description' => 'Low'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Schist',
            'description' => 'Rhyolite, dolerite, tuff'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Quartzite',
            'description' => 'Hard and very slippery, soapy rock'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Conglomerate',
            'description' => 'Like stones in concrete'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Abrasive',
            'description' => 'Very hard and gritty sandstone'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Sandstone',
            'description' => 'Soft grainy rock, takes deep bolts'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Basalt',
            'description' => 'Similar feel to sandstone, ex-volcanic'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Slate',
            'description' => 'Smooth and dark slippery rock, tiny edges'
        ]);
    }
}
