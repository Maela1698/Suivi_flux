@include('CRM.header')
@include('CRM.sidebar')
<title>DetailAccessoire</title>

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

            <div class="col-md-12">
                <div class="card col-12 carte">
                    <div class="justify-content-center align-items-center entete">
                        <h3 class="entete mt-3">DETAILS ACCESSOIRE </h3>
                        <center>
                            <h2>{{ $listeAcc[0]->type_accessoire }}</h2>
                        </center>
                    </div>

                    <div class="card-body">
                        <div class="card mb-2">
                            <div class="row g-0">
                                <div class="col-md-2 mt-2">
                                    <center>
                                        <img src="data:image/png;base64,{{ $listeAcc[0]->photo }}"
                                            class="img-fluid rounded-start mb-5" alt="Logo" width="200px"
                                            height="200px">
                                    </center>
                                </div>
                                <div class="col-md-5">
                                    <div class="card-body">
                                        <p class="texte"><b>Famille :</b>{{ $listeAcc[0]->famille_accessoire }}</p>
                                        <p class="texte"><b>Designation :</b>{{ $listeAcc[0]->designation }}</p>
                                        <p class="texte"><b>Reference :</b> {{ $listeAcc[0]->reference }}</p>
                                        <p class="texte"><b>Couleur :</b> {{ $listeAcc[0]->couleur }}</p>
                                        <p class="texte"><b>Quantite :</b>{{ number_format( $listeAcc[0]->quantite, 3, '.', ' ') }}
                                            {{ $listeAcc[0]->unite_mesure }}</p>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card-body">
                                        <p class="texte"><b>Classe :</b> {{ $listeAcc[0]->classe }}</p>
                                        <p class="texte"><b>Utilisation :</b>{{ $listeAcc[0]->utilisation }} </p>
                                        <p class="texte"><b>Prix unitaire :</b> {{ $listeAcc[0]->prix_unitaire }}
                                            {{ $listeAcc[0]->unite }}</p>
                                        <p class="texte"><b>Fret :</b> {{ $listeAcc[0]->frais }}
                                            {{ $listeAcc[0]->unite }}</p>
                                        <p class="texte"><b>Fiche technique :</b>
                                            @if (!empty($listeAcc[0]->fiche_technique))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $listeAcc[0]->fiche_technique }}', event)">
                                                    {{ $listeAcc[0]->nom_fiche_technique }}
                                                </a>
                                            @else
                                                <span>Aucune fiche technique disponible</span>
                                            @endif
                                        </p>

                                    </div>
                                </div>


                            </div>


                        </div>

                    </div>



                    <div class="form-group row">
                        <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                            <form action="{{ route('CRM.listeMatierePremiere') }}" method="get">
                                @csrf
                                <input type="hidden" value="{{ $listeAcc[0]->id_demande_client }}"
                                    name="id_demande_client">
                                <button type="submit" class="btn btn-info mr-3">Voir liste</button>
                            </form>

                            <form action='{{ route('CRM.formModifAccessoire') }}' method='GET'>
                                <input type='hidden' name='idAccessoire' value="{{ $listeAcc[0]->id }}">
                                <button type="submit" class="btn btn-warning mr-3">Modifier</button>
                            </form>


                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal" data-id="{{ $listeAcc[0]->id }}">
                                Supprimer
                            </button>


                        </div>
                    </div>

                </div>
            </div>


            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteLabel">Confirmation de suppression</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Voulez-vous vraiment supprimer cet accessoire ?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('CRM.deleteAccessoire') }}" method="POST">
                                @csrf
                                <input type="hidden" name="idAccy" id="idAcc">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>


<!--**********************************
        modal start
***********************************-->



@include('CRM.parametre')

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#confirmDeleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui déclenche le modal
            var idAcc = button.data('id'); // Extraire l'information de data-id

            var modal = $(this);
            modal.find('.modal-footer #idAcc').val(idAcc);
        });
    });
</script>

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
