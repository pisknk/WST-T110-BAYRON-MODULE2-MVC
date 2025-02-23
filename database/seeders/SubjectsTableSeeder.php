<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubjectModel;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    public function run()
    {
        // Delete all records
        SubjectModel::query()->delete();

        // Reset auto-increment (only if you use an auto-increment ID, not necessary if subject_code is the primary key)
        DB::statement('ALTER TABLE subjects AUTO_INCREMENT = 1;');
        
        // Seed subjects
        $subjects = [
            ['subject_code' => 'CAP2', 'name' => 'Capstone 2'],
            ['subject_code' => 'SIA2', 'name' => 'Systems Integration and Architecture 2'],
            ['subject_code' => 'GENS', 'name' => 'Gender and Society'],
            ['subject_code' => 'WEBS', 'name' => 'Web Systems and Technologies'],
            ['subject_code' => 'APPD', 'name' => 'Application Development'],
            ['subject_code' => 'IAS', 'name' => 'Information Assurance and Security 2'],
            ['subject_code' => 'RIZZ', 'name' => 'Life and Works of Rizal'],
            ['subject_code' => 'ASIA', 'name' => 'ASEAN Studies'],
        ];

        SubjectModel::insert($subjects);
    }
}
