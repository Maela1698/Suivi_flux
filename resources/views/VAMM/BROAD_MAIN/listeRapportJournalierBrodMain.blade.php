@include('CRM.header')
@include('CRM.sidebar')
<title>ListerapportJournalierBrodMain</title>

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

                <div class=" justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">RAPPORT JOURNALIER BRODERIE MAIN</h3>
                </div>

                <div class="table-responsive" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>Date prod</th>
                                <th>Nom modele</th>
                                <th>Stade</th>
                                <th>Taux retouche</th>
                                <th>Taux rejet</th>
                                <th>Valeur</th>
                                <th>Electricité</th>
                                <th>NC traité</th>
                                <th>Absenteisme</th>
                                <th>SMV Print</th>
                                <th>Commentaire</th>
                                <th>Nb operateur</th>
                                <th>Total qualité</th>
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
                                    @if (!empty($rapport[$i]->stadesdc))
                                    <td>{{ $rapport[$i]->stadesdc }} </td>
                                    @else
                                    <td>{{ $rapport[$i]->stade_demande }} </td>
                                    @endif

                                    <td>{{ number_format( $rapport[$i]->taux_retouche, 3, '.', ' ') }}%</td>
                                    <td>{{ number_format( $rapport[$i]->taux_rejet, 3, '.', ' ') }} %</td>
                                    <td>{{ $rapport[$i]->valeur_electricite }} euro</td>
                                    <td>{{ $rapport[$i]->conso_electricite }}</td>
                                    <td>{{ $rapport[$i]->nc_traite }}</td>
                                    <td>{{ $rapport[$i]->absenteisme }}</td>
                                    <td>{{ $rapport[$i]->smv_print }}</td>
                                    <td>{{ $rapport[$i]->commentaire }}</td>
                                    <td>{{ $rapport[$i]->nb_operateur }}</td>
                                    <td>{{ $rapport[$i]->total_qte }}</td>
                                    <td>{{ $rapport[$i]->max_heure }}</td>
                                    <td>{{ number_format( $rapport[$i]->efficience, 3, '.', ' ') }} %</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
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


<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
