<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Multimedia extends Model
{   
    use HasFactory;    
    protected $table = 'multimedia';
    protected $fillable = ['headline'];	
}
