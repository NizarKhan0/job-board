<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Job;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkApplication;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Nizar',
            'email' => 'nizar@example.com',
        ]);

        //Create random user
        User::factory(300)->create();

        //Generate users with random employer
        $users = User::all()->shuffle();

        for($i = 0; $i < 20; $i++) {
            Employer::factory()->create([
                'user_id' => $users->pop()->id
            ]);
        }

        //Generate employers
        $employers = Employer::all();

        for($i = 0; $i < 100; $i++) {
            Work::factory()->create([
                'employer_id' => $employers->random()->id
            ]);
        }

        //Generate random work applications
        foreach ($users as $user) {
            $works = Work::inRandomOrder()->take(rand(0, 4))->get();

            foreach ($works as $work) {
                WorkApplication::factory()->create([
                    'work_id' => $work->id,
                    'user_id' => $user->id
                ]);
            }
        }

    }
}