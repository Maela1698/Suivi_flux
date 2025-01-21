@include('CRM.header')
@include('CRM.sidebar')
<title>ListeHeureTravailMachiniste</title>

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
        @include('DEV.headerDEV')
        <div class="row">
            <div class="card col-12">

                <div class="card-body">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="entete">LISTE HEURES TRAVAILS</h3>
                        <form action="{{ route('DEV.formHeureTravailMachiniste') }}" method="get">
                            <input type="hidden" name="erreur" value="">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>

                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-striped" style="color: black">
                            <thead>
                                <tr>
                                    <th>Nom employe</th>
                                    <th>Date entree</th>
                                    <th>Date sortie</th>
                                    <th>Heure supplementaire</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($heure) != 0)
                                    @for ($e = 0; $e < count($heure); $e++)
                                        <tr>
                                            <td>{{ $heure[$e]->nom }} {{ $heure[$e]->prenom }}</td>
                                            <td> {{ \Carbon\Carbon::parse($heure[$e]->dateentreeheuretravail)->format('d/m/y H:i') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($heure[$e]->datesortieheuretravail)->format('d/m/y H:i') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($heure[$e]->heuresupplementaire)->format('H:i') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-finish mt-1 btn-sm"
                                                    style="width: 50px;" data-toggle="modal" data-target="#updateHeure"
                                                    data-id="{{ $heure[$e]->id }}" data-dateentree="{{ $heure[$e]->dateentreeheuretravail }}"
                                                    data-datesortie="{{ $heure[$e]->datesortieheuretravail }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endfor
                                @else
                                    <tr>
                                        <td colspan="4">
                                            Veuillez noter que votre présence n'a pas encore été enregistrée
                                            aujourd'hui. Nous vous prions de bien vouloir la compléter avant de
                                            commencer toute autre activité
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>

        <!-- Modal fin etape  -->
        <div class="modal fade" id="updateHeure" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Confirmation de finalisation de tâche</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.updateHeureTravailMachiniste') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="row no-gutters mt-4">
                                <div class="col-12">
                                    <input type="hidden" id="idEmploye" name="employe">
                                    <label class="col-form-label texte">Date entrée </label>
                                </div>
                                <div class="col-12">
                                    <input type="datetime-local" id="dateEntree" name="dateEntree" class="form-control">
                                </div>
                            </div>
                            <div class="row no-gutters mt-4">
                                <div class="col-12">
                                    <input type="hidden" id="idDemandeSer" name="idDemandeSer">
                                    <input type="hidden" id="idEtape" name="idEtape">
                                    <label class="col-form-label texte">Date sortie </label>
                                </div>
                                <div class="col-12">
                                    <input type="datetime-local" id="dateSortie" name="dateSortie" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Modifier</button>
                            </div>
                        </form>
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

{{--  modal achever montage  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#updateHeure').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var dateentree = button.data('dateentree');
            var datesortie = button.data('datesortie');

            var modal = $(this);
            modal.find('#idEmploye').val(id);
            modal.find('#dateEntree').val(dateentree);
            modal.find('#dateSortie').val(datesortie);
        });
    });
</script>

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
