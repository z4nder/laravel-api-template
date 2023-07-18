<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);


        \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'gustavo@gmail.com',
            'password' => Hash::make('123123123'),
        ])->assignRole('manager'); #TODO Create consts to role in user model OR ENUM sla or config

    }
}