<x-app-layout>

<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">            
        FAQs, or Frequently Asked Questions, are a curated list of common inquiries clients often have about legal services, procedures, and policies.<br> 
        They aim to provide quick, clear, and accessible answers, helping visitors understand their options and make informed decisions without <br>
        having to contact the law firm directly for basic information.
        </p>
    </div>
</div>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        FAQs
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">FAQ</li>
        </ol>
    </nav>
</div>

<section class="flex justify-end mb-4">
    <x-create-button href="{{ route('faq.create') }}">Add FAQ</x-create-button>
</section>

<div class="flex flex-col gap-10">
    <div
        class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto summer-sanity-table sortable">
                <thead>
                <tr class="bg-gray-2 text-left dark:bg-meta-4">
                    <th class="min-w-[220px]  xl:pl-11">
                        Question 
                    </th>
                    <th class="min-w-[150px]">
                        Answer
                    </th>
                    <th class="no-sort">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($faqs as $faq)
                    <tr>
                        <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                            <h5 class="font-medium text-black dark:text-white">{{ $faq->question }}</h5>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                            <h5 class="font-medium text-black dark:text-white">{{ $faq->answer }}</h5>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <div class="flex items-center space-x-3.5">
                                <button class="hover:text-primary">
                                    <a href="{{ route('faq.edit', ['faq' => $faq]) }}">
                                        <x-icon-view/>
                                    </a>
                                </button>
                                <form action="{{route('faq.destroy', ['faq' => $faq])}}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
                                    @method('DELETE')
                                    @csrf
                                    <button class="hover:text-primary">
                                        <x-icon-delete/>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
