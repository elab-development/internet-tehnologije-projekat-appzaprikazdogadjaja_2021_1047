<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Event;
use App\Models\Category;
use App\Models\Location;
use App\Models\Reference;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Insert roles into the database
        Role::insert([
            ['name' => 'admin'],
            ['name' => 'moderator'],
            ['name' => 'user']
        ]);

        // Fetch all roles
        $roles = Role::all();

        // Create 10 users using a factory
        $users = User::factory(10)->create();

        // Attach random roles to each user
        $users->each(function ($user) use ($roles) {
            $user->roles()->attach(
                $roles->random(rand(1, 2))->pluck('id')->toArray()
            );
        });
 
         // Call other seeders
        $this->call([
            LocationSeeder::class,
            CategorySeeder::class,
            ReferenceSeeder::class,
            EventSeeder::class,
        ]);
    }
}
