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
