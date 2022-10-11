<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MemberSeeder::class,
            UserSeeder::class,
            ClimbingStyleSeeder::class,
            ClimbingRockTypeSeeder::class,
            HutSeeder::class,
            ClimbingRockAreaSeeder::class,
            TrailsSeeder::class
        ]);
    }
}
