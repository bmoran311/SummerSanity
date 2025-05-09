<table class="w-full text-xl">
    <thead>
        <tr>
            <th class="px-4 py-3 text-left uppercase text-gray-500 tracking-wider" style="font-family: 'Overpass', sans-serif;">Friend Name</th>
            <th class="px-4 py-3 text-left uppercase text-gray-500 tracking-wider" style="font-family: 'Overpass', sans-serif;">Zip Code</th>
            <th class="px-4 py-3"></th>
        </tr>
    </thead>
    <tbody class="bg-white shadow-md rounded-lg">
        @foreach($friends as $friend)
        <tr class="border-b border-gray-200 text-3xl">
            <td class="px-4 py-3">{{ $friend->first_name }} {{ $friend->last_name }}</td>
            <td class="px-4 py-3">{{ $friend->zip_code }}</td>
            <td class="px-4 py-3 flex items-center justify-end">                
                <form method="POST" action="{{route('friend_front_end.destroy', ['friend' => $friend])}}" 
                    onsubmit="return confirm('Are you sure you want to remove this friend from your calendar? This action cannot be undone—you’ll need to re-invite them if you change your mind.')"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn" style="background: none; border: none; padding: 0;">
                        <img src="/assets/icons/delete.svg" alt="Delete Icon" />
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
