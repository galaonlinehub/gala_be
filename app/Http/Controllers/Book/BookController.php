<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Models\Book\BookCategory;
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
                "book_path"=>"required|string"
               
            ]);

            
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $book = Book::create(["title"=>$request->title]);

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

    public function show(Book $book){
        return response()->json($book,200);
    }

    public function showCategoryBooks(BookCategory $bookCategory){
        
        return response()->json($bookCategory->books,200); 

    }

    
    
    }

