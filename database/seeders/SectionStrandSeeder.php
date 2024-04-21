<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionStrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sections
        \App\Models\Section::create([
            'letter' => 'A',
            'description' => 'Genesis'
        ]);

        \App\Models\Section::create([
            'letter' => 'B',
            'description' => 'Exodus'
        ]);

        \App\Models\Section::create([
            'letter' => 'C',
            'description' => 'Leviticus'
        ]);

        \App\Models\Section::create([
            'letter' => 'D',
            'description' => 'Deutoronomy'
        ]);

        // Strands
        \App\Models\Strand::create([
            'title' => 'STEM',
            'description' => 'Science, Technology, Engineering and Mathematics'
        ]);

        \App\Models\Strand::create([
            'title' => 'ABM',
            'description' => 'Accounting and Business Management'
        ]);

        \App\Models\Strand::create([
            'title' => 'HUMSS',
            'description' => 'Humanities and Social Sciences'
        ]);
    }
}
