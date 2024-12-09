<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{   
    use HasFactory;    
    protected $table = 'level';
    protected $fillable = ['name'];
}