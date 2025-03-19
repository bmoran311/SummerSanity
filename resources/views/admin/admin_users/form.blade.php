<x-app-layout>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
    Admin Users
    </h2>
    <nav>
    <ol class="flex items-center gap-2">
        <li>
        <a class="font-medium" href="{{ route('dashboard') }}">Dashboard /</a>
        </li>
        <li class="font-medium text-primary"><a class="font-medium" href="{{ route('admin_user.index') }}">Admin Users</a></li>
    </ol>
    </nav>
</div>

<div class="grid grid-cols-5 gap-8">
    <div class="col-span-5 xl:col-span-4">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                {{ isset($admin_user) ? 'Edit' : 'Create' }} Admin User
                </h3>
            </div>
            <div class="p-7">
                <form action="{{ isset($admin_user) ? route('admin_user.update', $admin_user->id) : route('admin_user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($admin_user))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
							<x-label>Name</x-label>
							<x-text-input name="name" type="text" placeholder="Name..." class="text-input" value="{{ old('name', $admin_user->name ?? '') }}"/>
							<x-form-error key="name" />
                        </div>                        
                    </div>

					<div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
							<x-label>Email</x-label>
							<x-text-input name="email" type="text" placeholder="Email..." class="text-input" value="{{ old('email', $admin_user->email ?? '') }}"/>
							<x-form-error key="email" />
                        </div>
                        <div>
							<x-label>Password</x-label>
							<x-text-input name="password" type="password" placeholder="***********" class="text-input"/>
							<x-form-error key="password" />
                        </div>
                    </div>

                    <div class="mb-5.5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
							<x-label>Logo</x-label>
                            <input type="file" class="form-control" id="logo" name="logo">
                            @if(isset($admin_user) && $admin_user->logo)
                                <img src="{{ asset('storage/' . $admin_user->logo) }}" alt="Headshot" width="100">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remove_logo" name="remove_logo" value="1">
                                    <label for="remove_logo" class="form-check-label">Remove Logo</label>
                                </div>
                            @endif
                            <x-form-error key="logo" />
                        </div>                       
                    </div>

                    <div class="mb-5.5 flex flex-col gap-5.5 sm:flex-row">
                        <div class="flex justify-end gap-4.5">
                            <a href="{{ route('admin_user.index') }}"
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
