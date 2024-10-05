<?php

namespace App\Http\Controllers;
use App\Models\College;
use App\Models\University;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class UniversityController extends Controller
{
    public function store(Request $request){
        try
        {
            $validator = Validator::make($request->all(),[
                "name"=>"required",
                "region_of_residence"=>"required",
                
            ]);

            
            if ($validator->fails()){
                $errors = $validator->errors();
                $errorField = [];
                if ($validator->fails()){
                    $errors = $validator->errors();
                    
                    if ($errors->has("name") && $errors->has("region_of_residence")){
                        $errorField["name"] = $errors->first("name");
                        $errorField["region_of_residence"] = $errors->first("region_of_residence");
                    }
    
                    elseif( $errors->has("name") ){
                        $errorField["name"] = $errors->first("name");
                    }
    
                    elseif( $errors->has("region_of_residence") ){
                        $errorField["region_of_residence"] = $errors->first("region_of_residence");
                    }

                    elseif( $errors->has("university") ){
                        $errorField["university"] = $errors->first("university");
                    }
    
    
                    return response()->json($errorField,422);
                }
            }

            $university = University::create(["name"=>$request->name,"region_of_residence"=>$request->region_of_residence]);

        return response()->json($university,200);}
        catch (QueryException $e) {
            
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['message' => 'This university already exists.'], 409);
            }
            
            return response()->json(['message' => 'An error occurred while creating the university.'], 500);
        }
        catch(Exception $err){
            return response()->json("Error creating University $err",400);}
        
    }
    

    public function index(){
        $universities = University::all();

        return response()->json($universities,200);
    }
    
}
