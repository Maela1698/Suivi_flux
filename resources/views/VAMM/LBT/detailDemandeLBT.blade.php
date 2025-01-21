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

                    <h3 class="entete mt-3">DETAILS DU DEMANDE CLIENT(LBT)</h3>



                    <div class="ml-auto d-flex">
                        <button type="button" class="btn btn-primary btn-finish mt-1 btn-sm mr-2" style="width: 190px;"
                            data-toggle="modal" data-target="#suiviFlux" data-id=""
                            data-iddemande="{{ $demande[0]->id }}">
                            <i class="fas fa-chart-line"></i> Suivi flux
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
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <form id="updateQuantitiesForm" action="{{ route('CRM.updateQuantites') }}"
                                        method="post">
                                        @csrf
                                        @if ($somme == 0)
                                            <tbody id="table-body">
                                                @php $count = 0; @endphp
                                                @foreach ($tailles as $t)
                                                    @php $count += $t->quantite; @endphp
                                                    <tr>
                                                        <td>{{ $t->unite_taille }}</td>
                                                        <td>
                                                            <input type="number" class="form-control qte"
                                                                name="quantite[]" value="{{ $t->quantite }}">
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
                                                        <button type="submit"
                                                            id="add-buttonTaille-{{ $demande[0]->id }}"
                                                            class="btn btn-info">Ajouter</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @elseif ($somme != 0)
                                            <tbody id="table-body">
                                                @php $count = 0; @endphp
                                                @foreach ($tailles as $t)
                                                    @php $count += $t->quantite; @endphp
                                                    <tr>
                                                        <td>{{ $t->unite_taille }}</td>
                                                        <td>
                                                            <input type="number" class="form-control qte"
                                                                name="quantite[]" value="{{ $t->quantite }}" disabled>
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
                                        @endif

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
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-toggle="modal" data-target="#confirmDeleteModalDossier"
                                                        data-id="{{ $ds->id }}"
                                                        data-id-demande="{{ $ds->id_demande_client }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
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
                        <form action="{{ route('LBT.listeLBT') }}" method="GET">
                            <button type="submit" class="btn btn-success mr-3">Voir liste</button>
                        </form>


                    </div>
                </div>

            </div>


            <!-- Modal suivi flux serigraphie -->
            <div class="modal fade" id="suiviFlux" tabindex="-1" role="dialog"
                aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="choixEtapeModalLabel">Insertion suivi flux LBT
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('LBT.insertSuiviFluxLBT') }}" method="POST"
                                autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mt-1">
                                        <div class="row no-gutters">
                                            <div class="col-12">
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
                                                <label class="col-form-label texte">Type pieces</label>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-control" name="typePiece">
                                                    <option value="1">Panneau</option>
                                                    <option value="2">Piece</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters  mt-3">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Type flux</label>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-control" name="typeFlux">
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
                                                <input type="number" name="qte" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters  mt-3">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Type LBT</label>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-control" name="typeLBT">
                                                    <option value="1">Lavage</option>
                                                    <option value="2">Blanchissement</option>
                                                    <option value="2">Teinture</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="row no-gutters  mt-3">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Recoupe</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="number" name="recoupe" class="form-control"
                                                    required>
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

    <!--**********************************
        Content body end
***********************************-->
    @include('CRM.footer')
