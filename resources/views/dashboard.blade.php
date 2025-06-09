<x-app-layout>
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
	<div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
		<div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-primary dark:fill-white" viewBox="0 0 24 24" fill="currentColor">
				<path d="M15 14a3 3 0 100-6 3 3 0 000 6zM9 14a3 3 0 100-6 3 3 0 000 6zM2 19a6 6 0 0112 0v1H2v-1zm10 0a6 6 0 0110 0v1H12v-1z" />
			</svg>
		</div>
		<div class="mt-4 flex items-end justify-between">
			<div>
				<h4 class="text-title-md font-bold text-black dark:text-white">{{ $guardianCount }}</h4>
				<span class="text-sm font-medium">Members</span>
			</div>
		</div>
	</div>
	<div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
		<div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-primary dark:fill-white" viewBox="0 0 24 24" fill="currentColor">
				<path d="M15 14a3 3 0 100-6 3 3 0 000 6zM9 14a3 3 0 100-6 3 3 0 000 6zM2 19a6 6 0 0112 0v1H2v-1zm10 0a6 6 0 0110 0v1H12v-1z" />
			</svg>
		</div>
		<div class="mt-4 flex items-end justify-between">
			<div>
				<h4 class="text-title-md font-bold text-black dark:text-white">{{ $camperCount }}</h4>
				<span class="text-sm font-medium">Campers</span>
			</div>
		</div>
	</div>
	<div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
		<div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-primary dark:fill-white" viewBox="0 0 24 24" fill="currentColor">
				<path d="M15 14a3 3 0 100-6 3 3 0 000 6zM9 14a3 3 0 100-6 3 3 0 000 6zM2 19a6 6 0 0112 0v1H2v-1zm10 0a6 6 0 0110 0v1H12v-1z" />
			</svg>
		</div>
		<div class="mt-4 flex items-end justify-between">
			<div>
				<h4 class="text-title-md font-bold text-black dark:text-white">{{ $friendCount }}</h4>
				<span class="text-sm font-medium">Friendships</span>
			</div>
		</div>
	</div>
	<div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark">
		<div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-primary dark:fill-white" viewBox="0 0 24 24" fill="currentColor">
				<path d="M15 14a3 3 0 100-6 3 3 0 000 6zM9 14a3 3 0 100-6 3 3 0 000 6zM2 19a6 6 0 0112 0v1H2v-1zm10 0a6 6 0 0110 0v1H12v-1z" />
			</svg>
		</div>
		<div class="mt-4 flex items-end justify-between">
			<div>
				<h4 class="text-title-md font-bold text-black dark:text-white">{{ $campEnrollmentCount }}</h4>
				<span class="text-sm font-medium">Plans</span>
			</div>
		</div>
	</div>
</div>

<div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
	<!-- ====== Chart Three Start -->
	@include('partials.admin.chart-03')
	<!-- ====== Chart Three End -->

	<!-- ====== Map One Start -->
	@include('partials.admin.map-01')
	<!-- ====== Map One End -->
</div>
</x-app-layout>
