<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        $subjects = ['Mathematics', 'English', 'Science', 'Filipino', 'History'];
        
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
        
        foreach($subjects as $subject) {
            \App\Models\Category::factory()->create([
                'title' => $subject,
            ]);
        }
    }
}
