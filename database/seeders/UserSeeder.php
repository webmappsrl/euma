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
            'is_admin' => true,
        ])->markEmailAsVerified();
        User::factory()->create([
            'name' => 'EUMA',
            'email' => 'euma@webmapp.it',
            'password' => bcrypt('webmapp'),
            'is_admin' => true,
        ])->markEmailAsVerified();
        User::factory()->create([
            'name' => 'Andrej Stritar',
            'email' => 'astritar@gmail.com',
            'password' => bcrypt('webmapp'),
            'member_id' => 2
        ])->markEmailAsVerified();
        User::factory()->create([
            'name' => 'hellenic',
            'email' => 'hellenic@webmapp.it',
            'password' => bcrypt('webmapp'),
            'member_id' => 10
        ])->markEmailAsVerified();
        User::factory()->create([
            'name' => 'Hrvoje Gold',
            'email' => 'hgold@fpz.unizg.hr',
            'password' => bcrypt('webmapp'),
            'member_id' => 6
        ])->markEmailAsVerified();
        User::factory()->create([
            'name' => 'Bojan Rotovnik',
            'email' => 'bojan.rotovnik@european-mountaineers.eu',
            'password' => bcrypt('webmapp123'),
            'is_admin' => true,
        ])->markEmailAsVerified();
        User::factory()->create([
            'name' => 'Petr Jandík',
            'email' => 'jandik@cds.cz',
            'password' => bcrypt('webmapp123'),
            'is_admin' => true,
        ])->markEmailAsVerified();
        User::factory()->create([
            'name' => 'Czech Member',
            'email' => 'czech@webmapp.it',
            'password' => bcrypt('webmapp123'),
            'member_id' => 7
        ])->markEmailAsVerified();
        User::factory()->create([
            'name' => 'Andreas Aschaber',
            'email' => 'andreas.aschaber@european-mountaineers.eu',
            'password' => bcrypt('Mountain47'),
            'is_admin' => true,
        ])->markEmailAsVerified();
    }
}
