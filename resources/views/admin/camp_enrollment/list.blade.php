<x-app-layout>

<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">
            A <b>Camp Enrollment</b> represents a camper's registration for a specific camp during a particular week.
            <br><br>
            <b>Managing Enrollments:</b>
            View and manage each camper’s schedule, including the camp name, week, and time slot.
            <br><br>
            <b>Pro Tip:</b> Use this table to quickly track which campers are enrolled in which camps and adjust schedules as needed.
        </p>
    </div>
</div>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Camp Enrollments
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Camp Enrollments</li>
        </ol>
    </nav>
</div>

<section class="flex justify-end mb-4">
    <x-create-button href="{{ route('camp_enrollment.create') }}">Add New Enrollment</x-create-button>
</section>

<div class="flex flex-col gap-10">
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto summer-sanity-table sortable clickable-rows">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[180px] xl:pl-11">
                            Camper Name
                        </th>
                        <th class="min-w-[120px]">
                            Camp Name
                        </th>
                        <th class="min-w-[80px]">
                            Week
                        </th>
                        <th class="min-w-[80px]">
                            Time Slot
                        </th>
                        <th class="min-w-[80px]">
                            Booked?
                        </th>
                        <th class="no-sort">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                        <tr class="hover:bg-blue-50 hover:cursor-pointer" data-url="{{ route('camp_enrollment.edit', ['camp_enrollment' => $enrollment]) }}">
                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $enrollment->camper->first_name }} {{ $enrollment->camper->last_name }}</h5>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $enrollment->camp_name }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">Week {{ $enrollment->week->week_number }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">
                                    {{ $enrollment->time_slot }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">
                                    {{ $enrollment->booked ? 'Yes' : 'No' }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5">
                                    <button class="hover:text-primary">
                                        <a href="{{ route('camp_enrollment.edit', ['camp_enrollment' => $enrollment]) }}">
                                            <x-icon-view />
                                        </a>
                                    </button>
                                    <form action="{{ route('camp_enrollment.destroy', ['camp_enrollment' => $enrollment]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this enrollment?')">
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
