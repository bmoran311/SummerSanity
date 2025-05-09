<form action="{{ route('dashboard.friends') }}" method="POST">
    @csrf
    @if(isset($c))
        @method('PUT')
    @else
        @method('POST')
    @endif
    <input type="hidden" name="guardian_id" value="{{ $guardian_id }}">
<div style="padding-left: 50px;" class="text-lg">
    <div class="bg-white rouned-lg shadow-lg" style="padding:20px; margin-bottom: 10px;">
        <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-label>First Name</x-label>
                <x-text-input name="first_name" type="text" placeholder="First Name..." class="text-input" value="{{ old('first_name', $c->first_name ?? '') }}"/>
                <x-form-error key="first_name" />
            </div>
            <div>
                <x-label>Last Name</x-label>
                <x-text-input name="last_name" type="text" placeholder="Last Name..." class="text-input" value="{{ old('last_name', $c->last_name ?? '') }}"/>
                <x-form-error key="last_name" />
            </div>            
        </div>
    </div>

    <div class="flex justify-between items-center">
        <div>
            <button type="submit" class="btn btn--sm save-btn" >
                Search for New Friends               
            </button>
        </div>        
    </div>
</div>
</form>
<br><br
@if($searchResults->isNotEmpty())
    <div class="bg-white rounded-lg shadow-lg mt-4 p-4 ml-[50px]">
        <h2 class="text-xl font-bold mb-2">Send a Friend Invite</h2>
        @foreach($searchResults as $potential)
            <div class="flex justify-between items-center border-b py-2">
                <div>{{ $potential->first_name }} {{ $potential->last_name }}</div>    
                <div>{{ $potential->zip_code }}</div> 
                <form action="{{ route('friendship.request') }}" method="POST">
                    @csrf
                    <input type="hidden" name="guardian_id" value="{{ $potential->id }}">
                    <button type="submit" class="btn btn--sm">Invite</button>
                </form>                     
            </div>
        @endforeach
    </div>
@endif



