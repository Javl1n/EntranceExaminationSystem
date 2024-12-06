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
                'What is the primary reson why insulators are used to coat electrical wires?' 
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
                'What is the energy transformation that occurs when light a match?' 
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
                'What is the main function of the small intistine?' 
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
                'Which organ produces bile to help with the digestion?' 
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
                'The speed of sound is fastest in:' 
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
                'What type if heat transfer occurswhen you touch a hot pan?' 
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
                'What is the term for the process by which water vapor is changed into liquid water?' 
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
            $mathematics->id => [
                'Find the sum of 2/3 and 1/7'
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
                'The proper fractions n/15, n/16, and n/18 have the same numerator greater than 1 and are in simplest form. What is the least value of n?'
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
                'A cookie recipe calls from 1/3 cup of sugar. Which fraction is equivalent to that amount of sugar?'
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
                'Express 18/7 as mixed number.'
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
                'Kim read 3/8 of her book the first night and 1/8 of her book the second night. What fraction of her book is left to read? '
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
                'What is ¼ of the difference of 44 and 8? '
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
                'What is 1/3 of the sum of 99 and 24?'
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
                'Express 3 2/7 as an improper fraction.'
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
                'What is the LCD of the fractions: 2/9, 7/12, and 1/6?'
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
                'What is the simplest form of the fraction 12/44? '
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
            ],
            $english->id => [
                'The jury ___ made their decision. '
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
                'Either the cat or the dog ___ the culprit.'
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
                'The collection of stamps ___ valuable.'
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
                'One of the cookies ___ missing from the jar.'
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
                'The group of friends ___ to the movies every weekend.'
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
                '\'Gullible\' people believe everything told them by the media.'
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
                'The former champion had grown so \'complacent\' that he neglected to practice before the competition.'
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
                'There was a \'riveting\' explanation on light waver during the lesson demonstration. '
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
                'It is indeed a great challenge for mothers to care for \'antsy\' children.'
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
                'An \'eminent\' authority in politics predicted his downfall. '
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
