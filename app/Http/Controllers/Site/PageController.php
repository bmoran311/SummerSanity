<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class PageController extends Controller
{    
    public function faqs()
    {                     
        $faqs = Faq::where('firm_id', 1)->orderBy('created_at')->get();                
                  
        return view('site.faqs', compact('faqs'));
    }
}
