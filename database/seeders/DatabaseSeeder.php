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
        
        foreach($subjects as $subject) {
            \App\Models\Category::factory()->create([
                'title' => $subject,
            ]);
        }
    }
}
