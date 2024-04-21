<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Timer::create([
            'grade' => 7,
            'hours' => 0,
            'minutes' => 30,
            'seconds' => 0
        ]);

        \App\Models\Timer::create([
            'grade' => 11,
            'hours' => 0,
            'minutes' => 30,
            'seconds' => 0
        ]);
        
        $mathematics = \App\Models\Category::create([
            'title' => "Mathematics"
        ]);

        $science = \App\Models\Category::create([
            'title' => "Science"
        ]);

        $english = \App\Models\Category::create([
            'title' => "English"
        ]);

        // Grade 7

        // Science Questions

        \App\Models\Question::factory([
                'grade_level' => 7,
                'category_id' => $science->id,
                'description' => 'Which part of a plant is responsible for absorbibng water and minerals from the soil?'
            ])->has(
                \App\Models\Answer::factory()->count(4)
                    ->sequence(
                        [
                            'letter' => 'A', 
                            'is_correct' => false,
                            'description' => 'Leaves'
                        ],
                        [
                            'letter' => 'B', 
                            'is_correct' => false,
                            'description' => 'Stem'
                        ],
                        [
                            'letter' => 'C', 
                            'is_correct' => true,
                            'description' => 'Roots'
                        ],
                        [
                            'letter' => 'D', 
                            'is_correct' => false,
                            'description' => 'Flowers'
                        ],
                    )
        )->create();

        \App\Models\Question::factory([
                'grade_level' => 7,
                'category_id' => $science->id,
                'description' => 'Which on of the following records the distance traveled by a vehicle?'
            ])->has(
                \App\Models\Answer::factory()->count(4)
                    ->sequence(
                        [
                            'letter' => 'A', 
                            'is_correct' => false,
                            'description' => 'Manometer'
                        ],
                        [
                            'letter' => 'B', 
                            'is_correct' => false,
                            'description' => 'Motometer'
                        ],
                        [
                            'letter' => 'C', 
                            'is_correct' => false,
                            'description' => 'Speedometer'
                        ],
                        [
                            'letter' => 'D', 
                            'is_correct' => true,
                            'description' => 'Odometer'
                        ],
                    )
        )->create();

        \App\Models\Question::factory([
                'grade_level' => 7,
                'category_id' => $science->id,
                'description' => 'Which mirror is used for side view in vehicles?'
            ])->has(
                \App\Models\Answer::factory()->count(4)
                    ->sequence(
                        [
                            'letter' => 'A',
                            'is_correct' => true,
                            'description' => 'Convex'
                        ],
                        [
                            'letter' => 'B',
                            'is_correct' => false,
                            'description' => 'Concave'
                        ],
                        [
                            'letter' => 'C', 
                            'is_correct' => false,
                            'description' => 'Plain'
                        ],
                        [
                            'letter' => 'D',
                            'is_correct' => false,
                            'description' => 'None of these'
                        ],
                    )
        )->create();

        \App\Models\Question::factory([
                'grade_level' => 7,
                'category_id' => $science->id,
                'description' => 'A merry-go-round is an example of what kind of motion?'
            ])->has(
                \App\Models\Answer::factory()->count(4)
                    ->sequence(
                        [
                            'letter' => 'A',
                            'is_correct' => false,
                            'description' => 'Straight'
                        ],
                        [
                            'letter' => 'B',
                            'is_correct' => true,
                            'description' => 'Circular'
                        ],
                        [
                            'letter' => 'C', 
                            'is_correct' => false,
                            'description' => 'Vertical'
                        ],
                        [
                            'letter' => 'D',
                            'is_correct' => false,
                            'description' => 'Linear'
                        ],
                    )
        )->create();

        \App\Models\Question::factory([
            'grade_level' => 7,
            'category_id' => $science->id,
            'description' => 'What is the process by which plants use sunlight to convert carbon dioxide and water into glucose and oxygen?'
        ])->has(
                \App\Models\Answer::factory()->count(4)
                    ->sequence(
                        [
                            'letter' => 'A',
                            'is_correct' => true,
                            'description' => 'Photosynthesis'
                        ],
                        [
                            'letter' => 'B',
                            'is_correct' => false,
                            'description' => 'Respiration'
                        ],
                        [
                            'letter' => 'C', 
                            'is_correct' => false,
                            'description' => 'Fermination'
                        ],
                        [
                            'letter' => 'D',
                            'is_correct' => false,
                            'description' => 'Germination'
                        ],
                    )
        )->create();

        \App\Models\Question::factory([
            'grade_level' => 7,
            'category_id' => $science->id,
            'description' => 'Based on which of the following changes is an indicator useful?'
        ])->has(
            \App\Models\Answer::factory()->count(4)
                ->sequence(
                    [
                        'letter' => 'A',
                        'is_correct' => false,
                        'description' => 'Temperature'
                    ],
                    [
                        'letter' => 'B',
                        'is_correct' => false,
                        'description' => 'Physical state'
                    ],
                    [
                        'letter' => 'C', 
                        'is_correct' => true,
                        'description' => 'Color'
                    ],
                    [
                        'letter' => 'D',
                        'is_correct' => false,
                        'description' => 'Pressure'
                    ],
                )
        )->create();
        
        \App\Models\Question::factory([
                'grade_level' => 7,
                'category_id' => $science->id,
                'description' => 'Which of the following instruments is used to check the temperature:'
            ])->has(
                \App\Models\Answer::factory()->count(4)
                    ->sequence(
                        [
                            'letter' => 'A',
                            'is_correct' => true,
                            'description' => 'Thermometer'
                        ],
                        [
                            'letter' => 'B',
                            'is_correct' => false,
                            'description' => 'Voltometer'
                        ],
                        [
                            'letter' => 'C', 
                            'is_correct' => false,
                            'description' => 'Barometer'
                        ],
                        [
                            'letter' => 'D',
                            'is_correct' => false,
                            'description' => 'Speedometer'
                        ],
                    )
        )->create();

        // Math Questions

        // English Questions
        
        
        
        
        
        





        




        // $subjects = [
        //     'Mathematics', 
        //     'English', 
        //     'Science'
        // ];

        // foreach($subjects as $subject) {
        //     $category = \App\Models\Category::factory()
        //     ->has(
        //         \App\Models\Question::factory(['grade_level' => 7])->count(5)
        //         ->has(
        //             \App\Models\Answer::factory()->count(4)
        //             ->sequence(
        //                 ['letter' => 'A', 'is_correct' => true],
        //                 ['letter' => 'B', 'is_correct' => false],
        //                 ['letter' => 'C', 'is_correct' => false],
        //                 ['letter' => 'D', 'is_correct' => false],
        //             )
        //         )
        //         // ->sequence(
        //         //     ['description' =>  "$subject question 1"],
        //         //     ['description' => "$subject question 2"],
        //         //     ['description' => "$subject question 3"],
        //         // )
        //     )
        //     ->has(
        //         \App\Models\Question::factory(['grade_level' => 11])->count(5)
        //         ->has(
        //             \App\Models\Answer::factory()->count(4)
        //             ->sequence(
        //                 ['letter' => 'A', 'is_correct' => true],
        //                 ['letter' => 'B', 'is_correct' => false],
        //                 ['letter' => 'C', 'is_correct' => false],
        //                 ['letter' => 'D', 'is_correct' => false],
        //             )
        //         )
        //         // ->sequence(
        //         //     ['description' =>  "$subject question 1"],
        //         //     ['description' => "$subject question 2"],
        //         //     ['description' => "$subject question 3"],
        //         // )
        //     )
        //     ->create([
        //         'title' => $subject,
        //     ]);
        // }
    }
}
