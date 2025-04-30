<script src="{{ asset('js/flatpickr/cdnjs/flatpickr.min.js') }}"></script>

<script src="{{ asset('js/flatpickr/cdnjs/fr.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#dateDebut", {
            mode: "range",
            dateFormat: "d-m-Y",
            locale: "fr", 
        });

        flatpickr("#dateFin", {
            mode: "range",
            dateFormat: "d-m-Y",
            locale: "fr", 
        });
    });
</script>