<script>
    document.getElementById('clientInput').addEventListener('change', function() {
        var selectedOption = document.querySelector('#clients option[value="' + this.value + '"]');
        if (selectedOption) {
            document.getElementById('id_client').value = selectedOption.getAttribute('data-id');
        } else {
            document.getElementById('id_client').value = '';
        }
    });
</script>

<script src="{{ asset('js/flatpickr/cdnjs/flatpickr.min.js') }}"></script>

<script src="{{ asset('js/flatpickr/cdnjs/fr.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#date_ppm", {
            mode: "range",
            dateFormat: "d-m-y",
            locale: "fr", 
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#date_trace", {
            mode: "range",
            dateFormat: "d-m-y",
            locale: "fr", 
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#date_ex", {
            mode: "range",
            dateFormat: "d-m-y",
            locale: "fr", 
        });
    });
</script>