@include('CRM.header')
@include('CRM.sidebar')
<title>FicheCoupe</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .form-control {
        border: 1px solid #b5b5b5;
    }

    label {
        color: #767575;
    }

    .btn-info {
        display: inline-flex;
        align-items: center;
        background-color: #17a2b8;
        /* Couleur de fond du bouton */
        color: #ffffff;
        /* Couleur du texte */
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-info:hover {
        background-color: #138496;
        /* Couleur de fond au survol */
        transform: scale(1.05);
        /* Effet d'agrandissement au survol */
    }

    .btn-info i {
        margin-right: 8px;
        /* Espacement entre l'icône et le texte */
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <div class="card col-12">
                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">FICHE DE COUPE </h3>
                </div>
                <div class="card-body" style="background-color: rgb(239, 238, 238); border-radius: 10px;">
                    <center>  <h2>{{ $demande[0]->type_saison }}</h2></center>
                    <div class="row mt-3" style="display: flex; align-items: center;">
                        <div class="col-md-2 mt-1">
                            <center>
                                <img src="data:image/png;base64,{{ $demande[0]->photo_commande }}"
                                    class="img-fluid rounded-start mb-5" alt="Logo" width="120px" height="120px">
                            </center>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte"><b>Date entrée :</b>
                                    {{ \Carbon\Carbon::parse($demande[0]->date_entree)->format('d/m/y') }}</p>
                                    <p class="texte"><b>Periode :</b> {{ $demande[0]->periode }}</p>
                                <p class="texte"><b>Client :</b> {{ $demande[0]->nomtier }}</p>
                                <p class="texte"><b>Modèle :</b>{{ $demande[0]->nom_modele }}</p>
                                <p class="texte"><b>Designation :</b>{{ $demande[0]->nom_style }}</p>
                                <p class="texte"><b>Thème :</b>{{ $demande[0]->theme }}</p>
                                <p class="texte"><b>Quantité prévisionnel
                                        :</b>{{ $demande[0]->qte_commande_provisoire }}</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte">
                                    <b>ETD:</b>{{ \Carbon\Carbon::parse($demande[0]->date_livraison)->format('d/m/y') }}
                                </p>
                                <p class="texte"><b>Stade :</b> {{ $demande[0]->type_stade }}</p>
                                <p class="texte"><b>Grille de taille
                                        :</b>{{ $demande[0]->taillemin }}--{{ $demande[0]->taillemax }}</p>
                                <p class="texte"><b>Taille de base :</b>{{ $demande[0]->taille_base }}</p>
                                <p class="texte"><b>Incontern :</b> {{ $demande[0]->type_incontern }}</p>
                                <p class="texte"><b>Phase :</b> {{ $demande[0]->type_phase }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">


                    <div class="row mt-3">
                        <div class="col-3">
                            <form action="{{ route('CRM.exportCSV') }}" method="GET">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-file-csv"></i> Exporter CSV
                                </button>
                            </form>

                        </div>

                        <div class="col-3">
                            <form action="{{ route('CRM.insertFicheCoupe') }}" method="post"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <input type="text" name="nomFichier" class="form-control"
                                    placeholder="Nom fiche de coupe">
                        </div>
                        <div class="col-3">
                            <input type="file" class="form-control" name="fichierCoupeDemande" required>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-success import-btn">
                                <i class="fas fa-file-import"></i> Importer EXCEL
                            </button>

                            </form>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <table style="color: black">
                            <thead>
                                <th>Fiche de coupe</th>
                            </thead>
                            <tbody>
                                @if (count($fiche) != 0)
                                    @for ($i = 0; $i < count($fiche); $i++)
                                        <tr>
                                            <td> <a href="#"
                                                    onclick="openExcelInNewTab('{{ $fiche[$i]->fichier }}', '{{ $fiche[$i]->nomfichier }}', event)">
                                                    {{ $fiche[$i]->nomfichier }}
                                                </a></td>
                                        </tr>
                                    @endfor
                                @else
                                    <td>Pas de fiche de coupe</td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<!--**********************************
        modal start
***********************************-->





<!--**********************************
        javascript start
***********************************-->

<script>
    function openExcelInNewTab(base64Excel, filename, event) {
        // Empêcher l'actualisation de la page
        if (event) {
            event.preventDefault();
        }

        // Vérifier si base64Excel est défini et non vide
        if (!base64Excel) {
            console.error("Le contenu Excel n'est pas disponible.");
            return;
        }

        // Créer un objet Blob à partir de la chaîne base64 décodée
        const excelBlob = base64ToBlob(base64Excel,
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        // Créer une URL à partir de l'objet Blob
        const excelUrl = URL.createObjectURL(excelBlob);

        // Créer un élément d'ancre (lien) temporaire
        const link = document.createElement('a');
        link.href = excelUrl;
        link.download = filename; // Définir le nom du fichier

        // Ouvrir le fichier dans un nouvel onglet
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();

        // Nettoyer l'URL objet pour éviter les fuites de mémoire
        URL.revokeObjectURL(excelUrl);
        link.remove();
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
@include('CRM.parametre')
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
