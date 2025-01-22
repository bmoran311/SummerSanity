<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardian extends Model
{   
    use HasFactory;    
    protected $table = 'guardian';
    protected $fillable = ['first_name', 'last_name', 'email'];   
}