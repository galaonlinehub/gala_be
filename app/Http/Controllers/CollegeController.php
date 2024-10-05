<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;

class CollegeController extends Controller
{
    public function store(Request $request){
        try
        {
            $validator = Validator::make($request->all(),[
                "name"=>"required",
                "abbreviation"=>"required"
            ]);

            $errorField = [];
            if ($validator->fails()){
                $errors = $validator->errors();
                
                if ($errors->has("name") && $errors->has("abbreviation") && $errors->has("university")){
                    $errorField["name"] = $errors->first("name");
                    $errorField["abbreviation"] = $errors->first("abbreviation");
                }

                elseif( $errors->has("name") ){
                    $errorField["name"] = $errors->first("name");
                }

                elseif( $errors->has("abbreviation") ){
                    $errorField["abbreviation"] = $errors->first("abbreviation");
                }

                elseif( $errors->has("university") ){
                    $errorField["university"] = $errors->first("university");
                }

                return response()->json($errorField,422);
            }

            $college = College::create(["name"=>$request->name,"abbreviation"=>$request->abbreviation,"university"=>$request->university]);

        return response()->json($college,200);}
        catch(Exception $err){
            return response()->json("Error creating college",400);}
        }
    

    public function index(){
        $colleges = College::all();

        return response()->json($colleges,200);
    }
    
    
    }

