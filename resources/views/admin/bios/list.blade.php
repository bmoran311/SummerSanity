<x-app-layout>

<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">
        A <b>Bio</b> provides a summary of an individual's professional background, achievements, and expertise. This information is essential for <br>
        showcasing qualifications, experience, and unique strengths to clients and colleagues.<br><br>

        When writing a bio, you'll select the attorney's Practice Area, Education, Admission, Language, <br>
        Level, Membership, License, Awards, News, Engagements and Multimedia.
        </p>
    </div>
</div>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
    Bios
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Bios</li>
        </ol>
    </nav>
</div>

<section class="flex justify-end mb-4">
    <x-create-button href="{{ route('bio.create') }}">Add New Bio</x-create-button>
</section>

<div class="flex flex-col gap-10">
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto summer-sanity-table sortable clickable-rows">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[100px]  xl:pl-11">
                            Headshot
                        </th>
                        <th class="min-w-[220px]  xl:pl-11">
                            Name
                        </th>
						<th class="min-w-[220px]  xl:pl-11">
                            Email
                        </th>
						<th class="min-w-[220px]  xl:pl-11">
                            Phone
                        </th>
                        <th class="min-w-[150px]">
                            Created Date
                        </th>                        
                        <th class="no-sort">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bios as $bio)
                     <tr class="hover:bg-blue-50 hover:cursor-pointer" data-url="{{ route('bio.edit', ['bio' => $bio]) }}">
                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                @if(isset($bio) && $bio->headshot)
                                    <img src="{{ asset('storage/' . $bio->headshot) }}" alt="Headshot" width="100">                                
                                @endif
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $bio->last_name }}, {{ $bio->first_name }}</h5>
                            </td>
							<td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $bio->email }}</h5>
                            </td>
							<td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $bio->phone_number }}</h5>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $bio->created_at->format('M d, Y') }}</p>
                            </td>                            
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5">
                                    <button class="hover:text-primary">
                                        <a href="{{ route('bio.edit', ['bio' => $bio]) }}"><x-icon-view /></a>
                                    </button>
                                    <form action="{{route('bio.destroy', ['bio' => $bio])}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this bio?')">
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
