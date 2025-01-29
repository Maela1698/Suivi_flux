@include('CRM.header')
@include('CRM.sidebar')
<title>ListeConstat</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .table th {
        color: #000000;
        font-weight: bold;
    }

    .table td {
        color: #828282;
        font-weight: bold;
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')

        <div class="row">
            <div class="card col-12">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">LISTE QUESTIONNAIRES PROCEDURE</h3>
                    <button type="button" data-toggle="modal" data-target="#constat"
                        class="btn btn-primary">Ajouter</button>
                </div>

                <div class="table-responsive" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead class="thead-dark">
                            <tr>
                                <th>Numero</th>
                                <th>Type Audit</th>
                                <th>Procédures</th>
                                <th>Procédé</th>
                                <th>Question</th>
                                <th>Score</th>
                                <th>Statut</th>
                                <th>Criticité</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @foreach ($questionnaires as $q)
                                <tr
                                    onclick="window.location.href = '{{ route('COMPLIANCE.detailQuestionnaireProcedure', ['idquestionnaire' => $q->questionnaire_id]) }}';">
                                    <td>{{ $q->numero }}</td>
                                    <td>{{ $q->typeaudit }}</td>
                                    <td>{{ $q->departement }}</td>
                                    <td>{{ $q->procede }}</td>
                                    <td>{{ $q->question }}</td>
                                    <td>{{ $q->score }}</td>
                                    <td>{{ $q->statut }}</td>
                                    <td>{{ $q->criticite }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Modal suivi flux serigraphie -->
        <div class="modal fade" id="constat" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion nouveau questionnaire</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('COMPLIANCE.ajoutQuestionnaireProcedure') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Numero</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" class="form-control" name="numero">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Statut</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="statut">
                                                <option value="1">OK</option>
                                                <option value="-1">Not OK</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Question</label>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" name="question"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Procédure</label>
                                        </div>
                                        <select class="form-control" name="departement" id="departement">
                                            <option value="">Choisir une procédure</option>
                                            @foreach ($departement as $d)
                                                <option value="{{ $d->id }}">{{ $d->departement_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Procédés</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="procede" id="type">
                                                <option value="">Sélectionnez une procédure d'abord</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Niveau de criticité</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="criticite">
                                                <option value="">Choisir un criticite</option>
                                                <option value="1">Faible</option>
                                                <option value="2">Moyen</option>
                                                <option value="3">Elevé</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Observation</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="observation">
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

<script>
        document.getElementById('departement').addEventListener('change', function () {
        let departementId = this.value;
        let typeSelect = document.getElementById('type');

        // Réinitialiser le menu déroulant
        typeSelect.innerHTML = '<option value="">Chargement...</option>';

        // Vérifier si un ID valide est sélectionné
        if (departementId) {
            fetch(`/get-types/${departementId}`)
                .then(response => response.json())
                .then(data => {
                    // Vider le menu déroulant et ajouter les nouvelles options
                    typeSelect.innerHTML = '<option value="">Choisir un procédé</option>';
                    data.forEach(type => {
                        let option = document.createElement('option');
                        option.value = type.id;
                        option.textContent = type.valeur;
                        typeSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des procédés:', error);
                    typeSelect.innerHTML = '<option value="">Erreur lors du chargement</option>';
                });
        } else {
            typeSelect.innerHTML = '<option value="">Sélectionnez une procédure d\'abord</option>';
        }
    });

</script>

@include('CRM.footer')
