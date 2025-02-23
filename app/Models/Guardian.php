<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardian extends Model
{   
    use HasFactory;    
    protected $table = 'guardian';
    protected $fillable = ['first_name', 'last_name', 'email'];   

    public function friends()
    {
        return $this->hasMany(Friend::class, 'guardian_id1')->orWhere('guardian_id2', $this->id);
    }
}