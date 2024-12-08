<x-app-layout>

 <!-- Breadcrumb Start -->
<div
    class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
>
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
    Languages
    </h2>

    <nav>
    <ol class="flex items-center gap-2">
        <li>
        <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
        </li>
        <li class="font-medium text-primary">Languages</li>
    </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<section class="flex justify-end mb-4">
    <x-create-button href="{{ route('language.create') }}">Add New Language</x-create-button>
</section>

<!-- ====== Table Section Start -->
<div class="flex flex-col gap-10">
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto taylor-table">
        <thead>
            <tr class="bg-gray-2 text-left dark:bg-meta-4">
                <th
                    class="min-w-[220px]  xl:pl-11"
                >
                    Language
                </th>
                <th
                    class="min-w-[150px]"
                >
                    Created Date
                </th>
                <th
                    class="min-w-[120px]"
                >
                    Status
                </th>
                <th>
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($languages as $language)
            <tr>
                <td
                    class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11"
                >
                    <h5 class="font-medium text-black dark:text-white">{{ $language->name }}</h5>
                </td>
                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                    <p class="text-black dark:text-white">{{ $language->created_at->format('M d, Y') }}</p>
                </td>
                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                    <p
                    class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success"
                    >
                    Active
                    </p>
                </td>
                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                    <div class="flex items-center space-x-3.5">
                    <button class="hover:text-primary">
                        <x-icon-view />
                    </button>
                    <button class="hover:text-primary">
                        <x-icon-delete />
                    </button>
                    <button class="hover:text-primary">
                        <x-icon-download />
                    </button>
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