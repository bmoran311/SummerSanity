<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    use HasFactory;
    protected $table = 'resource_category';
    protected $fillable = ['name', 'sort_order'];	

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
