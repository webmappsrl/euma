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
            'identifier' => 'limestone',
            'description' => 'All seabed sedimentary fossils'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Granite',
            'identifier' => 'granite',
            'description' => 'All quality from white hard - brown poor'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Green hard gneiss',
            'identifier' => 'green-hard-gneiss',
            'description' => 'Often in natural folds'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Schist',
            'identifier' => 'schist',
            'description' => 'Low quality gneiss, flakey and poor'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'General volcanic rocks',
            'identifier' => 'general-volcanic-rocks',
            'description' => 'Rhyolite, dolerite, tuff'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Quartzite',
            'identifier' => 'quartzite',
            'description' => 'Hard and very slippery, soapy rock'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Conglomerate',
            'identifier' => 'conglomerate',
            'description' => 'Like stones in concrete'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Hard Sandstone',
            'identifier' => 'hard-sandstone',
            'description' => 'Very hard and gritty sandstone, abrasive'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Sandstone',
            'identifier' => 'sandstone',
            'description' => 'Soft grainy rock, takes deep bolts'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Basalt',
            'identifier' => 'basalt',
            'description' => 'Similar feel to sandstone, ex-volcanic'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Slate',
            'identifier' => 'slate',
            'description' => 'Smooth and dark slippery rock, tiny edges'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Rutile',
            'identifier' => 'rutile',
            'description' => 'rutile'
        ]);
        ClimbingRockType::factory()->create([
            'name' => 'Igneous rocks',
            'identifier' => 'igneous-rocks',
            'description' => 'Igneous rocks'
        ]);
    }
}
