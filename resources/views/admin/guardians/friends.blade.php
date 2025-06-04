<x-app-layout>

<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">
        A <b>Friend</b> in our system is a trusted connection between two guardians that allows them to <b>view each other's summer camp schedules</b>. 
        When you add someone as a friend, they gain access to your child’s camp plans, and you can see theirs. This makes coordinating summer 
        activities effortless, ensuring that kids can attend camps together and parents can stay in sync.
        </p>
    </div>
</div>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
    Friends of {{ $guardian->first_name }} {{ $guardian->last_name }} 
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Members</li>
        </ol>
    </nav>
</div>

<form method="POST" action="{{ route('guardian.assign_friends', ['guardian_id' => $guardian->id]) }}">
@csrf

    <section class="flex justify-end mb-4">      
        <button
            class="btn-primary"
            type="submit"
        >Assign Friends</button>
    </section>

    <div class="flex flex-col gap-10">
        <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto summer-sanity-table sortable clickable-rows">
                    <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">          
                            <th class="min-w-[50px]  xl:pl-11">
                                Select
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guardians as $guardian)
                            <tr class="hover:bg-blue-50 hover:cursor-pointer">
                                <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                    <input type="checkbox" name="select_user[]" value="{{ $guardian->id }}"
                                        @if($guardian->is_friend) checked @endif
                                    >
                                </td>                            
                                <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 class="font-medium text-black dark:text-white">{{ $guardian->last_name }}, {{ $guardian->first_name }}</h5>
                                </td>
                                <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 class="font-medium text-black dark:text-white">{{ $guardian->email }}</h5>
                                </td>
                                <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 class="font-medium text-black dark:text-white">{{ $guardian->phone_number }}</h5>
                                </td>                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
</x-app-layout>
