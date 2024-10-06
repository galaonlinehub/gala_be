<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_category_book', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_category')->references("id")->on("book_categories")->onDelete("cascade");
            $table->foreignId('book')->references("id")->on("books")->onDelete("cascade");
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_category_book');
    }
};
