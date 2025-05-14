@extends('layouts.dashboard')

@section('content')
    <div class="container campers-page-container">               
        <div class="camper-header">
            <h2 style="font-size: 2.75rem;">My Kids</h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                @include('dashboard.campers._list')
            </div>
            <div class="lg:col-span-1">
                @include('dashboard.campers._form')
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
                const isoDate = el.getAttribute('value');

                if (el._flatpickr) {
                    el._flatpickr.destroy();
                }

                el.classList.remove('flatpickr-input', 'active');
                el.removeAttribute('readonly');
                el.removeAttribute('data-original-value');
                el.removeAttribute('aria-label');

                const picker = flatpickr(el, {
                    dateFormat: 'M d, Y',
                    defaultDate: isoDate,
                });

                el.value = picker.formatDate(new Date(isoDate), "M d, Y");
            });
        });
    </script> 	
@endsection
