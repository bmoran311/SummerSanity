<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory;
    protected $table = 'faq_category';
    protected $fillable = ['name', 'sort_order'];	

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
}
