@include('CRM.header')
@include('CRM.sidebar')
<title>ListeSuiviFlux</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .table th {
        color: #000000;
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }

    .table td {
        color: #828282;
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }

    #suggestionsListSaison {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }

    #suggestionsListTiers {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }

    #suggestionsListStyle {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }

    #suggestionsListEmploye {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }

    #suggestionsListStade {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('VAMM.headerVAMM')
        {{--  <div class="row" style="display: flex; justify-content: space-between; flex-wrap: nowrap;">
            <div >
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #3a7bd5, #3a6073); width: 200px">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                NbrModele</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">  {{ $nbCommande }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-list"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>

        </div>  --}}
        <div class="row">
            <div class="card col-12">

                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">LISTE DES SUIVIS BROD MAIN</h3>
                </div>

                <div class="table-responsive" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>Date entrée</th>
                                <th>Theme</th>
                                <th>Modèle</th>
                                <th>Client</th>
                                <th>Saison</th>
                                <th>Style</th>
                                <th>Type</th>
                                <th>Type flux</th>
                                <th>Quantité</th>
                                <th>Recoupe</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @for ($i = 0; $i < count($suivi); $i++)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($suivi[$i]->date_operation)->format('d/m/y H:i') }}
                                    </td>
                                    <td>{{ $suivi[$i]->theme }}</td>
                                    <td>{{ $suivi[$i]->nom_modele }}</td>
                                    <td>{{ $suivi[$i]->nomtier }}</td>
                                    <td>{{ $suivi[$i]->type_saison }}</td>
                                    <td>{{ $suivi[$i]->nom_style }}</td>
                                    @if ($suivi[$i]->type == 1)
                                        <td>Brod main</td>
                                    @else
                                        <td>Smock main</td>
                                    @endif
                                    <td>
                                        @if ($suivi[$i]->type_flux == 1)
                                            Reception
                                        @else
                                            Livraison
                                        @endif
                                    </td>
                                    <td>{{ $suivi[$i]->qte }}</td>
                                    <td>{{ $suivi[$i]->recoupe }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-finish mt-1 btn-sm mr-2"
                                            style="width: 190px;" data-toggle="modal" data-target="#suiviFlux"
                                            data-id="{{ $suivi[$i]->id }}" data-iddemande="">
                                            <i class="fas fa-chart-line"></i> Suivi flux
                                        </button>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        <!-- Modal suivi flux -->
        <div class="modal fade" id="suiviFlux" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion suivi flux</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('BRODMAIN.ajoutSuiviFluxBrodMain') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="hidden" id="etapeIdDemandeSer" name="idDemande">
                                            <label class="col-form-label texte">Date d'opération</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="datetime-local" name="dateOper" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Type flux</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="type">
                                                <option value="1">Réception</option>
                                                <option value="2">Livraison</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Quantité</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="qte" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Recoupe</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="recoupe" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
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









{{--  suivi flux  --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#suiviFlux').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            var etapeDemande = button.data('iddemande');
            var modal = $(this);
            modal.find('#etapeIdDemandeSer').val(etapeId);
            modal.find('#etapeIdDemande').val(etapeDemande);
        });
    });
</script>
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
