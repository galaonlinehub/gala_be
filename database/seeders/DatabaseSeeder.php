<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\College;
use App\Models\Department;
use App\Models\Programme;
use App\Models\University;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $facilities = file_get_contents(database_path('json/countries.json'));
        $data_facilities = json_decode($facilities, true);

        Address::insert($data_facilities);

        $university = University::create(["name"=>"University of Dar es Salaam","region_of_residence"=>214]);
        
        $colleges = file_get_contents(database_path('json/departments.json'));
        $data_colleges = json_decode($colleges, true);

       foreach($data_colleges as $college_data){
            $college = College::create(["name"=>$college_data["name"],"university"=>$university->id]);

            foreach($college_data["departments"] as $department_data){
                Department::create(["name"=>$department_data,"college"=>$college->id]);
            }
       } 

        $programmes = file_get_contents(database_path('json/colleges.json'));
        $data_programmes = json_decode($programmes, true);

        foreach($data_programmes as $prog_data){
            

            foreach($prog_data["programs"] as $programme_data){
                Programme::create(["name"=>$programme_data["name"],"duration"=>$programme_data["duration"],"department"=>$programme_data["department"]]);
            }
        }

     

    }
}
