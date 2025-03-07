<script>
    document.getElementById('apercuPdfBtn').addEventListener('click', function(event) {
        event.preventDefault();

        // Récupérer les valeurs des filtres
        const idSection = document.querySelector('select[name="id_section"]').value;
        const priorite = document.querySelector('select[name="priorite"]').value;
        const responsableId = document.getElementById('responsableId').value;

        // Construire l'URL avec les paramètres
        const url = new URL("{{ route('COMPLIANCE.planActionPdf') }}", window.location.origin);
        if (idSection) url.searchParams.append('id_section', idSection);
        if (priorite) url.searchParams.append('priorite', priorite);
        if (responsableId) url.searchParams.append('responsable_id', responsableId);

        window.location.href = url.toString();
    });
</script>

<script>
    document.getElementById('responsableInput').addEventListener('change', function() {
        var selectedOption = document.querySelector('#responsableListe option[value="' + this.value + '"]');
        if (selectedOption) {
            document.getElementById('responsableId').value = selectedOption.getAttribute('data-id');
        } else {
            document.getElementById('responsableId').value = '';
        }
    });
</script>

<script src="{{ asset('js/flatpickr/cdnjs/flatpickr.min.js') }}"></script>

<script src="{{ asset('js/flatpickr/cdnjs/fr.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#daterange", {
            mode: "range",
            dateFormat: "d-m-Y",
            locale: "fr", 
        });
    });
</script>