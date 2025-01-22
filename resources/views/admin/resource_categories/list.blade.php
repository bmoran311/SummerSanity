<x-app-layout>

<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">
        <b>Resource categories</b> on a legal website are designed to organize valuable, client-facing content into distinct formats tailored for different user needs.<br>
        These resources help educate potential clients, establish the firm’s authority, and provide actionable insights in easily digestible formats. <br>
        The firms comes pre-seeded with White Papers, Guides, Checklists, Infographics, Quick Reference Guides and Brochures but can be overwritten as needed.
        </p>
    </div>
</div>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Resource Categories
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Resource Categories</li>
        </ol>
    </nav>
</div>

<section class="flex justify-end mb-4">
    <x-create-button href="{{ route('resource_category.create') }}">Add New Resource Category</x-create-button>
</section>

<div class="flex flex-col gap-10">
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto summer-sanity-table sortable">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px]  xl:pl-11">
                            Name
                        </th>
                        <th class="min-w-[150px]">
                            Created Date
                        </th>
                        <th class="min-w-[120px]">
                            Status
                        </th>
                        <th class="no-sort">
                            Sort
                        </th>
                        <th class="no-sort">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resource_categories as $resource_category)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $resource_category->name }}</h5>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $resource_category->created_at->format('M d, Y') }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">
                                Active
                                </p>
                            </td>                            
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark max-w-[10px]">
                                <div class="flex items-center space-x-1">
                                    @if(!$loop->first)
                                        <a href="{{ route('orderResourceCategory',[ 'direction' => 'up', 'id' => $resource_category->id, 'currPos' => $resource_category->sort_order]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                            </svg>
                                        </a>
                                        @endif
                                    @if(!$loop->last)
                                        <a href="{{ route('orderResourceCategory',[ 'direction' => 'down', 'id' => $resource_category->id, 'currPos' => $resource_category->sort_order]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5">
                                    <button class="hover:text-primary">
                                        <a href="{{ route('resource_category.edit', ['resource_category' => $resource_category]) }}"><x-icon-view /></a>
                                    </button>
                                    <form action="{{route('resource_category.destroy', ['resource_category' => $resource_category])}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @method('DELETE')
                                        @csrf
                                        <button class="hover:text-primary">
                                            <x-icon-delete />
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
