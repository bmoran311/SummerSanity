<table class="w-full text-xl">
    <thead>
        <tr>
            <th class="px-4 py-3 text-left uppercase text-gray-500 tracking-wider" style="font-family: 'Overpass', sans-serif;">Camper Name</th>
            <th class="px-4 py-3 text-left uppercase text-gray-500 tracking-wider" style="font-family: 'Overpass', sans-serif;">Birth Date</th>
            <th class="px-4 py-3"></th>
        </tr>
    </thead>
    <tbody class="bg-white shadow-md rounded-lg">
        @foreach($campers as $camper)
        <tr class="border-b border-gray-200 text-3xl">
            <td class="px-4 py-3">{{ $camper->first_name }} {{ $camper->last_name }}</td>
            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($camper->birth_date)->format('F j Y') }}</td>
            <td class="px-4 py-3 flex items-center justify-end">
                <a href="{{ route('camper_front_end.edit', ['camper' => $camper]) }}" style="margin-right: 10px; display:inline-block; margin-top: -7px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                        <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                    </svg>
                </a>

                <form method="POST" action="{{route('camper_front_end.destroy', ['camper' => $camper])}}" onsubmit="return confirm('Are you sure you want to delete this camper?')" >
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
