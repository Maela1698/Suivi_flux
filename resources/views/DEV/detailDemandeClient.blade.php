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
        position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%; /* Place la liste juste en dessous du champ */
        left: 0; /* Aligne la liste avec le champ */
        }
</style>

@include('CRM.header')
@include('CRM.sidebar')
<title>DetailDcDev</title>
<!--**********************************
        Content body start
***********************************-->

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('DEV.headerDEV')

        <div class="col-md-12">
            <div class="card col-12 carte">
                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">DETAILS DU DEMANDE CLIENT </h3>
                    <center>
                        <h2>{{ $demande[0]->type_saison }}</h2>
                    </center>
                </div>
                <div class="card-body">
                    <div class="row g-0">
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

                    <form action="{{ route('CRM.ajoutTaille') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="hidden" name="idDemandeClient" value="123">
                                    <input type="text" id="uniteTailleMin" class="form-control" placeholder="Taille min" required>
                                    <input type="hidden" id="idUniteTailleMin" class="form-control" name="uniteTailleMin">

                                    <ul id="suggestionsListUniteMin" class="list-group mt-2" style="display: none;"></ul>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="qte" placeholder="Quantité">
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" name="idDemande" value="{{ $demande[0]->id }}">
                                    <button type="submit" class="btn btn-success">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="table-responsive mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Taille</th>
                                            <th>Quantité</th>
                                            <th></th>
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
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-delete"
                                                            data-toggle="modal" data-target="#confirmDeleteModal"
                                                            data-id-taille="{{ $t->id_unite_taille }}"
                                                            data-id-demande="{{ $t->id_demande_client }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-edit"
                                                            data-toggle="modal" data-target="#editModal"
                                                            data-id="{{ $t->id_unite_taille }}"
                                                            data-quantite="{{ $t->quantite }}"
                                                            data-unite-taille="{{ $t->unite_taille }}"
                                                            data-id-demande="{{ $t->id_demande_client }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
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

                                            <tr id="total-row">
                                                <td colspan="4">
                                                    <button type="submit" id="add-button"
                                                        class="btn btn-info">Ajouter</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('CRM.ajoutDossierTech') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Nom du DT" name="nomDT">
                                <input type="hidden" class="form-control" value="{{ $demande[0]->id }}"
                                    name="idDemande">
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control" name="ficheDT" placeholder="">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                        </div>
                    </form>

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
                        <form action="{{ route('DEV.accueil') }}" method="GET">
                            <button type="submit" class="btn btn-success mr-3">Voir liste</button>
                        </form>

                        {{--  <form action='{{ route('CRM.updateDemande') }}' method='POST'>
                            @csrf
                            <button type="submit" class="btn btn-warning mr-3">Modifier</button>
                        </form>  --}}
                        {{--  @if ($demande[0]->id_etat == 1)
                            <form id="validateForm" action="{{ route('CRM.valideDemande') }}" method="get">
                                <input type="hidden" value="{{ $demande[0]->id }}" name="idDemande">
                                <button type="button" class="btn btn-info mr-3" data-toggle="modal"
                                    data-target="#confirmModal">
                                    Valider
                                </button>
                            </form>
                            <form id="cancelForm" action="{{ route('CRM.annuleDemande') }}" method="get">
                                <input type="hidden" value="{{ $demande[0]->id }}" name="idDemande">
                                <button type="button" class="btn btn-warning mr-3" data-toggle="modal" data-target="#cancelModal">
                                    Annulé
                                </button>
                            </form>
                        @endif  --}}

                        {{--  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                            style="height: 35px;">
                            Supprimer
                        </button>  --}}
                    </div>
                </div>
                <!-- Formulaire pour confirmer la suppression dans le modal -->
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                    aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="color: black;">
                                Êtes-vous sûr de vouloir supprimer cet élément ?
                            </div>
                            <div class="modal-footer">
                                <form id="deleteForm" action="{{ route('CRM.deleteUnTaille') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="idTaille" id="delete-idTaille">
                                    <input type="hidden" name="idDemande" id="delete-idDemande">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal pour Éditer la Quantité -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Modifier la Quantité</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="{{ route('CRM.updateTaille') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="idTaille" id="edit-id">
                                    <input type="hidden" name="idDemande" id="edit-id-demande">
                                    <div class="form-group">
                                        <label for="edit-unite-taille">Unité de Taille</label>
                                        <input type="text" class="form-control" id="edit-unite-taille" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-quantite">Quantité</label>
                                        <input type="number" class="form-control" id="edit-quantite"
                                            name="quantite">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary" form="editForm">Modifier</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal de confirmation de suppression -->
                <div class="modal fade" id="confirmDeleteModalDossier" tabindex="-1" role="dialog"
                    aria-labelledby="confirmDeleteModalDossierLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalDossierLabel">Confirmer la suppression
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="color: black;">
                                Êtes-vous sûr de vouloir supprimer ce dossier technique ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <form id="deleteFormDossier" action="{{ route('CRM.deleteDossierTech') }}"
                                    method="get">
                                    @csrf
                                    <input type="hidden" name="idDT" id="delete-id">
                                    <input type="hidden" name="idDemande" id="delete-id-demande">
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal suppr demande -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="color: black;">
                                Voulez-vous vraiment supprimer cet élément ?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('CRM.deleteDemande') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="idDemande" id="deleteTiersId"
                                        value="{{ $demande[0]->id }}">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de confirmation -->
                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog"
                    aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Confirmer la validation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body texte">
                                Voulez-vous vraiment valider la commande ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                <button type="button" class="btn btn-primary" id="confirmBtn">Oui</button>
                            </div>
                        </div>
                    </div>
                </div>


<!-- Modal de confirmation pour Annuler -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Confirmer l'annulation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment annuler la commande ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                <button type="button" class="btn btn-danger" id="cancelConfirmBtn">Oui</button>
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

    @include('DEV.parametreDEV')





    <!--**********************************
        javascript start
***********************************-->



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.suppressionTaille');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const taille = this.dataset.taille;
                    const demande = this.dataset.demande;
                    const confirmDeleteButton = document.getElementById('confirmDelete');
                    confirmDeleteButton.dataset.taille = taille;
                    confirmDeleteButton.dataset.demande = demande;
                    new bootstrap.Modal(document.getElementById('deleteModal')).show();
                });
            });

            document.getElementById('confirmDelete').addEventListener('click', function() {
                const taille = this.dataset.taille;
                const demande = this.dataset.demande;
                window.location.href = 'deleteTailleUniteDC?idTailleDC=' + encodeURIComponent(taille) +
                    '&idDemandeClient=' + encodeURIComponent(demande);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var deleteId;

            // Lorsqu'on clique sur le bouton Supprimer
            $('.suppressionDemande').click(function() {
                $('#confirmDeleteModal').modal('show');
            });

            // Lorsqu'on confirme la suppression
            $('#confirmDeleteBtn').click(function() {
                // Soumet le formulaire de suppression
                $('#deleteForm').submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let deleteForm;
            let confirmDeleteButton = document.getElementById('confirmDeleteButton');

            // Lorsque le modal s'affiche, récupérer l'id du formulaire
            $('#confirmDeleteModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget); // Bouton qui a déclenché le modal
                let formId = button.data('id'); // Extraire l'id du formulaire
                deleteForm = document.getElementById('deleteForm-' + formId);
            });

            // Lorsque l'utilisateur confirme la suppression
            confirmDeleteButton.addEventListener('click', function() {
                if (deleteForm) {
                    deleteForm.submit();
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Vérifie si les formulaires ont déjà été soumis
            {{--  if (localStorage.getItem('form_submitted')) {
                document.getElementById('validateForm').style.display = 'none';
                document.getElementById('cancelForm').style.display = 'none';
            }  --}}

            {{--  // Écouteurs d'événements pour stocker l'état après soumission
            document.getElementById('validateForm').addEventListener('submit', function() {
                localStorage.setItem('form_submitted', 'validated');
            });

            document.getElementById('cancelForm').addEventListener('submit', function() {
                localStorage.setItem('form_submitted', 'cancelled');
            });  --}}
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let deleteForm = document.getElementById('deleteForm');

            // Ajouter des écouteurs d'événements pour chaque bouton de suppression
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    // Extraire les données du bouton
                    const idTaille = button.getAttribute('data-id-taille');
                    const idDemande = button.getAttribute('data-id-demande');

                    // Mettre à jour les champs du formulaire dans le modal
                    document.getElementById('delete-idTaille').value = idTaille;
                    document.getElementById('delete-idDemande').value = idDemande;
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Bouton qui déclenche le modal
                var id = button.data('id'); // ID de la taille
                var quantite = button.data('quantite'); // Quantité actuelle
                var uniteTaille = button.data('unite-taille'); // Unité de taille
                var idDemande = button.data('id-demande'); // ID de la demande

                var modal = $(this);
                modal.find('#edit-id').val(id);
                modal.find('#edit-id-demande').val(idDemande);
                modal.find('#edit-quantite').val(quantite);
                modal.find('#edit-unite-taille').val(uniteTaille);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let deleteForm = document.getElementById('deleteFormDossier');

            // Ajouter des écouteurs d'événements pour chaque bouton de suppression
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    // Extraire les données du bouton
                    const idTaille = button.getAttribute('data-id');
                    const idDemande = button.getAttribute('data-id-demande');

                    // Mettre à jour les champs du formulaire dans le modal
                    document.getElementById('delete-id').value = idTaille;
                    document.getElementById('delete-id-demande').value = idDemande;
                });
            });
        });
    </script>
    <script>
        document.getElementById('confirmBtn').addEventListener('click', function() {
            document.getElementById('validateForm').submit(); // Soumettre le formulaire
            $('#confirmModal').modal('hide'); // Fermer le modal
        });
    </script>
<script>
    document.getElementById('cancelConfirmBtn').addEventListener('click', function() {
        document.getElementById('cancelForm').submit(); // Soumettre le formulaire d'annulation
        $('#cancelModal').modal('hide'); // Fermer le modal
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var uniteTailleMin = document.getElementById('uniteTailleMin');
        var idUniteTailleMin = document.getElementById('idUniteTailleMin');
        var suggestionsList = document.getElementById('suggestionsListUniteMin');

        uniteTailleMin.addEventListener('input', function () {
            var query = uniteTailleMin.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("recherche-unite-taille-min") }}?nomUnite=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var unites = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (unites.length > 0) {
                        unites.forEach(function (unite) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = unite.unite_taille;
                            li.addEventListener('click', function () {
                                uniteTailleMin.value = unite.unite_taille;
                                idUniteTailleMin.value = unite.id;
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

        document.addEventListener('click', function (event) {
            if (!uniteTailleMin.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>
    <!--**********************************
        javascript start
***********************************-->

    <!--**********************************
        Content body end
***********************************-->
    @include('CRM.footer')
