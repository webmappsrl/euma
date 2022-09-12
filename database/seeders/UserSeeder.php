<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Webmapp',
            'email' => 'team@webmapp.it',
            'password' => bcrypt('webmapp'),
        ])->markEmailAsVerified();
        User::factory()->create([
            'name' => 'EUMA',
            'email' => 'euma@webmapp.it',
            'password' => bcrypt('webmapp'),
        ])->markEmailAsVerified();
    }
}
