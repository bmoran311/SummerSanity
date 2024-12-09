<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class License extends Model
{   
    use HasFactory;    
    protected $table = 'license';
    protected $fillable = ['name'];
}
