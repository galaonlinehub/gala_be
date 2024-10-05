<?php

namespace App\Models\K12;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = ["name","program"];

    public function subjects(){
        return $this->hasMany(Subject::class,'level');
    }

    public function grades(){
        return $this->hasMany(Grade::class,'level');
    }

}
