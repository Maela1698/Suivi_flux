@include('CRM.header')
@include('CRM.sidebar')
<title>ListeMatierePremiere</title>

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
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <div class="card col-12">
                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">LISTE DES MATIERES PREMIERES </h3>

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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="entete">TISSU</h3>
                        <form action="{{ route('CRM.formAjouTissu') }}" method="get">
                            <input type="hidden" name="erreur" value="">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                    <div class="table-responsive mt-4">

                        <table class="table table-striped" style="color: black">

                            <thead>

                                <tr>
                                    <th>Type tissus</th>
                                    <th>Categorie</th>
                                    <th>Designation</th>
                                    <th>Composition</th>
                                    <th>Quantité</th>
                                    <th>Famille</th>
                                    <th>Photo</th>
                                    <th>Fiche technique</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($listeTissu); $i++)
                                    <tr>
                                        <td
                                            onclick="document.getElementById('detailForm{{ $i }}').submit();">
                                            {{ $listeTissu[$i]->type_tissus }}</td>
                                        <td
                                            onclick="document.getElementById('detailForm{{ $i }}').submit();">

                                            <p>{{ $listeTissu[$i]->categorie }}</p>

                                        </td>
                                        <td
                                            onclick="document.getElementById('detailForm{{ $i }}').submit();">
                                            {{ $listeTissu[$i]->designation }}
                                            <p>{{ $listeTissu[$i]->reference }}/{{ $listeTissu[$i]->couleur }}/

                                                {{ $listeTissu[$i]->laize_utile }}
                                                cm/{{ $listeTissu[$i]->grammage }} g
                                            </p>
                                        </td>
                                        <td
                                            onclick="document.getElementById('detailForm{{ $i }}').submit();">
                                            {{ $listeTissu[$i]->composition_tissus }}</td>
                                            <td onclick="document.getElementById('detailForm{{ $i }}').submit();">
                                                {{ number_format($listeTissu[$i]->quantite, 3, '.', ' ') }} {{ $listeTissu[$i]->unite_mesure }}
                                            </td>

                                        <td
                                            onclick="document.getElementById('detailForm{{ $i }}').submit();">
                                            {{ $listeTissu[$i]->famille_tissus }}</td>
                                        <td
                                            onclick="document.getElementById('detailForm{{ $i }}').submit();">
                                            <img src="data:image/png;base64,{{ $listeTissu[$i]->photo }}"
                                                alt="Image" width="70%" height="70px">
                                        </td>
                                        <td>
                                            @if (!empty($listeTissu[$i]->fiche_technique))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $listeTissu[$i]->fiche_technique }}', event)">
                                                    <span
                                                        style="color: black">{{ $listeTissu[$i]->nom_fiche_technique }}</span>
                                                </a>
                                            @endif
                                        </td>

                                        <form id="detailForm{{ $i }}"
                                            action="{{ route('CRM.detailTissu') }}" method="GET"
                                            style="display:none;">
                                            @csrf
                                            <input type="hidden" value="{{ $listeTissu[$i]->id }}" name="idTissus">

                                        </form>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="card-body">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="entete">ACCESSOIRES</h3>
                        <form action="{{ route('CRM.formAjoutAccessoire') }}" method="get">

                            <input type="hidden" name="erreur" value="">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-striped" style="color: black">
                            <thead>
                                <tr>
                                    <th>Type accessoire</th>
                                    <th>Famille</th>
                                    <th>Designation</th>
                                    <th>Reference</th>
                                    <th>Couleur</th>
                                    <th>Quantité</th>
                                    <th>Photo</th>
                                    <th>Utilisation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($j = 0; $j < count($listeAcc); $j++)
                                    <tr>
                                        <td
                                            onclick="document.getElementById('detailFormA{{ $j }}').submit();">
                                            {{ $listeAcc[$j]->type_accessoire }}</td>
                                        <td
                                            onclick="document.getElementById('detailFormA{{ $j }}').submit();">
                                            {{ $listeAcc[$j]->famille_accessoire }}</td>

                                        <td
                                            onclick="document.getElementById('detailFormA{{ $j }}').submit();">
                                            {{ $listeAcc[$j]->designation }}</td>
                                        <td
                                            onclick="document.getElementById('detailFormA{{ $j }}').submit();">
                                            {{ $listeAcc[$j]->reference }}</td>
                                        <td
                                            onclick="document.getElementById('detailFormA{{ $j }}').submit();">
                                            {{ $listeAcc[$j]->couleur }}</td>
                                        <td
                                            onclick="document.getElementById('detailFormA{{ $j }}').submit();">
                                            {{ number_format($listeAcc[$j]->quantite, 3, '.', ' ') }}  {{ $listeAcc[$j]->unite_mesure }}</td>

                                        <td
                                            onclick="document.getElementById('detailFormA{{ $j }}').submit();">
                                            <img src="data:image/png;base64,{{ $listeAcc[$j]->photo }}" alt="Image"
                                                width="70%" height="70px">
                                        </td>
                                        <td
                                            onclick="document.getElementById('detailFormA{{ $j }}').submit();">
                                            {{ $listeAcc[$j]->utilisation }}
                                        </td>

                                        <form id="detailFormA{{ $j }}"
                                            action="{{ route('CRM.detailAccessoire') }}" method="get"
                                            style="display:none;">
                                            @csrf
                                            <input type="hidden" value="{{ $listeAcc[$j]->id }}" name="idAcc">

                                        </form>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@include('CRM.parametre')
<!--**********************************
        modal start
***********************************-->





<!--**********************************
        javascript start
***********************************-->
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
        Content body end
***********************************-->
@include('CRM.footer')
