<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juz extends Model
{
    use HasFactory;
     public $timestamps=false;
     protected $fillable = ['title'];

     public function memorizedJuzs(){
     	return $this->hasMany(MemorizedJuz::class);
     }
}
