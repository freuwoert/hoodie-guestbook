<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Maurice',
            'email' => 'maurice.freuwoert@gmail.com',
            'password' => bcrypt('password'),
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
