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

@include('CRM.header')
<title>ParametreTeinture</title>
@include('CRM.sidebar')

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
                    <h3 class="entete mt-3">PARAMETRE TEINTURE</h3>
                    <div class="ml-auto d-flex">
                        @if (count($parametre) == 0)
                            <button type="button" class="btn btn-primary btn-finish mt-1 btn-sm" style="width: 120px;"
                                data-toggle="modal" data-target="#rapportJournalier" data-id="" data-iddemande="1">
                                <i class="fas fa-plus"></i> Ajouter
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body" style="background-color: rgb(239, 238, 238);">
                    <center>
                        <h2>{{ $demande[0]->type_saison }}</h2>
                    </center>
                    <div class="row g-0" style=" border-radius: 10px;">
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
                                <p class="texte"><b>Periode :</b> {{ $demande[0]->periode }}</p>
                                <p class="texte"><b>Modèle :</b>{{ $demande[0]->nom_modele }}</p>
                                <p class="texte"><b>Designation :</b>{{ $demande[0]->nom_style }}</p>
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


                </div>

                <div class="card-body">
                    @if (count($parametre) != 0)
                    <div class="row">

                        <div class="col-12">
                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="texte">Couleur</label><br>
                                    <input type="text" class="form-control" name="couleur" value="{{ $parametre[0]->couleur }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row no-gutters mt-3">
                                <div class="col-5 mr-2">
                                    <label class="texte">Nombre panneaux</label><br>
                                    <input type="text" class="form-control" name="nbPanneaux"
                                    value="{{ $parametre[0]->nb_panneaux }}">
                                </div>
                                <div class="col-5">
                                    <label class="texte">Poids unitaire(kg)</label><br>
                                    <input type="text" name="poidsUnitaire" class="form-control" value="{{ $parametre[0]->poids_unitaire }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row no-gutters mt-3">
                                <div class="col-5 mr-2">
                                    <label class="texte">Poids d'une passe</label><br>
                                    <input type="text" class="form-control" name="poidsPasse" value="{{ $parametre[0]->poids_passe }}">
                                </div>
                                <div class="col-5">
                                    <label class="texte">Prix teinture(Euro)</label><br>
                                    <input type="text" class="form-control"  name="prixTeinture" value="{{ $parametre[0]->prix_teinture }}">
                                </div>
                            </div>
                        </div>

                          <div class="col-12">
                            <div class="row no-gutters mt-3">
                                <div class="col-5 mr-2">
                                    <label class="texte">Poids total</label><br>
                                    <input type="text" class="form-control" value="{{ $parametre[0]->poids_total }}">
                                </div>
                                <div class="col-5">
                                    <label class="texte">Nombre passe</label><br>
                                    <input type="text" class="form-control"  value="{{ $parametre[0]->nb_passe }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="texte">Commentaire</label><br>
                                    <input type="text" class="form-control" name="commentaire" value="{{ $parametre[0]->commentaire }}">
                                </div>
                            </div>
                        </div>



                        <!-- Conteneur pour l'affichage des éléments ajoutés -->
                        <div id="fileList" class="mt-4"></div>

                    </div>


                        <div class="form-group row mt-3">
                            <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                <form action="{{ route('LBT.listeLBT') }}" method="GET">
                                    <button type="submit" class="btn btn-warning mr-3">Modifier</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <span class="texte">Il n'y pas encore de parametre de teinture sur cette demande</span>
                    @endif

                </div>






            </div>

            <!-- Modal rapport journalier -->
            <div class="modal fade" id="rapportJournalier" tabindex="-1" role="dialog"
                aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                    <div class="modal-content modal-content-custom">
                        <div class="modal-header">
                            <h5 class="modal-title" id="choixEtapeModalLabel">Insertion paramètre teinture</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('LBT.insertParametreTeinture') }}" method="POST"
                                autocomplete="off">
                                @csrf
                                <div class="row">

                                     <div class="col-12">
                                        <div class="row no-gutters mt-3">
                                            <div class="col-12">
                                                <label class="texte">Date d'insertion</label><br>
                                                <input type="datetime-local" class="form-control" name="date_parametre">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters mt-3">
                                            <div class="col-12">
                                                <label class="texte">Couleur</label><br>
                                                <input type="text" class="form-control" name="couleur">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters mt-3">
                                            <div class="col-5 mr-2">
                                                <label class="texte">Nombre panneaux</label><br>
                                                <input type="text" class="form-control" name="nbPanneaux"
                                                    value="0">
                                            </div>
                                            <div class="col-5">
                                                <label class="texte">Poids unitaire(kg)</label><br>
                                                <input type="text" name="poidsUnitaire" class="form-control" value="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters mt-3">
                                            <div class="col-5 mr-2">
                                                <label class="texte">Poids d'une passe</label><br>
                                                <input type="text" class="form-control" name="poidsPasse" value="0">
                                            </div>
                                            <div class="col-5">
                                                <label class="texte">Prix teinture(Euro)</label><br>
                                                <input type="text" class="form-control"  name="prixTeinture" value="5">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters mt-3">
                                            <div class="col-12">
                                                <label class="texte">Commentaire</label><br>
                                                <input type="text" class="form-control" name="commentaire">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div id="formContainer">
                                            <div class="row no-gutters mt-3 form-row" id="inputRow">
                                                <div class="col-4 mr-1">
                                                    <label class="texte">Nom fichier</label><br>
                                                    <input type="text" class="form-control" name="nom[]">
                                                </div>
                                                <div class="col-4 mr-1">
                                                    <label class="texte">Fichier</label><br>
                                                    <input type="file" class="form-control" name="fichier[]">
                                                </div>
                                                <div class="col-1">
                                                    <label style="color: transparent">Plus</label><br>
                                                    <button class="btn btn-success add-btn" type="button">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Conteneur pour l'affichage des éléments ajoutés -->
                                    <div id="fileList" class="mt-4"></div>

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

    <style>
        .fixed-top-right {
            position: fixed;
            top: 0;
            right: 0;
            margin-top: 136px;
            /* Optionnel, pour donner un petit espace par rapport au bord */
            margin-right: 10px;
            z-index: 1000;
            /* Assure que le div reste au-dessus des autres éléments */
        }

        .settings-icon {
            font-size: 1.5rem;
            /* Taille de l'icône */
            cursor: pointer;
            /* Curseur pointeur au survol */
            color: #495057;
            /* Couleur de l'icône */
            transition: transform 0.5s ease-in-out;
            /* Transition pour la rotation */
        }

        .settings-icon:hover {
            transform: rotate(180deg);
            /* Rotation au survol */
        }

        .custom-card {
            background-color: #343a40;
            /* Couleur de fond foncée */
            border-radius: 8px;
            /* Bordure arrondie */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Ombre pour un effet de relief */
            display: none;
            /* Caché par défaut */
            margin-top: 10px;
            /* Espacement entre l'icône et le menu */
        }

        .custom-card .btn {
            width: 100%;
            /* Assure que les boutons prennent toute la largeur */
            text-align: left;
            /* Aligne le texte et l'icône à gauche */
            color: #fff;
            /* Couleur du texte blanche */
            background-color: #495057;
            /* Couleur de fond des boutons */
            border: none;
            /* Supprime la bordure */
            transition: background-color 0.3s;
            /* Transition douce pour le changement de couleur */
        }

        .custom-card .btn:hover {
            background-color: #6c757d;
            /* Changement de couleur au survol */
        }

        .custom-card i {
            margin-right: 8px;
            /* Espace entre l'icône et le texte */
        }
    </style>
    <div class="col-md-1 fixed-top-right">
        <div class="d-flex flex-column align-items-end">
            <!-- Icône Paramètres -->
            <div class="settings-icon" id="settings-icon">
                <i class="fas fa-cog"></i>
            </div>

            <!-- Carte avec les boutons -->
            <div class="card p-2 custom-card" id="settings-menu">
                <form action="{{ route('LBT.detailDemandeLBT') }}" method="post">
                    @csrf
                    <input type="hidden" name="idDemande" value="{{ $demande[0]->id }}">
                    <button type="submit" class="btn btn-success btn-finish mt-1 btn-sm mr-2"
                        style="width: 170px;" >
                        <i class="fas fa-info"></i> Detail
                    </button>
                </form>

                @if (Str::contains($demandeLBT[0]->types_lavage, 'Blanchissement'))
                    <form action="{{ route('LBT.listeParametreBlanchissement') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success btn-finish mt-1 btn-sm mr-2"
                            style="width: 170px;" >
                            <i class="fas fa-soap"></i> Blanchissement
                        </button>
                    </form>
                @endif

                @if (!($demandeLBT[0]->types_lavage === 'Blanchissement'))
                    <form action="{{ route('LBT.listeParametreLavage') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-finish mt-1 btn-sm mr-2"
                            style="width: 170px;" >
                            <i class="fas fa-water"></i> Lavage
                        </button>
                    </form>
                @endif

                @if (Str::contains($demandeLBT[0]->types_valeur_ajout, 'Teinture'))
                <form action="{{ route('LBT.listeParametreTeinture') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-info btn-finish mt-1 btn-sm" style="width: 170px;"
                        >
                        <i class="fas fa-fill-drip"></i> Teinture
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>


    <script>
        document.getElementById('settings-icon').addEventListener('mouseover', function() {
            document.getElementById('settings-menu').style.display = 'block';
        });

        document.getElementById('settings-menu').addEventListener('mouseleave', function() {
            document.getElementById('settings-menu').style.display = 'none';
        });
    </script>






    <!--**********************************
        javascript start
***********************************-->




    <!--**********************************
        javascript start
***********************************-->

    <script>
        document.querySelector('.add-btn').addEventListener('click', function() {
            // Créer un nouvel élément de ligne
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'no-gutters', 'mt-3', 'form-row');

            newRow.innerHTML = `
            <div class="col-4 mr-1">
                <label class="texte">Nom fichier</label><br>
                <input type="text" class="form-control" name="nom[]">
            </div>
            <div class="col-4 mr-1">
                <label class="texte">Fichier</label><br>
                <input type="file" class="form-control" name="fichier[]">
            </div>
            <div class="col-1">
                <label style="color: transparent">Supprimer</label><br>
                <button class="btn btn-danger delete-btn" type="button">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `;

            // Ajouter la nouvelle ligne au conteneur
            document.getElementById('formContainer').appendChild(newRow);

            // Afficher la liste des fichiers ajoutés
            const fileName = newRow.querySelector('input[type="text"]').value;
            const fileRow = document.createElement('div');


            // Écouter l'événement de suppression de ligne
            newRow.querySelector('.delete-btn').addEventListener('click', function() {
                newRow.remove();
                fileRow.remove();
            });

            // Écouter l'événement de suppression de fichier dans la liste affichée
            fileRow.querySelector('.delete-file-btn').addEventListener('click', function() {
                fileRow.remove();
            });
        });
    </script>


    <!--**********************************
        Content body end
***********************************-->
    @include('CRM.footer')
