<style>
    .entete {
        color: #7571f9;
        /* Ajuster la couleur du texte si n�cessaire */
        background-color: white;
    }

    .carte {
        color: white;
        /* Ajuster la couleur du texte si n�cessaire */
        background-color: white;
    }

    .texte {
        color: black;
    }

    .table {
        color: black;
    }

    .qte {
        height: 50px;
        width: 100px;
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
</style>

@include('CRM.header')
<title>DetailAuditExterne</title>
@include('CRM.sidebar')

<!--**********************************
        Content body start
***********************************-->

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')


        <div class="col-md-12">
            <div class="card col-12 carte">
                <div class="d-flex justify-content-between align-items-center entete">

                    <h3 class="entete mt-3">DETAILS AUDIT EXTERNE</h3>
                    <div class="ml-auto d-flex">
                        <button type="button" class="btn btn-success btn-finish mt-1 btn-sm" style="width: 190px;"
                            data-toggle="modal" data-target="#planAction" data-id="" data-iddemande="">
                            <i class="fas fa-tasks"></i> Plan action
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-0" style="background-color: rgb(239, 238, 238); border-radius: 10px;">

                        <div class="col-md-2 mt-3">
                            <center>
                                @if (count($fichier) != 0)
                                    <img src="{{ asset('uploads/audit/' . $fichier[0]->chemin) }}"
                                        class="img-fluid rounded-start mb-5" alt="Logo" width="200px"
                                        height="200px">
                                @else
                                    <p class="texte"><b>Pas de photo</b></p>
                                @endif

                            </center>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">

                                <p class="texte"><b>Date audit :</b>
                                    {{ \Carbon\Carbon::parse($audit[0]->dateaudit)->format('d/m/y') }}</p>
                                <p class="texte"><b>Section :</b> {{ $audit[0]->section }}</p>
                                <p class="texte"><b>Norme :</b>{{ $audit[0]->norme }} </p>
                                <p class="texte"><b>Reference N-C :</b>{{ $audit[0]->reference_nc }}</p>
                                <p class="texte"><b>Constat :</b>{{ $audit[0]->description }}</p>

                                <div class="table-responsive mt-3" style="margin-top: -15px;">
                                    <table class="table mt-3" style="color: black" style="border: 1">
                                        <thead>
                                            <tr>
                                                <th>Numero</th>
                                                <th>Priorite</th>
                                                <th>Moyen/Action</th>
                                                <th>Avancement</th>
                                                <th>DateBudget</th>
                                                <th>BudgetPrevisionnel</th>
                                                <th>BudgetReel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($planAction) > 0)
                                                <tr>
                                                    <td>{{ $planAction[0]->numero }}</td>
                                                    <td>
                                                        @if ($planAction[0]->priorite == 1)
                                                            Faible
                                                        @elseif ($planAction[0]->priorite == 2)
                                                            Moyenne
                                                        @elseif ($planAction[0]->priorite == 3)
                                                            Elevée
                                                        @endif
                                                    </td>
                                                    <td>{{ $planAction[0]->moyens }}</td>
                                                    <td>
                                                        @if ($planAction[0]->avancement != 0)
                                                            {{ $planAction[0]->avancement }}%
                                                        @else
                                                            0%
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!empty($planAction[0]->datebudget))
                                                            {{ \Carbon\Carbon::parse($planAction[0]->datebudget)->format('d/m/y') }}
                                                        @endif

                                                    </td>
                                                    <td>
                                                        {{ $planAction[0]->budgetprevisionnel }}
                                                    </td>
                                                    <td> {{ $planAction[0]->budgetreel }}
                                                    </td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                            <form action="{{ route('COMPLIANCEEXTERNE.listeAuditExterne') }}" method="GET">
                                <button type="submit" class="btn btn-info mr-3">Voir liste</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal plan action -->
            <div class="modal fade" id="planAction" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="choixEtapeModalLabel">Insertion plan action</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('COMPLIANCEEXTERNE.ajoutPlanActionExterne') }}" method="POST"
                                autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mt-1">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <input type="hidden" name="idAudit" value="{{ $audit[0]->audit_id }}">
                                                <label class="col-form-label texte">Date opération</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="date" name="dateOper" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters  mt-3">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Deadline</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="date" name="deadline" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="row no-gutters  mt-3">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Employe</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="nomSaison" name="nomEmploye"
                                                    class="form-control" value="">
                                                <input type="hidden" id="idSaison" name="idEmploye" value="">
                                                <ul id="suggestionsListSaison" class="list-group mt-2"
                                                    style="display: none;">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters  mt-3">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Numero</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control" name="numero" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters  mt-3">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Moyen</label>
                                            </div>
                                            <div class="col-12">
                                                <textarea class="form-control" name="moyen"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters  mt-3">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Priorite</label>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-control" name="priorite">
                                                    <option value="1">Faible</option>
                                                    <option value="2">Moyenne</option>
                                                    <option value="3">Elevée</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters  mt-3">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Commentaire</label>
                                            </div>
                                            <div class="col-12">
                                                <textarea class="form-control" name="commentaire"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Annuler</button>
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
        modal end
***********************************-->







    <!--**********************************
        javascript start
***********************************-->


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var nomSaison = document.getElementById('nomSaison');
            var idSaison = document.getElementById('idSaison');
            var suggestionsList = document.getElementById('suggestionsListSaison');

            nomSaison.addEventListener('input', function() {
                var query = nomSaison.value;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route('COMPLIANCE.rechercheEmployeByNomPrenom') }}?nom=' +
                    encodeURIComponent(query),
                    true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var saisons = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (saisons.length > 0) {
                            saisons.forEach(function(saison) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = saison.nom + ' ' + saison.prenom;
                                li.addEventListener('click', function() {
                                    nomSaison.value = saison.nom + ' ' + saison.prenom;
                                    idSaison.value = saison.id;
                                    suggestionsList.style.display = 'none';
                                });
                                suggestionsList.appendChild(li);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    }
                };
                xhr.send();
            });

            document.addEventListener('click', function(event) {
                if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>

    <!--**********************************
        Content body end
***********************************-->
    @include('CRM.footer')
