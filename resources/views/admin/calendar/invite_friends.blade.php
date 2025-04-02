<x-app-layout>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Invite Friends to Summer Sanity
    </h2>
</div>

<div class="grid grid-cols-5 gap-8">
    <div class="col-span-5 xl:col-span-3">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Let’s Coordinate Summer Plans – Join Me on Summer Sanity!
                </h3>
            </div>
            <div class="p-7">
                <p class="mb-4 text-lg">
                    Hey <span class="font-semibold">(Friend)</span>,
                </p>
                <p class="mb-4 text-gray-700">
                    I just set up my summer schedule on <strong>Summer Sanity</strong>, and I’d love for you to join me! This app makes it super easy to organize and share summer camp schedules with friends, so we can coordinate plans and make sure our kids get to spend time together.
                </p>
                <p class="mb-4 text-gray-700 font-semibold">Here’s a snapshot of our tentative summer schedule:</p>
                
                <img src="{{ asset('storage/' . str_replace('public/', '', $screenshotPath)) }}" class="screenshot mb-4" alt="Camp Calendar">
                
                <p class="mb-4 text-gray-700">With <strong>Summer Sanity</strong>, you can:</p>
                <ul class="list-disc list-inside mb-4 text-gray-700">
                    <li>Plan and manage summer camps and activities in one place</li>
                    <li>See which friends are attending the same camps</li>
                    <li>Share and compare schedules with ease</li>
                </ul>
                <p class="mb-6 text-gray-700">Click below to sign up and start planning your summer with me!</p>
                <a href="http://www.summersanity.com/register" class="px-6 py-2 bg-blue-600 text-white rounded-md text-lg hover:bg-blue-700">Join Summer Sanity</a>
                
                <p class="mt-6 text-gray-700">Let’s make this summer stress-free and fun for the kids!</p>
                <br>
                <p class="text-gray-900 font-semibold">See you in the app,<br>Brian Moran</p>
                
                <form action="{{ route('send-invites') }}" method="POST" class="mt-8">
                    @csrf
                    @if(isset($admission))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    <input type="hidden" name="screenshot" value="{{ $screenshotPath }}">           
                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="w-full">
                            <x-label>Enter Friends' Emails (comma-separated)</x-label>
                            <x-text-input name="emails" type="text" placeholder="friend1@example.com, friend2@example.com" class="text-input" value="{{ old('emails') }}"/>
                            <x-form-error key="emails" />
                        </div>
                    </div>                    
                    <div class="flex justify-end gap-4.5">
                        <a href="{{ route('admission.index') }}"
                            class="btn-white"
                            type="button">
                            Cancel
                        </a>
                        <button
                            class="btn-primary"
                            type="submit">
                            Send Invites
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
