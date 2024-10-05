<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProgrammeController extends Controller
{
    public function store(Request $request){
        try
        {
            $validator = Validator::make($request->all(),[
                "name"=>"required",
                "duration"=>"required",
                "department"=>"required",
            ]);

            $errorField = [];
            if ($validator->fails()){
                $errors = $validator->errors();
                
                if ($errors->has("name") && $errors->has("duration") && $errors->has("department") ){
                    $errorField["name"] = $errors->first("name");
                    $errorField["duration"] = $errors->first("duration");
                    $errorField["department"] = $errors->first("department");
                }

                elseif( $errors->has("name") ){
                    $errorField["name"] = $errors->first("name");
                }

                elseif( $errors->has("duration") ){
                    $errorField["duration"] = $errors->first("duration");
                }

                elseif( $errors->has("department") ){
                    $errorField["department"] = $errors->first("department");
                }

                

                return response()->json($errorField,422);
            }

            $programme = Programme::create(["name"=>$request->name,"department"=>$request->department,"duration"=>$request->duration]);

        return response()->json($programme,200);}
        catch(Exception $err){
            return response()->json("Error creating department",400);}
        }
    

    public function index(){
        
        $programmes = Programme::all();

        return response()->json($programmes,200);
    }
    
}
