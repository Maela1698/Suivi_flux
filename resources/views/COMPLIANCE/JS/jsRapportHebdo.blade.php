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

<script>
    document.getElementById('export-pdf').addEventListener('click', function() {
        exportToPDF();
    });
    function exportToPDF() {
        const element = document.getElementById("pdfContent");

        const options = {
            filename: 'Rapport_Audit_Interne_{{ $mois_annee_affichage }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };
        html2pdf().set(options).from(element).save();
    }
</script>