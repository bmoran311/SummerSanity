@if($pending_friend_requests->isNotEmpty())    
<table class="w-full text-xl">
    <thead>
        <tr>
            <th class="px-4 py-3 text-left uppercase text-gray-500 tracking-wider" style="font-family: 'Overpass', sans-serif;">Friend Name</th>
            <th class="px-4 py-3 text-left uppercase text-gray-500 tracking-wider" style="font-family: 'Overpass', sans-serif;">Email</th>
            <th class="px-4 py-3 text-left uppercase text-gray-500 tracking-wider" style="font-family: 'Overpass', sans-serif;">Zip Code</th>
            <th class="px-4 py-3"></th>
        </tr>
    </thead>
    <tbody class="bg-white shadow-md rounded-lg">
        @foreach($pending_friend_requests as $friend)
        @php
            $campers = \App\Models\Camper::where('guardian_id', $friend->id)->get();
        @endphp
        <tr class="border-b border-gray-200 text-3xl">
            <td class="px-4 py-3">{{ $friend->first_name }} {{ $friend->last_name }}
                @if($campers->isNotEmpty())
                    <div class="mt-2 ml-6 text-lg text-gray-600">
                        @foreach($campers as $camper)
                            <div class="mb-1">
                                {{ $camper->first_name }} {{ $camper->last_name }}
                                <span class="text-sm text-gray-400">({{ \Carbon\Carbon::parse($camper->birth_date)->age }} yrs old)</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </td>
            <td class="px-4 py-3">{{ $friend->email }}</td>
            <td class="px-4 py-3">{{ $friend->zip_code }}</td>
            <td class="px-4 py-3 align-middle">
                <div class="flex items-center justify-end gap-x-2 h-full">
                    <form method="POST" action="{{ route('friends.accept') }}" onsubmit="return confirm('Accept this friend request?')">
                        @csrf
                        <input type="hidden" name="from" value="{{ $friend->id }}">
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-md hover:bg-green-600">
                            Accept
                        </button>
                    </form>

                    <form method="POST" action="{{ route('friends.reject') }}" onsubmit="return confirm('Are you sure you want to reject this friend request?')">
                        @csrf
                        <input type="hidden" name="from" value="{{ $friend->id }}">
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600">
                            Reject
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <div class="text-center text-lg text-gray-600 mt-4">
        You have no pending friend requests at this time.
    </div>
@endif
