<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Frank Leimbergh D. Armodia',
            'email' => 'farmodia@gmail.com',
            'password' => Hash::make('admin123')
        ]);
        
        \App\Models\Timer::create([
            'grade' => 7,
            'hours' => 1,
            'minutes' => 30,
            'seconds' => 0
        ]);

        \App\Models\Timer::create([
            'grade' => 11,
            'hours' => 1,
            'minutes' => 0,
            'seconds' => 0
        ]);

        $subjects = [
            'Mathematics', 
            'English', 
            'Science'
        ];

        foreach($subjects as $subject) {
            $category = \App\Models\Category::factory()
            ->has(
                \App\Models\Question::factory(['grade_level' => 7])->count(5)
                ->has(
                    \App\Models\Answer::factory()->count(4)
                    ->sequence(
                        ['letter' => 'A', 'is_correct' => true],
                        ['letter' => 'B', 'is_correct' => false],
                        ['letter' => 'C', 'is_correct' => false],
                        ['letter' => 'D', 'is_correct' => false],
                    )
                )
                // ->sequence(
                //     ['description' =>  "$subject question 1"],
                //     ['description' => "$subject question 2"],
                //     ['description' => "$subject question 3"],
                // )
            )
            ->has(
                \App\Models\Question::factory(['grade_level' => 11])->count(5)
                ->has(
                    \App\Models\Answer::factory()->count(4)
                    ->sequence(
                        ['letter' => 'A', 'is_correct' => true],
                        ['letter' => 'B', 'is_correct' => false],
                        ['letter' => 'C', 'is_correct' => false],
                        ['letter' => 'D', 'is_correct' => false],
                    )
                )
                // ->sequence(
                //     ['description' =>  "$subject question 1"],
                //     ['description' => "$subject question 2"],
                //     ['description' => "$subject question 3"],
                // )
            )
            ->create([
                'title' => $subject,
            ]);
        }
    }
}
