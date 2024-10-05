<?php

namespace App\Models\K12;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationProgramme extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
}
