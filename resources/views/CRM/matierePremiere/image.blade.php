@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        @foreach ( $listeImage as $l)
        <img src="data:image/png;base64,{{ $l->images }}" alt="Image">
        <a href="#" onclick="openPdfInNewTab('{{ $l->pdf }}')">Ouvrir le PDF</a>

        <a href="{{ asset('storage/' . $l->pdf) }}"  style="color: black">Télécharger le PDF</a>
        @endforeach


    </div>
</div>
<script>
    function openPdfInNewTab(base64Pdf) {
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

        return new Blob(byteArrays, { type: contentType });
    }
</script>

@include('CRM.footer')
