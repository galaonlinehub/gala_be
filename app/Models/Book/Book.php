<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book\BookCategory;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ["title","book_path"];

    public function bookCategories(){
       return  $this->belongsToMany(BookCategory::class,"book_category_book","book_id","book_category_id");
    }

    public function genres(){
       return  $this->belongsToMany(Genre::class,"book_genre","book_id","genre_id");
    }

    // public function courses(){
    //     $this->belongsToMany(BookCategory::class,"book_category_book","book_id","book_category_id");
    // }

    // public function subjects(){
    //     $this->belongsToMany(BookCategory::class,"book_category_book","book_id","book_category_id");
    // }
    
}
