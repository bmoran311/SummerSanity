@include('partials.head')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Summer Sanity') }}</title>

        <script src="https://cdn.jsdelivr.net/gh/tofsjonas/sortable@latest/dist/sortable.min.js"></script>
        <link href="https://cdn.jsdelivr.net/gh/tofsjonas/sortable@latest/sortable-base.min.css" rel="stylesheet" />

		<link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
		<script src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>


        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
	<body class="antialiased bg-slate-100" x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }">

    <div class="flex h-screen overflow-hidden">
		<div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        
        <header>      
            <x-header.header />            
        </header>
        
        <main>
			<br><br>
				<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
					@yield('content')
				</div>
			<br><br>
        </main>
		<footer>      
            <x-footer.footer />            
		</footer>
    </div>
	  	         
    @stack('foot')
    </body>
</html>


