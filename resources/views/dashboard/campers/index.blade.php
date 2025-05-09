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
					<!---<li id="invitation-link" class="nav__link"><a href="#">Invitation</a></li>--->
				</ul>
				<div class="profile">
					<!---<img src="assets/megan-p-profile-pic.jpg" alt="User Profile Picture" />--->
					<span>{{ Auth::guard('guardian')->user()->first_name }} {{ Auth::guard('guardian')->user()->last_name }}</span>
				</div>
            </nav>
            <div class="container campers-page-container">
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 15px; background-color: #e6ffed; color: #05603a; padding: 12px 16px; border-radius: 6px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('danger'))
                    <div class="alert alert-danger" style="margin-bottom: 15px; background-color: #e6ffed; color: #05603a; padding: 12px 16px; border-radius: 6px;">
                        {{ session('danger') }}
                    </div>
                @endif

                <div class="camper-header">
                    <h2 style="font-size: 2.75rem;">Your Kids</h2>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-2">
                       @include('dashboard.campers._list')
                    </div>
                    <div>
                        @include('dashboard.campers._form')
                    </div>
                </div>
            </div>
        </div>



        <!-- Add New Kid Modal -->
        <div id="add-kid-modal-overlay" class="modal-overlay hide">
            <div class="card modal modal--sm add-kid__modal">
                <div class="gradient"></div>
                <div class="close-btn"><img src="assets/icons/close.svg" /></div>
                <div class="header">
                    <img src="assets/icons/register.svg" alt="Register Icon" />
                    <h4>Add New Kid</h4>
                </div>
                <div class="modal__main">
                    <form class="add-kid__form" method="POST" action="{{ route('camper_front_end.create') }}">
                        @csrf
                        <div class="add-kid__form-main">
                            <div>
                                <label class="field__label" for="emails">First Name</label>
                                <div class="input__field">
                                    <input type="text" placeholder="First Name" name="first_name" />
                                </div>
                            </div>
                            <div>
                                <label class="field__label" for="emails">Last Name</label>
                                <div class="input__field">
                                    <input type="text" placeholder="Last Name" name="last_name" />
                                </div>
                            </div>
                            <div>
                                <label class="field__label" for="emails">Birth Date</label>
                                <div class="input__field">
                                    <input id="date-picker" placeholder="Camper Birthdate" name="birth_date" />
                                </div>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn--secondary btn--sm">Cancel</button>
                            <button type="submit" class="btn btn--sm">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.datepicker').forEach(function(el) {
                // Reset any residual value to clean ISO
                const isoDate = el.getAttribute('value');  // Ensure value is ISO format (Y-m-d)

                if (el._flatpickr) {
                    el._flatpickr.destroy();
                }

                // Strip any leftover Flatpickr data
                el.classList.remove('flatpickr-input', 'active');
                el.removeAttribute('readonly');
                el.removeAttribute('data-original-value');
                el.removeAttribute('aria-label');

                // Initialize Flatpickr
                const picker = flatpickr(el, {
                    dateFormat: 'M d, Y',  // Format the displayed date as "May 8, 2025"
                    defaultDate: isoDate,  // Use the ISO format for the default date
                });

                // Now ensure the value is displayed in the correct format ("May 8, 2025")
                el.value = picker.formatDate(new Date(isoDate), "M d, Y");  // Re-format the date display
            });
        </script>

    </body>
</html>
