<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = file_get_contents(database_path('json/books.json'));
        $data_categories = json_decode($categories, true);

        BookCategory::insert($data_categories);

        $directoryPath = 'json/Archeology';

        // Get all PDF files in the directory
        $files = Storage::files($directoryPath);

        // Loop through each file and store metadata in the database
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                // Get the file name
                $fileName = pathinfo($file, PATHINFO_BASENAME);

                // Store the file info in the database
                // Pdf::create([
                //     'file_name' => $fileName,
                //     'file_path' => $file,
                // ]);

                // $this->info("Imported: {$fileName}");
            }
        }


    }
}
