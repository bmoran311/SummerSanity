<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Camper extends Model
{   
    use HasFactory;    
    protected $table = 'camper';
    protected $fillable = ['first_name', 'last_name'];   
}