
<script>
    function openPdfInNewTab(base64Pdf, event) {
        // Empêcher l'actualisation de la page
        if (event) {
            event.preventDefault();
        }

        // Vérifier si base64Pdf est défini et non vide
        if (!base64Pdf) {
            console.error("Le contenu PDF n'est pas disponible.");
            return;
        }

        // Créer un objet Blob à partir de la chaîne base64 décodée
        const pdfBlob = base64ToBlob(base64Pdf, 'application/pdf');

        // Créer une URL à partir de l'objet Blob
        const pdfUrl = URL.createObjectURL(pdfBlob);

        // Ouvrir le PDF dans un nouvel onglet
        window.open(pdfUrl, '_blank');
    }

    function base64ToBlob(base64, contentType) {
        const byteCharacters = atob(base64);
        const byteArrays = [];

        for (let offset = 0; offset < byteCharacters.length; offset += 512) {
            const slice = byteCharacters.slice(offset, offset + 512);

            const byteNumbers = new Array(slice.length);
            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            const byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }

        return new Blob(byteArrays, {
            type: contentType
        });
    }
</script>
<!--**********************************
    Footer start
***********************************-->
{{--  <div class="footer">
    <div class="copyright" style="color: rgb(139, 139, 139)">
        <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">L.O.I</a> 2024</p>
        <p>Distributed by <a href="https://themewagon.com/" target="_blank">L.O.I</a></p>
    </div>
</div>  --}}
<!--**********************************
    Footer end
***********************************-->

<!--**********************************
   Support ticket button start
***********************************-->

<!--**********************************
   Support ticket button end
***********************************-->


</div>
<!--**********************************
Main wrapper end
***********************************-->

<style>
.footer {
    background: linear-gradient(to bottom, #d4a373, #c28a53);
}
</style>

<!--**********************************
Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{ asset('vendor/global/global.min.js') }}"></script>
<script src="{{ asset('js/quixnav-init.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>


<!-- Vectormap -->
<script src="{{ asset('vendor/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('vendor/morris/morris.min.js') }}"></script>


<script src="{{ asset('vendor/circle-progress/circle-progress.min.js') }}"></script>
<script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>

<script src="{{ asset('vendor/gaugeJS/dist/gauge.min.js') }}"></script>

<!--  flot-chart js -->
<script src="{{ asset('vendor/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.resize.js') }}"></script>

<!-- Owl Carousel -->
<script src="{{ asset('vendor/owl-carousel/js/owl.carousel.min.js') }}"></script>

<!-- Counter Up -->
<script src="{{ asset('vendor/jqvmap/js/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('vendor/jqvmap/js/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('vendor/jquery.counterup/jquery.counterup.min.js') }}"></script>


<script src="{{ asset('js/dashboard/dashboard-1.js') }}"></script>

</body>

</html>
