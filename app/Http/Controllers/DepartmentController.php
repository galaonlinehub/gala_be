<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Exception;

class DepartmentController extends Controller
{

    public function store(Request $request){
        try
        {
            $validator = Validator::make($request->all(),[
                "name"=>"required",
                "college"=>"required"
            ]);

            $errorField = [];
            if ($validator->fails()){
                $errors = $validator->errors();
                
                if ($errors->has("name") && $errors->has("college") ){
                    $errorField["name"] = $errors->first("name");
                    $errorField["college"] = $errors->first("college");
                }

                elseif( $errors->has("name") ){
                    $errorField["name"] = $errors->first("name");
                }

                elseif( $errors->has("college") ){
                    $errorField["college"] = $errors->first("college");
                }

                

                return response()->json($errorField,422);
            }

            $department = Department::create(["name"=>$request->name,"college"=>$request->college]);

        return response()->json($department,200);}
        catch(Exception $err){
            return response()->json("Error creating department $err",400);}
        }
    

    public function index(){
        
        $departments = Department::all();

        return response()->json($departments,200);
    }
    
    
}
