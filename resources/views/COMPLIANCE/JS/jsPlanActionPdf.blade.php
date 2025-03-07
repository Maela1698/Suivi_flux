{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script> --}}
<script>
    function exportToPDF() {
        const element = document.getElementById("pdf");

        const options = {
            filename: 'Rapport_Plan_Action.pdf', // Vous pouvez dynamiser ce nom selon vos besoins
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };
        html2pdf().set(options).from(element).save();
    }
</script>