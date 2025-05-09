<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- "Overpass" Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="/style.css" />
        <link rel="stylesheet" href="/calendar.css" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css" />
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/weekSelect/weekSelect.js"></script> --}}

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

		<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <title>Dashboard - Summer Sanity</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="dashboard">
        <nav class="nav nav--dashboard">
                <div class="logo">
                    <a href="/"><img src="/assets/logo.svg" alt="Summer Sanity Logo" /></a>
                </div>
				<ul class="nav__links">
					<li class="nav__link"><a href="/my-dashboard">Dashboard</a></li>
					<li class="nav__link"><a href="/campers">Campers</a></li>
                    <li class="nav__link"><a href="/friends">Friends</a></li>					
				</ul>
				<div class="profile">
					<!---<img src="assets/megan-p-profile-pic.jpg" alt="User Profile Picture" />--->
					<span>{{ Auth::guard('guardian')->user()->first_name }} {{ Auth::guard('guardian')->user()->last_name }}</span>
				</div>
            </nav>
            <div class="container campers-page-container">                
                <div class="camper-header">
                    <h2 style="font-size: 2.75rem;">Your Friends</h2>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-2">
                       @include('dashboard.friends._list')
                    </div>
                    <div>
                        @include('dashboard.friends._form')
                    </div>
                </div>
            </div>
        </div>     
        @if(session('success'))
			<script>
				window.addEventListener("load", function () {
					if (typeof toastr !== "undefined") {
						toastr.options = {
							"closeButton": true,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"timeOut": "4000"
						};
						toastr.success("{{ session('success') }}");
					}
				});
			</script>
		@endif	   
    </body>
</html>
