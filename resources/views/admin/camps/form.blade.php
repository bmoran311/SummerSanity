<x-app-layout>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Camps
    </h2>
    <nav>
    <ol class="flex items-center gap-2">
        <li>
        <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
        </li>
        <li class="font-medium text-primary"><a class="font-medium" href="{{ route('camp.index') }}">Camps</a></li>
    </ol>
    </nav>
</div>

@if(request()->has('clone'))
<div class="mb-8">
    <div class="bg-yellow-50 text-center border border-yellow-200 p-4 shadow-lg shadow-slate-200 max-w-5xl mx-auto" role="alert">
        <p class="text-sm leading-5 text-yellow-700">
            <h3 style="color: #2c3e50; font-weight: bold; margin-bottom: 10px;">How Cloning Works:</h3>
            
            <ul style="list-style-type: disc; margin-left: 20px;">
                <li>The Clone feature will automatically duplicate your camp's details for a specified number of weeks.</li>
                <li>The start and end dates will adjust based on the same weekday pattern as the original camp (e.g., Monday–Thursday).</li>
                <li>Registration end dates and early bird pricing deadlines will also shift accordingly.</li>
                <li>The camp name will update to reflect the new date range (e.g., <i>"CSA Goal Keepers Academy July 14-17"</i> becomes <i>"CSA Goal Keepers Academy July 21-24"</i>).</li>
            </ul>
        </p>
    </div>
</div>
@endif

<div class="grid grid-cols-5 gap-8">
    <div class="col-span-5 xl:col-span-3">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                {{ $page_title}}
                </h3>
            </div>
            <div class="p-7">
                <form action="{{ $post_route }}@if(request()->has('clone'))?clone=1 @endif" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="{{ $form_method }}">  
                    @if(request()->has('clone'))
                        <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                            <div class="w-full">
                                <x-label>Number of Weeks to Clone</x-label>
                                <select name="numberOfWeeks" class="text-input">
                                    <option value="">Select Capacity</option>
                                    @for ($i = 0; $i <= 30; $i++)
                                        <option value="{{ $i }}" {{ old('numberOfWeeks') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <x-form-error key="numberOfWeeks " />
                            </div>
                        </div>
                    @endif                
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>Camp Name</x-label>
                            <x-text-input name="name" type="text" placeholder="Name..." class="text-input" value="{{ old('name', $camp->name ?? '') }}"/>
                            <x-form-error key="name" />
                        </div>                        
                    </div>
                    <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="w-full">
                            <x-label>Start Date</x-label>
                            <input
								name="start_date"
								value="{{ old('start_date', $camp->start_date ?? '') }}"
								class="form-datepicker w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
								placeholder="mm/dd/yyyy"
								data-class="flatpickr-right"
							/>
                            <x-form-error key="start_date" />                           
                        </div>
                        <div class="w-full">
                            <x-label>End Date</x-label>
                            <input
								name="end_date"
								value="{{ old('end_date', $camp->end_date ?? '') }}"
								class="form-datepicker w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
								placeholder="mm/dd/yyyy"
								data-class="flatpickr-right"
							/>
                            <x-form-error key="end_date" />                           
                        </div>
                    </div>	
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>Shift</x-label>
                            <select name="shift" class="text-input">
								<option value="">Select a Shift</option>								
								<option value="Morning"
									{{ old('shift', $camp->shift ?? '') == "Morning" ? 'selected' : '' }}>
									Morning
								</option>
								<option value="Afternoon"
									{{ old('shift', $camp->shift ?? '') == "Afternoon" ? 'selected' : '' }}>
									Afternoon
								</option>								
								<option value="Night"
									{{ old('shift', $camp->shift ?? '') == "Night" ? 'selected' : '' }}>
									Night
								</option>
								<option value="All-day"
									{{ old('shift', $camp->shift ?? '') == "All-day" ? 'selected' : '' }}>
									All-day
								</option>
							</select>
							<x-form-error key="shift" />
                        </div>                       
                        <div class="w-full">
                            <x-label>Activity</x-label>
                            <select name="activity" class="text-input">
								<option value="">Select a Activity</option>								
								<option value="Basketball"
									{{ old('activity', $camp->activity ?? '') == "Basketball" ? 'selected' : '' }}>
									Basketball
								</option>
								<option value="Tennis"
									{{ old('activity', $camp->activity ?? '') == "Tennis" ? 'selected' : '' }}>
									Tennis
								</option>								
								<option value="Golf"
									{{ old('activity', $camp->activity ?? '') == "Golf" ? 'selected' : '' }}>
									Golf
								</option>
								<option value="Soccer"
									{{ old('activity', $camp->activity ?? '') == "Soccer" ? 'selected' : '' }}>
									Soccer
								</option>
							</select>
							<x-form-error key="activity" />
                        </div>
					</div>   
                    <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="w-full">
                            <x-label>Event Start Time</x-label>                           
                            <x-text-input name="start_time" type="time" id="time" placeholder="Start Time..." class="text-input" value="{{ old('start_time', $camp->start_time ?? '') }}"/>                                                        
                        </div>
                        <div class="w-full">
                            <x-label>Event End Time</x-label>
                            <x-text-input name="end_time" type="time" id="time" placeholder="End Time..." class="text-input" value="{{ old('end_time', $camp->end_time ?? '') }}"/>                                                        
                        </div>
                    </div> 
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>Min Age</x-label>
                            <select name="min_age" class="text-input">
                                <option value="">Select Minimum Age</option>
                                @for ($i = 0; $i <= 100; $i++)
                                    <option value="{{ $i }}" {{ old('min_age', $camp->min_age ?? '') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
							<x-form-error key="min_age" />
                        </div>                       
                        <div class="w-full">
                            <x-label>Max Age</x-label>
                            <select name="max_age" class="text-input">
                                <option value="">Select Maximum Age</option>
                                @for ($i = 0; $i <= 100; $i++)
                                    <option value="{{ $i }}" {{ old('max_age', $camp->max_age ?? '') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
							<x-form-error key="max_age" />
                        </div>
                        <div class="w-full">
                            <x-label>Max Capacity</x-label>
                            <select name="capacity" class="text-input">
                                <option value="">Select Capacity</option>
                                @for ($i = 0; $i <= 300; $i++)
                                    <option value="{{ $i }}" {{ old('capacity', $camp->capacity ?? '') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
							<x-form-error key="capacity" />
                        </div>
					</div> 
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>Registrastion Link</x-label>
                            <x-text-input name="registration_link" type="text" placeholder="Registration Link..." class="text-input" value="{{ old('registration_link', $camp->registration_link ?? '') }}"/>
							<x-form-error key="registration_link" />
                        </div>
					</div>
                    <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="w-full">
                            <x-label>Price</x-label>
                            <x-text-input name="price" type="text" placeholder="Price..." class="text-input" value="{{ old('price', $camp->price ?? '') }}"/>                                                        
                        </div>
                        <div class="w-full">
                            <x-label>Registration End Date</x-label>
                            <input
								name="registration_end_date"
								value="{{ old('registration_end_datert_date', $camp->registration_end_date ?? '') }}"
								class="form-datepicker w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
								placeholder="mm/dd/yyyy"
								data-class="flatpickr-right"
							/>
                            <x-form-error key="registration_end_date" />                           
                        </div>
                    </div> 
                    <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="w-full">
                            <x-label>Early Bird Price</x-label>
                            <x-text-input name="early_bird_price" type="text" placeholder="Early Bird Price..." class="text-input" value="{{ old('early_bird_price', $camp->early_bird_price ?? '') }}"/>                                                        
                        </div>
                        <div class="w-full">
                            <x-label>Early Bird Price End Date</x-label>
                            <input
								name="early_bird_price_end_date"
								value="{{ old('early_bird_price_end_date', $camp->early_bird_price_end_date ?? '') }}"
								class="form-datepicker w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
								placeholder="mm/dd/yyyy"
								data-class="flatpickr-right"
							/>
                            <x-form-error key="early_bird_price_end_date" />                           
                        </div>
                    </div> 
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>Venue</x-label>
                            <x-text-input name="location" type="text" placeholder="Location..." class="text-input" value="{{ old('location', $camp->location ?? '') }}"/>
							<x-form-error key="location" />
                        </div>
					</div>	
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>Address</x-label>
                            <x-text-input name="location_address" type="text" placeholder="Address..." class="text-input" value="{{ old('location_address', $camp->location_address ?? '') }}"/>
							<x-form-error key="location_address" />
                        </div>
					</div>	
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>City</x-label>
                            <x-text-input name="location_city" type="text" placeholder="City..." class="text-input" value="{{ old('location_city', $camp->location_city ?? '') }}"/>
							<x-form-error key="location_city" />
                        </div>
                        <div class="w-full">
                            <x-label>State</x-label>
                            <select name="location_state" class="text-input">
								<option value="">Select a State</option>
								@foreach($states as $state)
									<option value="{{ $state->abbreviation }}"
										{{ old('state', $camp->location_state ?? '') == $state->abbreviation ? 'selected' : '' }}>
										{{ $state->name }}
									</option>
								@endforeach
							</select>
						    <x-form-error key="state" />                           
                        </div>
                        <div class="w-full">
                            <x-label>Zip</x-label>
                            <x-text-input name="location_zip" type="text" placeholder="Zip" class="text-input" value="{{ old('location_zip', $camp->location_zip ?? '') }}"/>
							<x-form-error key="location_zip" />
                        </div>
					</div>					                                   					                
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>Description</x-label>
                            <textarea
                                name="description"
                                rows="6"
                                placeholder="Summary"
                                class="w-full rounded-lg border-[1.5px] border-primary bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:bg-form-input dark:text-white"
                            >{{ old('description', $camp->description ?? '') }}</textarea>                            
                        </div>
                    </div>                   
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">                        
                        <div class="flex justify-end gap-4.5">
                            <a href="{{ route('camp.index') }}"
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
