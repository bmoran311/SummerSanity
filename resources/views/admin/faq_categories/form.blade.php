<x-app-layout>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
    FAQ Categories
    </h2>
    <nav>
    <ol class="flex items-center gap-2">
        <li>
        <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
        </li>
        <li class="font-medium text-primary"><a class="font-medium" href="{{ route('faq_category.index') }}">FAQ Categories</a></li>
    </ol>
    </nav>
</div>

<div class="grid grid-cols-5 gap-8">
    <div class="col-span-5 xl:col-span-3">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                {{ isset($faq_category) ? 'Edit' : 'Create' }} FAQ Category
                </h3>
            </div>
            <div class="p-7">
                <form action="{{ isset($faq_category) ? route('faq_category.update', $faq_category->id) : route('faq_category.store') }}" method="POST">
                    @csrf
                    @if(isset($faq_category))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>FAQ Category Name</x-label>
                            <x-text-input name="name" type="text" placeholder="FAQ Category Name..." class="text-input" value="{{ old('name', $faq_category->name ?? '') }}"/>
                            <x-form-error key="name" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-4.5">
                            <a href="{{ route('faq_category.index') }}"
                                class="btn-white"
                                type="submit">
                                Cancel
                            </a>
                            <button
                                class="btn-primary"
                                type="submit"
                            >Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
