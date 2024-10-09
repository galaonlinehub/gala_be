<?php

namespace Database\Seeders;

use App\Models\Book\BookCategory;
use App\Models\Book\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


    $baseDirectoryPath = public_path('storage/books');

    try {
        
        $categories = File::directories($baseDirectoryPath);
    
        foreach ($categories as $categoryPath) {
            
            $categoryName = basename($categoryPath);

            
            $files = File::files($categoryPath);
        
            $bookFiles = [];
        
            foreach ($files as $file) {
                
            
                if (strtolower($file->getExtension()) === 'pdf') {
                $fileName = $file->getFilename();
                
                
                $existingBook = Book::where('title', $fileName)
                                    ->first();
                                   
                if (!$existingBook) {
                    $bookFiles[] = [
                        "title" => pathinfo($fileName, PATHINFO_FILENAME), // Title without extension
                        "book_path" => "storage/books/" . $categoryName . "/" . $fileName,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ];
                }
            }
        }

            $category = BookCategory::create(["name"=>$categoryName,"created_at"=>now(),"updated_at"=>now()]);
            
            
            if (!empty($bookFiles)) {
                Book::insert($bookFiles);
                
                $bookTitles = array_column($bookFiles, 'title');

                
                $books = Book::whereIn('title', $bookTitles)->get();
            

                $category->books()->attach($books->pluck('id')->toArray());
            }
        }
    
        } catch (\Exception $e) {
        
        Log::error("Error processing books: " . $e->getMessage());
}


    }
}
