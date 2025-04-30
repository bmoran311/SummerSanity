<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;


class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('firm_id', 1)->orderBy('faq_category_id')->orderBy('created_at')->get();
        return view('admin.faq.list', compact('faqs'));
    }

    public function create()
    {
        $categories = FaqCategory::orderBy('sort_order')->get();
        
        return view('admin.faq.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'faq_category_id' => 'required|integer',
        ]);

        $faq = new Faq();
        $faq->firm_id = 1;
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->faq_category_id = $request->input('faq_category_id');        
        $faq->save();

        return back()->with('success', 'Faq Created');
    }

    public function edit(Faq $faq)
    {
        $categories = FaqCategory::orderBy('sort_order')->get();
        return view('admin.faq.form', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'faq_category_id' => 'required|integer',
        ]);

        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->faq_category_id = $request->input('faq_category_id');
        $faq->save();

        return back()->with('success', 'Faq Updated');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with('danger', 'Faq Deleted');
    }
}
