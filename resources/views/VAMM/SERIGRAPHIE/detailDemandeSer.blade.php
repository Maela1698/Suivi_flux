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

    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
    }

    .checkbox-item {
        flex: 0 0 19%;
        /* R�partir en quatre colonnes */
        margin: 1%;
        /* Espacement entre les checkboxes */
        box-sizing: border-box;
        /* Inclure les marges dans la taille totale */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
        color: black;
    }

    .checkbox-item input[type="checkbox"] {
        margin-right: 10px;
        /* Espacement entre le checkbox et le texte */
    }

    .checkbox-item label {
        margin: 0;
        /* R�initialiser les marges du label */
    }

    .checkbox-item:hover {
        background-color: #e6f7ff;
        border-color: #007bff;
    }

    .requete {
        height: 100px;
    }
</style>
<style>
    .custom-tooltip .tooltip-inner {
        background-color: #f8d7da;
        /* Couleur de fond */
        color: #721c24;
        /* Couleur du texte */
        font-size: 16px;
        /* Taille du texte */
        padding: 10px;
        /* Espacement */
    }

    .custom-tooltip .arrow::before {
        border-top-color: #f8d7da;
        /* Couleur de la fl�che */
    }

    #suggestionsListUniteMin {
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
        max-width: 50%;
        /* Ajustez selon vos besoins */
    }

    .modal-content-custom {
        height: 98vh;
        /* Ajustez selon vos besoins */
        overflow-y: auto;
        /* Ajoutez une barre de défilement si nécessaire */
    }
</style>
@include('CRM.header')
@include('CRM.sidebar')
<title>DetailDcSerigraphie</title>
<!--**********************************
        Content body start
***********************************-->

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('VAMM.headerVAMM')

        <div class="col-md-12">
            <div class="card col-12 carte">
                <div class="d-flex justify-content-between align-items-center entete">
                    <h3 class="entete mt-3">DETAILS DU DEMANDE CLIENT SERIGRAPHIE</h3>

                    <div class="ml-auto d-flex mr-2">
                        <button type="button" class="btn btn-primary btn-finish mt-1 btn-sm mr-2" style="width: 190px;"
                            data-toggle="modal" data-target="#suiviFlux" data-id="{{ $demande[0]->id }}"
                            data-iddemande="{{ $demande[0]->id }}">
                            <i class="fas fa-chart-line"></i> Suivi flux
                        </button>

                        <button type="button" class="btn btn-success btn-finish mt-1 btn-sm" style="width: 190px;"
                            data-toggle="modal" data-target="#rapportJournalier" data-id="{{ $demande[0]->id }}"
                            data-iddemande="{{ $demande[0]->id }}">
                            <i class="fas fa-book"></i> Rapport journalier
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <center>
                        <h2>{{ $demande[0]->type_saison }}</h2>
                    </center>
                    <div class="row g-0" style="background-color: rgb(239, 238, 238); border-radius: 10px;">
                        <div class="col-md-2 mt-1">
                            <center>
                                <img src="data:image/png;base64,{{ $demande[0]->photo_commande }}"
                                    class="img-fluid rounded-start mb-5" alt="Logo" width="200px" height="200px">
                            </center>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte"><b>Date entrée :</b>
                                    {{ \Carbon\Carbon::parse($demande[0]->date_entree)->format('d/m/y') }}</p>
                                <p class="texte"><b>Client :</b> {{ $demande[0]->nomtier }}</p>
                                <p class="texte"><b>Modèle :</b>{{ $demande[0]->nom_modele }}</p>
                                <p class="texte"><b>Style :</b>{{ $demande[0]->nom_style }}</p>
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

                    <center>
                        <span class="texte"><b>Lavage</b></span>
                        <div class="col-12 checkbox-container">
                            @foreach ($lavage as $l)
                                <div class="checkbox-item">
                                    {{ $l->type_lavage }}
                                </div>
                            @endforeach
                        </div>
                    </center>
                    <br>
                    <center>
                        <span class="texte"><b>Valeur Ajoutée</b></span>
                        <div class="col-12 checkbox-container">
                            @foreach ($valeur as $v)
                                <div class="checkbox-item">
                                    {{ $v->type_valeur_ajoutee }}
                                </div>
                            @endforeach
                        </div>
                    </center>

                    <div class="table-responsive mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Commentaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Client</th>
                                    <td>{{ $demande[0]->requete_client }}</td>
                                </tr>
                                <tr>
                                    <th>Merch</th>
                                    <td>{{ $demande[0]->commentaire_merch }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="row">
                        <div class="col-md-5">
                            <div class="table-responsive mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Taille</th>
                                            <th>Quantité</th>
                                        </tr>
                                    </thead>
                                    <form id="updateQuantitiesForm" action="{{ route('CRM.updateQuantites') }}"
                                        method="post">
                                        @csrf
                                        <tbody id="table-body">
                                            @php $count = 0; @endphp
                                            @foreach ($tailles as $t)
                                                @php $count += $t->quantite; @endphp
                                                <tr>
                                                    <td>{{ $t->unite_taille }}</td>
                                                    <td>
                                                        <input type="number" class="form-control qte" name="quantite[]"
                                                            value="{{ $t->quantite }}">
                                                        <input type="hidden" name="idTaille[]"
                                                            value="{{ $t->id_unite_taille }}">
                                                        <input type="hidden" name="idDemande"
                                                            value="{{ $t->id_demande_client }}">
                                                    </td>

                                                </tr>
                                            @endforeach

                                            <!-- Affichage du total des quantités -->
                                            <tr>
                                                <td colspan="1"><strong>Total :</strong></td>
                                                @if ($count == $demande[0]->qte_commande_provisoire)
                                                    <td style="background-color: #cdfc99; color: black; ">
                                                        <strong>{{ $count }}</strong>
                                                    </td>
                                                @else
                                                    <td style="background-color: #fc6e5b; color: black"">
                                                        <strong>{{ $count }}</strong>
                                                    </td>
                                                @endif

                                            </tr>


                                        </tbody>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-3">
                                <p class="texte"><b>Liste des DT</b>
                                    @if ($dossiertech->isEmpty())
                                        Pas de dossier technique
                                    @else
                                        @foreach ($dossiertech as $ds)
                                            <p class="texte"><b>
                                                    <a href="#"
                                                        onclick="openPdfInNewTab('{{ $ds->dossier_technique_demande }}', event)">
                                                        {{ $ds->nom_dossier_technique }}
                                                    </a>
                                                </b>

                                            </p>
                                        @endforeach
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>


                </div>




                <div class="form-group row">
                    <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                        <form action="{{ route('SERIGRAPHIE.listeSerigraphie') }}" method="GET">
                            <button type="submit" class="btn btn-success mr-3">Voir liste</button>
                        </form>

                    </div>
                </div>


                <!-- Modal suivi flux serigraphie -->
                <div class="modal fade" id="suiviFlux" tabindex="-1" role="dialog"
                    aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="choixEtapeModalLabel">Insertion suivi flux serigraphie
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('SERIGRAPHIE.insertFluxSerigraphie') }}" method="POST"
                                    autocomplete="off">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mt-1">
                                            <div class="row no-gutters">
                                                <div class="col-12">
                                                    <input type="hidden" id="etapeIdDemandeSer" name="iddemandeSer">
                                                    <input type="hidden" id="etapeIdDemande" name="iddemande">
                                                    <label class="col-form-label texte">Date d'opération</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="datetime-local" name="dateOper" class="form-control"
                                                        required>
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


                                        <div class="table-responsive mt-5">
                                            <table class="table texte">
                                                <thead>
                                                    <th>Taille</th>
                                                    <th>Qte</th>
                                                    <th>Recoupe</th>
                                                </thead>
                                                <tbody>
                                                    @for ($u = 0; $u < count($tailles); $u++)
                                                        <tr>
                                                            <td><input type="text" name="unite[]" class="form-control" value="{{ $tailles[$u]->unite_taille }}" readonly></td>
                                                            <td>
                                                                <input type="number" name="qte[]" value="0"
                                                                    class="form-control" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="recoupe[]" value="0"
                                                                    class="form-control" required>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
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

                <!-- Modal rapport journalier -->
                <div class="modal fade" id="rapportJournalier" tabindex="-1" role="dialog"
                    aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                        <div class="modal-content modal-content-custom">
                            <div class="modal-header">
                                <h5 class="modal-title" id="choixEtapeModalLabel">Insertion rapport journalier
                                    serigraphie</h5>
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
                                                    <input type="datetime-local" name="dateProd" class="form-control"
                                                        required>
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
                                                    <input type="text" name="rejet" class="form-control"
                                                        required>
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
                                                    <input type="text" name="valeur" class="form-control"
                                                        required>
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
                                                    <input type="text" name="reclam" class="form-control"
                                                        required>
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
                                                    <input type="text" name="absenteisme" class="form-control">
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
                                                    <input type="text" name="nbOperateur" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div id="formContainer">
                                                <div class="row no-gutters mt-3 form-row">
                                                    <div class="col-4 mr-1">
                                                        <label class="texte">Heure</label><br>
                                                        <input type="text" class="form-control" name="heure[]"
                                                            value="1">
                                                    </div>
                                                    <div class="col-4 mr-1">
                                                        <label class="texte">Quantité</label><br>
                                                        <input type="text" class="form-control" name="qte[]"
                                                            value="0">
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
    </div>

    <!--**********************************
        modal start
***********************************-->

    <!--**********************************
        modal end
***********************************-->

    @include('VAMM.SERIGRAPHIE.parametreSer')


    {{--  suivi flux  --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#suiviFlux').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var etapeId = button.data('id');
                var etapeDemande = button.data('iddemande');
                console.log(etapeId);
                var modal = $(this);
                modal.find('#etapeIdDemandeSer').val(etapeId);
                modal.find('#etapeIdDemande').val(etapeDemande);
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
                {{--  newFormRow.querySelector('input[name="heure[]"]').disabled = true;  --}}

                // Vider la quantité dans le nouveau formulaire
                newFormRow.querySelector('input[name="qte[]"]').value = 0;

                // Changer le bouton ajouter en bouton supprimer
                let addButton = newFormRow.querySelector('.add-btn');
                addButton.classList.remove('btn');
                addButton.classList.add('btn');
                addButton.innerHTML = ''; // Supprime le contenu du bouton (icône par exemple)
                addButton.style.backgroundColor = 'transparent'; // Mettre le fond en transparent
                addButton.style.border = 'none';
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
        javascript start
***********************************-->

    <!--**********************************
        Content body end
***********************************-->
    @include('CRM.footer')
