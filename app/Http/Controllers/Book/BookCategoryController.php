<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book\BookCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;

class BookCategoryController extends Controller
{
    public function store(Request $request){
        try
        {
            $validator = Validator::make($request->all(),[
                "name"=>"required",
            ]);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',   
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $bookCategory = BookCategory::create(["name"=>$request->name]);

        return response()->json($bookCategory,200);}
        catch(Exception $err){
            return response()->json("Error creating bookCategory",400);}
        }
    

    public function index(){
        $bookCategorys = BookCategory::all();

        return response()->json($bookCategorys,200);
    }
    
    
    }

