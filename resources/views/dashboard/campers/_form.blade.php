<form action="{{ isset($c) ? route('camper.update', $c->id) : route('camper.store') }}" method="POST">
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
            <div>
                <x-label>Birth Date</x-label>
                <input
                    name="birth_date"
                    value="{{ old('birth_date', $c->birth_date ?? '') }}"
                    class="form-datepicker w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                    placeholder="mm/dd/yyyy"
                    data-class="flatpickr-right"
                />
                <x-form-error key="birth_date" />
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center">
        <div>
            <button type="submit" class="btn btn--sm save-btn" >
                @isset($c)
                    Save Changes
                @else
                    Add My Kid
                @endisset
            </button>
        </div>
        @isset($c)
        <div>
            <a href="{{ route('dashboard.campers') }}" >
                Cancel Edits
            </a>
        </div>
        @endisset
    </div>
</div>
</form>


