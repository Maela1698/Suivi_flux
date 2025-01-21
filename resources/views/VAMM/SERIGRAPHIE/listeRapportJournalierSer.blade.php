@include('CRM.header')
@include('CRM.sidebar')
<title>ListerapportJournalier</title>

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
<style>
    .modal-lg-custom {
        max-width: 50%; /* Ajustez selon vos besoins */
    }
    .modal-content-custom {
        height: 98vh; /* Ajustez selon vos besoins */
        overflow-y: auto; /* Ajoutez une barre de défilement si nécessaire */
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('VAMM.headerVAMM')
          <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Qte produite</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qte }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-list"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #4568dc, #b06ab3);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Efficience</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($efficience, 2, '.', ' ') }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-handshake"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                C.A</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $chiffreAffaire }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-check-circle"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Taux retouche</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $retouche }} %</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="row" style="margin-top: 0;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Electrcité</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $electricite }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #16a085, #f4d03f);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Valeur</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $valeur }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-file-alt"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #82a382, #000c40);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Nc traités</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $ncTraite }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-box"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #667eea, #764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Absenteisme</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $absenteisme }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-industry"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="card col-12">

                <div class=" justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">RAPPORT JOURNALIER SERIGRAPHIE</h3>
                </div>

                <form action="{{ route('SERIGRAPHIE.listeRapportJournalier') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="dateDebut"
                                    value="{{ $dateDebut }}">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="dateFin"
                                    value="{{ $dateFin }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomSaison" name="nomSaison" class="form-control" placeholder="Saison"
                                    value="{{ $nomSaison }}">
                                <input type="hidden" id="idSaison" name="idSaison" value="{{ $idSaison }}">
                                <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="modele" name="modele" class="form-control" placeholder="Modele"
                                    value="{{ $modele }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomTiers" name="nomTiers" class="form-control" placeholder="Nom Client"
                                    value="{{ $nomTiers }}">
                                <input type="hidden" id="idTiers" name="idTiers" value="{{ $idTiers }}">
                                <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-4" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th style="width: 200px">Date prod</th>
                                <th style="width: 150px">Nom modele</th>
                                <th style="width: 150px">Client</th>
                                <th style="width: 150px">Saison</th>
                                <th style="width: 150px">Stade</th>
                                <th style="width: 150px">Taux retouche</th>
                                <th style="width: 150px">Taux rejet</th>
                                <th style="width: 150px">Produit chimique</th>
                                <th style="width: 100px">Valeur</th>
                                <th style="width: 150px">Electricité</th>
                                <th style="width: 150px">Reclam loading</th>
                                <th style="width: 150px">NC traité</th>
                                <th>Absence</th>
                                <th>SMV Print</th>
                                <th style="width: 150px">Commentaire</th>
                                <th>Nb operateur</th>
                                <th>Total quantité</th>
                                <th>Heure travail</th>
                                <th>Efficience</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @for ($i = 0; $i < count($rapport); $i++)
                            <tr onclick="window.location.href = '{{ route('SERIGRAPHIE.formModifRapportJournalierSer', ['idRapport' => $rapport[$i]->id]) }}';"
                                style="cursor: pointer;">
                                    <td>{{ \Carbon\Carbon::parse($rapport[$i]->date_pro)->format('d/m/y H:i') }}
                                    </td>
                                    <td>{{ $rapport[$i]->nom_modele }} </td>
                                    <td>{{ $rapport[$i]->nomtier }} </td>
                                    <td>{{ $rapport[$i]->type_saison }} </td>
                                    <td>{{ $rapport[$i]->type_stade }} </td>
                                    <td>{{ $rapport[$i]->taux_retouche }} %</td>
                                    <td>{{ $rapport[$i]->taux_rejet }} %</td>
                                    <td>{{ $rapport[$i]->produit_chmique }} g</td>
                                    <td>{{ $rapport[$i]->valeur }} euro</td>
                                    <td>{{ $rapport[$i]->electricite }}</td>
                                    <td>{{ $rapport[$i]->reclam_loading }}</td>
                                    <td>{{ $rapport[$i]->nc_traite }}</td>
                                    <td>{{ $rapport[$i]->absenteisme }}</td>
                                    <td>{{ $rapport[$i]->smv_print }}</td>
                                    <td>{{ $rapport[$i]->commentaire }}</td>
                                    <td>{{ $rapport[$i]->nb_operateur }}</td>
                                    <td>{{ $rapport[$i]->total_qte }}</td>
                                    <td>{{ $rapport[$i]->max_heure }}</td>
                                    <td>{{ number_format($rapport[$i]->efficience, 2, '.', ' ') }}%</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>


            </div>
        </div>



        <!-- Modal rapport journalier -->
        <div class="modal fade" id="rapportJournalier" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion rapport journalier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('SERIGRAPHIE.ajoutRapportJournalier') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Date de prod</label>
                                        </div>
                                        <div class="col-6">
                                            <input type="datetime-local" name="dateProd" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Taux retouche</label><br>
                                            <input type="text" class="form-control" name="retouche">
                                        </div>
                                        <div class="col-5 ">
                                            <label class="texte">Taux rejet</label><br>
                                            <input type="text" name="rejet" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Produit chimique(g)</label><br>
                                            <input type="text" class="form-control" name="chimique">
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Valeur(Euro)</label><br>
                                            <input type="text" name="valeur" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Electricité </label><br>
                                            <input type="text" class="form-control" name="electricite">
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Reclam loading</label><br>
                                            <input type="text" name="reclam" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">NC traités </label><br>
                                            <input type="text" class="form-control" name="ncTraite">
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Absentéisme</label><br>
                                            <input type="text" name="absenteisme" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Commentaire</label><br>
                                            <input type="text" class="form-control" name="commentaire">
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Nb opérateur</label><br>
                                            <input type="text" name="nbOperateur" class="form-control" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div id="formContainer">
                                        <div class="row no-gutters mt-3 form-row">
                                            <div class="col-4 mr-1">
                                                <label class="texte">Heure</label><br>
                                                <input type="text" class="form-control" name="heure[]" value="1" >
                                            </div>
                                            <div class="col-4 mr-1">
                                                <label class="texte">Quantité</label><br>
                                                <input type="text" class="form-control" name="qte[]" value="0">
                                            </div>
                                            <div class="col-1">
                                                <label style="color: transparent">Quantité</label><br>
                                                <button class="btn btn-success add-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
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
{{--  saison  --}}
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
            xhr.open('GET', '{{ route('recherche-saison') }}?nomSaison=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.type_saison;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.type_saison;
                                idSaison.value = saison.type_saison;
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



<script>
    document.addEventListener("DOMContentLoaded", function() {
        let formContainer = document.getElementById('formContainer');

        // Fonction pour ajouter une nouvelle ligne
        function addFormRow() {
            let formRows = document.querySelectorAll('.form-row');
            let lastHourInput = formRows[formRows.length - 1].querySelector('input[name="heure[]"]');
            let newHourValue = parseInt(lastHourInput.value) + 1;

            // Clone le dernier élément
            let newFormRow = formRows[0].cloneNode(true);

            // Mettre à jour l'heure dans le nouveau formulaire
            newFormRow.querySelector('input[name="heure[]"]').value = newHourValue;

            // Vider la quantité dans le nouveau formulaire
            newFormRow.querySelector('input[name="qte[]"]').value = 0;

            // Changer le bouton ajouter en bouton supprimer
            let addButton = newFormRow.querySelector('.add-btn');
            addButton.classList.remove('btn');
            addButton.classList.add('btn');
            addButton.innerHTML = ''; // Supprime le contenu du bouton (icône par exemple)
            addButton.style.backgroundColor = 'transparent'; // Mettre le fond en transparent
            addButton.style.border ='none';
            addButton.removeEventListener('click', addFormRow);
            addButton.addEventListener('click', function() {

            });


            // Ajouter la nouvelle ligne au conteneur
            formContainer.appendChild(newFormRow);
        }


        // Fonction pour réajuster les valeurs des heures après suppression
        function updateHours() {
            let formRows = document.querySelectorAll('.form-row');
            formRows.forEach((row, index) => {
                let hourInput = row.querySelector('input[name="heure[]"]');
                hourInput.value = index + 1;
            });
        }

        // Ajout de l'événement pour le premier bouton Ajouter
        document.querySelector('.add-btn').addEventListener('click', addFormRow);
    });
</script>

{{--  tiers  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomTiers = document.getElementById('nomTiers');
        var idTiers = document.getElementById('idTiers');
        var suggestionsListTiers = document.getElementById('suggestionsListTiers');

        nomTiers.addEventListener('input', function() {
            var query = nomTiers.value;

            if (query.length < 1) {
                suggestionsListTiers.style.display = 'none';
                return;
            }

            var xhr1 = new XMLHttpRequest();
            xhr1.open('GET', '{{ route('recherche-tiers-demande') }}?nomTiers=' + encodeURIComponent(
                query), true);
            xhr1.onload = function() {
                if (xhr1.status === 200) {
                    var tiers = JSON.parse(xhr1.responseText);
                    suggestionsListTiers.innerHTML = '';
                    if (tiers.length > 0) {
                        tiers.forEach(function(tier) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = tier.nomtier;
                            li.addEventListener('click', function() {
                                nomTiers.value = tier.nomtier;
                                idTiers.value = tier.nomtier;
                                suggestionsListTiers.style.display = 'none';
                            });
                            suggestionsListTiers.appendChild(li);
                        });
                        suggestionsListTiers.style.display = 'block';
                    } else {
                        suggestionsListTiers.style.display = 'none';
                    }
                }
            };
            xhr1.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomTiers.contains(event.target) && !suggestionsListTiers.contains(event.target)) {
                suggestionsListTiers.style.display = 'none';
            }
        });
    });
</script>



<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
