<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\K12\EducationProgramme;
use App\Models\K12\Extracurricular;
use App\Models\K12\Grade;
use App\Models\K12\Level;
use App\Models\K12\Subject;

class K12seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $k12 = file_get_contents(database_path('json/k12.json'));
        $data_k12 = json_decode($k12, true);

        EducationProgramme::insert($data_k12["program"]);
        Level::insert($data_k12["levels"]);
        Grade::insert($data_k12["grades"]);
        Subject::insert($data_k12["subjects"]);
        Extracurricular::insert($data_k12["extracurricular"]);
    }
}
