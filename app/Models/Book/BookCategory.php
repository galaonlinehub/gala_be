<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function books(){
        return $this->belongsToMany(Book::class,"book_category_book","book_category_id","book_id");
    }

    public function genres(){
        return $this->belongsToMany(Genre::class,"book_category_genre","book_category_id","genre_id");
    }
}
