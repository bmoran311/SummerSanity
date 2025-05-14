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