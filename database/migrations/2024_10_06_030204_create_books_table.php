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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId("book_category_id")->references("id")->on("book_categories")->onDelete("cascade");
            $table->string('title');
            $table->string('isbn');
            $table->string('author');
            $table->string('cover_photo');
            $table->string('book');
            $table->string('type'); // here we put like academic,non fiction ,fiction
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};