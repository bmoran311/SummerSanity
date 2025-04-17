<x-app-layout>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Campers
    </h2>
    <nav>
    <ol class="flex items-center gap-2">
        <li>
        <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
        </li>
        <li class="font-medium text-primary"><a class="font-medium" href="{{ route('camper.index') }}">Campers</a></li>
    </ol>
    </nav>
</div>

<div class="grid grid-cols-5 gap-8">
    <div class="col-span-5 xl:col-span-4">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                {{ isset($bio) ? 'Edit' : 'Create' }} Camper
                </h3>
            </div>
            <div class="p-7">
                <form action="{{ isset($camper) ? route('camper.update', $camper->id) : route('camper.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($camper))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif                    
                    <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
							<x-label>First Name</x-label>
							<x-text-input name="first_name" type="text" placeholder="First Name..." class="text-input" value="{{ old('first_name', $camper->first_name ?? '') }}"/>
							<x-form-error key="first_name" />
                        </div>                        
                        <div>
							<x-label>Last Name</x-label>
							<x-text-input name="last_name" type="text" placeholder="Last Name..." class="text-input" value="{{ old('last_name', $camper->last_name ?? '') }}"/>
							<x-form-error key="last_name" />
                        </div>
                    </div>

					<div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
							<x-label>Guardian</x-label>
                            @php
                                $selected_guardian_id = old('guardian_id', $camper->guardian_id ?? request('guardian_id'));
                            @endphp
							<select name="guardian_id" id="guardian_id" required class="w-full rounded-md border border-gray-300 p-2">     
                                <option value="">Select Guardian</option>               
                                @foreach($guardians as $guardian)
                                <option value="{{ $guardian->id }}" 
                                    {{ $selected_guardian_id == $guardian->id ? 'selected' : '' }}>
                                    {{ $guardian->first_name }} {{ $guardian->last_name }} 
                                </option>
                                @endforeach
                            </select>
                        </div> 
                        <div>
							<x-label>Birth Date</x-label>
							<input
                                name="birth_date"
                                value="{{ old('birth_date', $camper->birth_date ?? '') }}"
                                class="form-datepicker w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                placeholder="mm/dd/yyyy"
                                data-class="flatpickr-right"
                            />
                            <x-form-error key="birth_date" /> 
                        </div>                            
                    </div>
                                                    
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="flex justify-end gap-4.5">
                            <a href="{{ route('bio.index') }}"
                                class="btn-white"
                                type="submit">
                                Cancel
                            </a>
                            <button
                                class="btn-primary"
                                type="submit"
                            >Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
