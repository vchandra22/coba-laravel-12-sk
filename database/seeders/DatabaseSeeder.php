<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 8000; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
            ]);

            Employee::create([
                'user_id' => $user->id,
                'phone' => $faker->phoneNumber,
                'birth_place' => $faker->city,
                'birth_date' => $faker->date(),
                'address' => $faker->address,
                'hire_date' => $faker->date(),
            ]);
        }
    }
}
