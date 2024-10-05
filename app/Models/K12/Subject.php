<?php

namespace App\Models\K12;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = ["name","level"];

    public function levels(){
        return $this->belongsTo(Level::class,"level");
    }

}
