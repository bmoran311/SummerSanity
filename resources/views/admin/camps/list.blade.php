<x-app-layout>

<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">
            A <b>Camp</b> is a structured program or event designed to provide participants with an engaging and enriching experience. Each camp is defined by its unique activity, age group, schedule, and location.
            <br><br>
            <b>Cloning Camps</b>
            If you're setting up a new camp that's similar to an existing one, save time by using the Clone Camp feature!
            <br><br>
            <b>How It Works:</b> Cloning creates an identical copy of the selected camp, allowing you to easily<br> adjust only the dates or other minor details while preserving all other fields.<br><br>
            <b>Why Clone?:</b> Ideal for recurring camps or programs that follow a consistent format across different<br> dates. This ensures consistency while reducing setup time.<br><br>
            <b>Pro Tip:</b> Be sure to review the start date, end date, and registration deadlines after cloning to<br> ensure they are accurate for the new session.
        </p>
    </div>
</div>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
    Camps
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Camps</li>
        </ol>
    </nav>
</div>

<section class="flex justify-end mb-4">
    <x-create-button href="{{ route('camp.create') }}">Add New Camp</x-create-button>
</section>

<div class="flex flex-col gap-10">
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto summer-sanity-table sortable clickable-rows">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px]  xl:pl-11">
                            Camp
                        </th>
                        <th class="min-w-[150px]">
                            Created Date
                        </th>
                        <th class="min-w-[120px]">
                            Status
                        </th>
                        <th class="no-sort">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($camps as $camp)
                        <tr class="hover:bg-blue-50 hover:cursor-pointer" data-url="{{ route('camp.edit', ['camp' => $camp]) }}">
                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $camp->name }}</h5>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $camp->created_at->format('M d, Y') }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">
                                Active
                                </p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5">
                                    <button class="hover:text-primary">
                                        <a href="{{ route('camp.edit', ['camp' => $camp]) }}"><x-icon-view /></a>
                                    </button>
                                    <button class="hover:text-primary">
                                        <a href="{{ route('camp.edit', ['camp' => $camp]) }}?clone=1"><x-icon-view /></a>
                                    </button>
                                    <form action="{{route('camp.destroy', ['camp' => $camp])}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this camp?')">
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
