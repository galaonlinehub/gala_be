<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;

class BookController extends Controller
{
    public function store(Request $request){
        try
        {
            $validator = Validator::make($request->all(),[
                "title"=>"required|string",
                "isbn"=>"required|string",
                "author"=>"required|string",
                "type"=>"required",
                "published_date"=>"required"
               
            ]);

            
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $book = Book::create(["title"=>$request->title,"isbn"=>$request->isbn,"author"=>$request->author,"type"=>$request->type,"published_date"=>$request->published_date]);

        return response()->json($book,200);
        }
        catch(Exception $err){
            return response()->json("Error creating book",400);
            }
        }
    

    public function index(){
        $books = Book::all();

        return response()->json($books,200);
    }
    
    
    }

