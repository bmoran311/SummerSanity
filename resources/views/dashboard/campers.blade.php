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
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/weekSelect/weekSelect.js"></script>


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
					<li id="invitation-link" class="nav__link"><a href="#">Invitation</a></li>
				</ul>
				<div class="profile">
					<img src="assets/megan-p-profile-pic.jpg" alt="User Profile Picture" />
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
                    <h4>Your Kids</h4>
                    <button id="add-kid-btn" class="btn btn--sm">Add New Kid</button>
                </div>
                <div class="camper-items">                    
                    <div class="camper-item table-header">
                        <span class="column-title">Camper Name</span>                        
                        <span class="column-title">Birth Date</span>
                    </div>                                       
                    @foreach($campers as $camper)
                        <div class="camper-item card">
                            <div class="input__field">
                                <input type="text" placeholder="{{ $camper->first_name }}" value="{{ $camper->first_name }}" name="camper_first_name" data-original="{{ $camper->first_name }}" />
                            </div>                            
                            <div class="input__field">
                                <input id="date-picker" placeholder="Camper Birthdate" value="{{ \Carbon\Carbon::parse($camper->birth_date)->format('M d, Y') }}" data-original="{{ \Carbon\Carbon::parse($camper->birth_date)->format('M d, Y') }}">
                            </div>
                            <form method="POST" action="{{route('camper_front_end.destroy', ['camper' => $camper])}}" onsubmit="return confirm('Are you sure you want to delete this camper?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" style="background: none; border: none; padding: 0;">
                                    <img src="assets/icons/delete.svg" alt="Delete Icon" />
                                </button>
                            </form>                           
                        </div>   
                    @endforeach  
                    <button type="submit" class="btn btn--sm save-btn" style="display: none;">Save Changes</button>                                                   
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Init Flatpickr correctly
                flatpickr(".datepicker", {
                    dateFormat: "M d, Y",
                    allowInput: true
                });

                const inputs = document.querySelectorAll('.camper-edit-input');
                const saveBtn = document.querySelector('.save-btn');

                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        let hasChanged = false;

                        inputs.forEach(inp => {
                            if (inp.value !== inp.dataset.original) {
                                hasChanged = true;
                            }
                        });

                        saveBtn.style.display = hasChanged ? 'inline-block' : 'none';
                    });
                });
            });
        </script>

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
    </body>
</html>
