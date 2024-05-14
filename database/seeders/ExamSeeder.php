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

        $questionsList = [
            $mathematics->id => [
                'Which of the following materials is a good conductor of both electricity and heat?'
                => [
                    'A' => [
                        'description' => 'Glass', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'Wood', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'Rubber', 
                        'isCorrect' => false
                    ],
                    'D' => [
                        'description' => 'Copper', 
                        'isCorrect' => true
                    ],
                ],
                'Why are metals generally good conductors of electricity?' 
                => [
                    'A' => [
                        'description' => 'They are insulators', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'They have a low melting point', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'They have a high resistance to electric current', 
                        'isCorrect' => false],
                    'D' => [
                        'description' => 'They contain large number of free electrons', 
                        'isCorrect' => true
                    ],
                ],
                'What is the main function of the ozone layer in the Earth\'s atmosphere?' 
                => [
                    'A' => [
                        'description' => 'Producing oxygen', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'Preventing acid rain', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'Regulating temperature', 
                        'isCorrect' => false],
                    'D' => [
                        'description' => 'Absorbing ultraviolet radiation', 
                        'isCorrect' => true
                    ],
                ],
            ],
            $science->id => [
                'Which of the following materials is a good conductor of both electricity and heat?'
                => [
                    'A' => [
                        'description' => 'Glass', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'Wood', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'Rubber', 
                        'isCorrect' => false
                    ],
                    'D' => [
                        'description' => 'Copper', 
                        'isCorrect' => true
                    ],
                ],
                'Why are metals generally good conductors of electricity?' 
                => [
                    'A' => [
                        'description' => 'They are insulators', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'They have a low melting point', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'They have a high resistance to electric current', 
                        'isCorrect' => false],
                    'D' => [
                        'description' => 'They contain large number of free electrons', 
                        'isCorrect' => true
                    ],
                ],
                'What is the main function of the ozone layer in the Earth\'s atmosphere?' 
                => [
                    'A' => [
                        'description' => 'Producing oxygen', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'Preventing acid rain', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'Regulating temperature', 
                        'isCorrect' => false],
                    'D' => [
                        'description' => 'Absorbing ultraviolet radiation', 
                        'isCorrect' => true
                    ],
                ],
            ],
            $english->id => [
                'Which of the following materials is a good conductor of both electricity and heat?'
                => [
                    'A' => [
                        'description' => 'Glass', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'Wood', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'Rubber', 
                        'isCorrect' => false
                    ],
                    'D' => [
                        'description' => 'Copper', 
                        'isCorrect' => true
                    ],
                ],
                'Why are metals generally good conductors of electricity?' 
                => [
                    'A' => [
                        'description' => 'They are insulators', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'They have a low melting point', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'They have a high resistance to electric current', 
                        'isCorrect' => false],
                    'D' => [
                        'description' => 'They contain large number of free electrons', 
                        'isCorrect' => true
                    ],
                ],
                'What is the main function of the ozone layer in the Earth\'s atmosphere?' 
                => [
                    'A' => [
                        'description' => 'Producing oxygen', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'Preventing acid rain', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'Regulating temperature', 
                        'isCorrect' => false],
                    'D' => [
                        'description' => 'Absorbing ultraviolet radiation', 
                        'isCorrect' => true
                    ],
                ],
                'Whats is the main function of the ozone layer in the Earth\'s atmosphere?' 
                => [
                    'A' => [
                        'description' => 'Producings oxygen', 
                        'isCorrect' => false
                    ],
                    'B' => [
                        'description' => 'Preventings acid rain', 
                        'isCorrect' => false
                    ],
                    'C' => [
                        'description' => 'Regulatings temperature', 
                        'isCorrect' => false],
                    'D' => [
                        'description' => 'Absorbings ultraviolet radiation', 
                        'isCorrect' => true
                    ],
                ],
            ],
        ];
        foreach($questionsList as $subjectId => $subjectQuestions) {
            foreach ($subjectQuestions as $questionDescription => $answers) {
                $question11 = \App\Models\Question::create([
                        'grade_level' => 11,
                        'category_id' => $subjectId,
                        'description' => $questionDescription
                ]);

                $question7 = \App\Models\Question::create([
                    'grade_level' => 7,
                    'category_id' => $subjectId,
                    'description' => $questionDescription
                ]);
                foreach($answers as $letter => $answer) {
                    $question11->answers()->create([
                        'letter' => $letter,
                        'description' => $answer['description'],
                        'is_correct' => $answer['isCorrect']
                    ]);
                    $question7->answers()->create([
                        'letter' => $letter,
                        'description' => $answer['description'],
                        'is_correct' => $answer['isCorrect']
                    ]);
                }
            }
        }
    }
}
