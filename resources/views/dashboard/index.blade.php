@extends('layouts.dashboard')

@section('content')
    <div class="md:flex md:items-center">
        <div class="filter__friends">
            @foreach($friends_campers as $friends_camper)
                <label>
                    <input type="checkbox" class="friend-child-checkbox" id="friend{{ $loop->iteration }}" checked />
                    {{ $friends_camper->first_name }} {{ $friends_camper->last_name }}
                </label>
            @endforeach
        </div>
        <div class="flex items-center space-x-4 px-8 md:px-0" style="margin-right: 75px; min-width: 375px;">
            <span class="text-2xl shrink-0">Summer Calendar</span>
            <div class="event-card user-child confirmed">
                <div class="card__content" style="text-align: center;">
                    <span class="event-name">Booked</span>
                </div>
            </div>
            <div class="event-card user-child tentative">
                <div class="card__content" style="text-align: center;">
                    <span class="event-name">Tentative</span>
                </div>
            </div>
        </div>
    </div>

    <div id="summer-calendar"></div>

    <!-- Notes Modal Overlay -->
    <div id="notesModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-lg relative">
            <div class="mb-4">
                <span id="notesText" class="whitespace-pre-wrap block text-gray-800"></span>
            </div>
            <div class="text-right">
                <button onclick="closeNotesModal()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function showNotesModal(text) {
            document.getElementById('notesText').textContent = text.replace(/\\n/g, '\n');
            document.getElementById('notesModal').classList.remove('hidden');
        }

        function closeNotesModal() {
            document.getElementById('notesModal').classList.add('hidden');
        }

        function handleNotesClick(e) {
            const notes = e.currentTarget.getAttribute('data-notes') || '';
            showNotesModal(notes.replace(/\\n/g, '\n'));
        }
    </script>

    @include('partials.create_enrollment_modal')
    @include('partials.build_calendar')
@endsection
