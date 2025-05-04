<x-app-layout>

<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">
            Invitations allow guardians to invite friends or family to join Summer Sanity by email. Each invitation tracks the inviter, the email address sent to, the status of the 
            invite (e.g. pending or accepted), and links to the new guardian if the invitee registers.
        </p>
    </div>
</div>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
    Invitations
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li>
                <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
            </li>
            <li class="font-medium text-primary">Invitations</li>
        </ol>
    </nav>
</div>

<div class="flex flex-col gap-10">
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto summer-sanity-table sortable">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px] xl:pl-11">
                            Inviter
                        </th>
                        <th class="min-w-[220px] xl:pl-11">
                            Invitee Email
                        </th>
                        <th class="min-w-[220px] xl:pl-11">
                            Invitee Name
                        </th>
                        <th class="min-w-[150px]">
                            Status
                        </th>
                        <th class="min-w-[150px]">
                            Created Date
                        </th>                                                
                    </tr>
                </thead>
                <tbody>
                    @foreach($invitations as $invitation)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                                <h5 class="font-medium text-black dark:text-white">
                                    {{ $invitation['guardian1_name'] }}
                                </h5>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $invitation['email'] }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $invitation['guardian2_name'] ?? '—' }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <span class="text-black dark:text-white capitalize">{{ ucfirst($invitation['status'] ?? 'pending') }}</span>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <span class="text-black dark:text-white">{{ $invitation['created_at']->format('M d, Y') }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>