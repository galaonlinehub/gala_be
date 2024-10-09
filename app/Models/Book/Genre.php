<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public function bookCategories(){
        return $this->belongsToMany(BookCategory::class,"book_category_genre","genre_id","book_category_id");
    }

    public function books(){
        return $this->belongsToMany(Book::class,"book_genre","book_id","genre_id");
    }
}
