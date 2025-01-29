@include('CRM.header')
@include('CRM.sidebar')
<title>ListePlanActionExterne</title>

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
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')


        <div class="row">
            <div class="card col-12">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">PLAN ACTION AUDIT EXTERNE</h3>
                </div>

                <form action="{{ route('COMPLIANCEEXTERNE.listePlanActionExterne') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-3">
                            <div class="input-group">
                                <select class="form-control" name="section">
                                    <option value="">Section</option>
                                    @for ($s = 0; $s < count($section); $s++)
                                        <option value="{{ $section[$s]->designation }}">
                                            {{ $section[$s]->designation }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <select class="form-control" name="priorite">
                                    <option value="">Priorite</option>
                                    <option value="1">Faible</option>
                                    <option value="2">Moyenne</option>
                                    <option value="3">Elevée</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <input type="text" id="nomSaison" name="nomEmploye" class="form-control" value=""
                                placeholder="Responsable">
                            <input type="hidden" id="idSaison" name="idEmploye" value="">
                            <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                            </ul>
                        </div>

                        <div class="col-3">
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                        </div>
                    </div>


                </form>

                <div class="table-responsive mt-3" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Numero</th>
                                <th>Section</th>
                                <th>Constat</th>
                                <th>Moyens/Actions</th>
                                <th>Priorité</th>
                                <th>Responsable</th>
                                <th>Deadline</th>
                                <th>Avancement</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @for ($i = 0; $i < count($planAction); $i++)
                                <tr>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;"> {{ $planAction[$i]->planaction_id }}</td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">{{ $planAction[$i]->numero }}</td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">{{ $planAction[$i]->section }}</td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">
                                        <?php
                                        $descriptions1 = substr($planAction[$i]->audit, 0, 50);
                                        $hasMore1 = strlen($planAction[$i]->audit) > 50; // Vérifie si le texte est plus long que 50 caractères
                                        ?>
                                        {{ $descriptions1 }} @if ($hasMore1)
                                            ...
                                        @endif
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">
                                        <?php
                                        $descriptions = substr($planAction[$i]->moyens, 0, 50);
                                        $hasMore = strlen($planAction[$i]->moyens) > 50; // Vérifie si le texte est plus long que 50 caractères
                                        ?>
                                        {{ $descriptions }} @if ($hasMore)
                                            ...
                                        @endif
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">
                                        @if ($planAction[$i]->priorite == 1)
                                            Faible
                                        @elseif ($planAction[$i]->priorite == 2)
                                            Moyenne
                                        @elseif ($planAction[$i]->priorite == 3)
                                            Elevée
                                        @endif
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;"> {{ $planAction[$i]->prenom_responsable }}
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">
                                        {{ \Carbon\Carbon::parse($planAction[$i]->deadline)->format('d/m/y') }}</td>

                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">
                                        @if ($planAction[$i]->avancement != 0)
                                            {{ $planAction[$i]->avancement }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;"> {{ $planAction[$i]->budgetprevisionnel }}
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planAction[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;"> {{ $planAction[$i]->budgetreel }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-finish mt-1 btn-sm"
                                            style="width: 110px;" data-toggle="modal" data-target="#avancement"
                                            data-id="{{ $planAction[$i]->planaction_id }}">
                                            <i class="fas fa-hourglass-half"></i> Avancement
                                        </button>
                                    </td>
                                    {{--  <td>
                                        <button type="button" class="btn btn-primary btn-finish mt-1 btn-sm"
                                            style="width: 100px;" data-toggle="modal" data-target="#budgetModal"
                                            data-id="{{ $planAction[$i]->planaction_id }}">
                                            <i class="fas fa-wallet"></i> Budget
                                        </button>

                                    </td>  --}}
                                </tr>
                            @endfor


                        </tbody>
                    </table>
                </div>


            </div>
        </div>


        <!-- Modal avancement -->
        <div class="modal fade" id="avancement" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion avancement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('COMPLIANCEEXTERNE.ajoutAvancementExterne') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="hidden" id="idPlanAction" name="idPlanAction">
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
                                            {{--  <label class="col-form-label texte">Designation</label>  --}}
                                        </div>
                                        <div class="col-12">
                                            <input type="hidden" name="designation" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Avancement(%)</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="avancement" class="form-control" required>
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


        {{--  <!-- Modal budget -->
        <div class="modal fade" id="budgetModal" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion budget</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('COMPLIANCEEXTERNE.ajoutBudgetExterne') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="hidden" id="idPlanActionExterne" name="idPlanActionExterne">
                                            <label class="col-form-label texte">Date budget</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" name="dateBudget" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Budget previsionnel</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="budgetPrevisionnel" class="form-control" value="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Budget réel</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="budgetReel" class="form-control" value="0" required>
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
        </div>  --}}



        @if (session('error'))
            <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="errorModalLabel">⚠️Attention!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span class="texte" style="color: red">{{ session('error') }}</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>


<!--**********************************
        modal start
***********************************-->




<!--**********************************
        javascript start
***********************************-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#avancement').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            var modal = $(this);
            modal.find('#idPlanAction').val(etapeId);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#budgetModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            var modal = $(this);
            modal.find('#idPlanActionExterne').val(etapeId);
        });
    });
</script>



<script>
    // Afficher automatiquement le modal si une erreur est présente
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>

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
