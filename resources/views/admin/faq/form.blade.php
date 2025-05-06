<x-app-layout>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            FAQ
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
                </li>
                <li class="font-medium text-primary"><a class="font-medium"
                                                        href="{{ route('faq.index') }}">FAQ</a></li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-5 gap-8">
        <div class="col-span-5 xl:col-span-3">
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        {{ isset($faq) ? 'Edit' : 'Create' }} FAQ
                    </h3>
                </div>
                <div class="p-7">
                    <form action="{{ isset($faq) ? route('faq.update', $faq->id) : route('faq.store') }}"
                          method="POST">
                        @csrf
                        @if(isset($faq))
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif
                        <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                            <div class="w-full">                         
                                <x-label>Question</x-label>
                                <textarea
                                    name="question"
                                    rows="6"
                                    placeholder="Question..."
                                    class="w-full rounded-lg border-[1.5px] border-primary bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:bg-form-input dark:text-white"
                                >{{ old('question', $faq->question ?? '') }}</textarea>
                                <x-form-error key="question"/>
                            </div>                                              
                        </div>                       
                        <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                            <div class="w-full">
                                <x-label>Answer</x-label>
                                <textarea
                                    name="answer"
                                    rows="6"
                                    placeholder="Answer..."
                                    class="w-full rounded-lg border-[1.5px] border-primary bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:bg-form-input dark:text-white"
                                >{{ old('answer', $faq->answer ?? '') }}</textarea>
                                <x-form-error key="answer"/>  
                            </div>                                              
                        </div>
                        <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="w-full">
                                <x-label>Category</x-label>                                
                                <select name="faq_category_id" id="faq_category_id" class="text-input">                               
                                    <option value="">Select Type</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ (isset($faq) && $faq->faq_category_id === $category->id) || (old('faq_category_id') == $category->id) ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>                                
                                <x-form-error key="faq_category_id"/>
                            </div>
                        </div>
                        <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                            <div class="flex justify-end gap-4.5">
                                <a href="{{ route('faq.index') }}"
                                   class="btn-white"
                                   type="submit">
                                    Cancel
                                </a>
                                <button
                                    class="btn-primary"
                                    type="submit"
                                >Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
