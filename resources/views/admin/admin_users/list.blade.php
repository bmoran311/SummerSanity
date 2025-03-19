<x-app-layout>

<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">
        A <b>Admin User</b> As an Admin, you have full access to manage camps, users, and schedules within the system. You can create, update, and delete camp sessions, 
        oversee user registrations, and ensure all calendars are up to date. Additionally, you can impersonate users to view their schedules and assist with troubleshooting 
        or updates. Use this feature responsibly to help guardians and campers organize their summer plans seamlessly.
        </p>
    </div>
</div>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
    Admin Users
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Admin Users</li>
        </ol>
    </nav>
</div>

<section class="flex justify-end mb-4">
    <x-create-button href="{{ route('admin_user.create') }}">Add New Admin User</x-create-button>
</section>

<div class="flex flex-col gap-10">
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto summer-sanity-table sortable clickable-rows">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[100px]  xl:pl-11">
                            Logo
                        </th>
                        <th class="min-w-[220px]  xl:pl-11">
                            Name
                        </th>
						<th class="min-w-[220px]  xl:pl-11">
                            Email
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
                    @foreach($admin_users as $admin_user)
                     <tr class="hover:bg-blue-50 hover:cursor-pointer" data-url="{{ route('admin_user.edit', ['admin_user' => $admin_user]) }}">
                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                @if(isset($admin_user) && $admin_user->logo)
                                    <img src="{{ asset('storage/' . $admin_user->logo) }}" alt="Logo" width="100">                                
                                @endif
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $admin_user->name }}</h5>
                            </td>
							<td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">{{ $admin_user->email }}</h5>
                            </td>							
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $admin_user->created_at->format('M d, Y') }}</p>
                            </td>                            
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5">
                                    <button class="hover:text-primary">
                                        <a href="{{ route('admin_user.edit', ['admin_user' => $admin_user]) }}"><x-icon-view /></a>
                                    </button>
                                    <form action="{{route('admin_user.destroy', ['admin_user' => $admin_user])}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin_user?')">
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
