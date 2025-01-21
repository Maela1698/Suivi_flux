@include('CRM.header')
@include('CRM.sidebar')
<title>ListerapportJournalierLBT</title>

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
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('VAMM.headerVAMM')
        {{--  <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
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

        </div>  --}}
        {{--
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
        </div>  --}}

        <div class="row mt-3">
            <div class="card col-12">

                <div class="d-flex justify-content-between align-items-center entete">

                    <h3 class="entete mt-3">RAPPORT JOURNALIER LBT</h3>



                    <div class="ml-auto d-flex">


                        <button type="button" class="btn btn-primary btn-finish mt-1 btn-sm mr-2" style="width: 170px;"
                            data-toggle="modal" data-target="#rapportJournalierLavage">
                            <i class="fas fa-water"></i> Lavage && <i class="fas fa-soap"></i> Blanchissement
                        </button>

                        <button type="button" class="btn btn-secondary btn-finish mt-1 btn-sm mr-2"
                            style="width: 170px;" data-toggle="modal" data-target="#rapportJournalierTeintureDev">
                            <i class="fas fa-search"></i> Recherche de coloris
                        </button>

                        <button type="button" class="btn btn-info btn-finish mt-1 btn-sm mr-2" style="width: 170px;"
                            data-toggle="modal" data-target="#rapportJournalier">
                            <i class="fas fa-fill-drip"></i> Teinture Prod
                        </button>

                    </div>
                </div>

                {{--  <form action="{{ route('SERIGRAPHIE.listeRapportJournalier') }}" method="post" autocomplete="off">
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
                </form>  --}}

                <div class="table-responsive mt-4" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th style="width: 200px">Date rapport</th>
                                <th style="width: 150px">Type</th>
                                <th style="width: 150px">NbPanneaux</th>
                                <th style="width: 150px">NbPieceProduite</th>
                                <th style="width: 150px">PoidsProduite</th>
                                <th style="width: 150px">ConsoP°Chimique </th>
                                <th style="width: 150px">Valeur(Euro)</th>
                                <th style="width: 150px">ConsoGasoil</th>
                                <th style="width: 100px">Valeur(Euro)</th>
                                <th style="width: 150px">ConsoElec</th>
                                <th style="width: 150px">Valeur(Euro)</th>
                                <th style="width: 150px">TauxRejet</th>
                                <th>TauxRetouche</th>
                                <th>TauxAbsenteisme</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                             @for ($i = 0; $i < count($rapportTeintureProd); $i++)
                                <tr onclick="window.location.href = '{{ route('SERIGRAPHIE.formModifRapportJournalierSer', ['idRapport' => $rapportTeintureProd[$i]->id]) }}';"
                                    style="cursor: pointer;">
                                    <td>{{ \Carbon\Carbon::parse($rapportTeintureProd[$i]->daterapport)->format('d/m/y H:i') }}
                                    </td>
                                    <td>{{ $rapportTeintureProd[$i]->type_lbt }} (Prod)</td>
                                    <td>{{ $rapportTeintureProd[$i]->nombre_panneau }} </td>
                                    <td> </td>
                                    <td>{{ $rapportTeintureProd[$i]->poidsproduite }}</td>
                                    <td>{{ $rapportTeintureProd[$i]->conso_produit_chimique }} </td>
                                    <td>{{ $rapportTeintureProd[$i]->valeur_produit_chimique }}</td>
                                    <td>{{ $rapportTeintureProd[$i]->conso_gasoil }}</td>
                                    <td>{{ $rapportTeintureProd[$i]->valeur_gasoil }}</td>
                                    <td>{{ $rapportTeintureProd[$i]->conso_electrique }}</td>
                                    <td>{{ $rapportTeintureProd[$i]->valeur_electricite }}</td>
                                    <td>{{ $rapportTeintureProd[$i]->taux_rejet }}%</td>
                                    <td>{{ $rapportTeintureProd[$i]->taux_retouche }}%</td>

                                </tr>
                            @endfor


                             @for ($i = 0; $i < count($rapportTeintureDev); $i++)
                                <tr onclick="window.location.href = '{{ route('SERIGRAPHIE.formModifRapportJournalierSer', ['idRapport' => $rapportTeintureDev[$i]->id]) }}';"
                                    style="cursor: pointer;">
                                    <td>{{ \Carbon\Carbon::parse($rapportTeintureDev[$i]->daterapport)->format('d/m/y H:i') }}
                                    </td>
                                    <td>{{ $rapportTeintureDev[$i]->type_lbt }} (Dev)</td>
                                    <td></td>
                                    <td> </td>
                                    <td></td>
                                    <td>{{ $rapportTeintureDev[$i]->conso_produit_chimique }} </td>
                                    <td>{{ $rapportTeintureDev[$i]->valeur_produit_chimique }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $rapportTeintureDev[$i]->taux_rejet }}%</td>
                                    <td>{{ $rapportTeintureDev[$i]->taux_retouche }}%</td>

                                </tr>
                            @endfor

                            @for ($i = 0; $i < count($rapportLavage); $i++)
                            <tr onclick="window.location.href = '{{ route('SERIGRAPHIE.formModifRapportJournalierSer', ['idRapport' => $rapportLavage[$i]->id]) }}';"
                                style="cursor: pointer;">
                                <td>{{ \Carbon\Carbon::parse($rapportLavage[$i]->date_rapport)->format('d/m/y H:i') }}
                                </td>
                                <td>{{ $rapportLavage[$i]->type_lavage }}</td>
                                <td></td>
                                <td> {{ $rapportLavage[$i]->nb_piece_lave }}</td>
                                <td>{{ $rapportLavage[$i]->poidsproduite }}</td>
                                <td> {{ $rapportLavage[$i]->conso_produit_chimique }}</td>
                                <td>{{ $rapportLavage[$i]->valeur_produit_chimique }}</td>
                                <td>{{ $rapportLavage[$i]->conso_gasoil }}</td>
                                <td>{{ $rapportLavage[$i]->valeur_gasoil }}</td>
                                <td>{{ $rapportLavage[$i]->conso_electrique }}</td>
                                <td>{{ $rapportLavage[$i]->valeur_electricite }}</td>
                                <td>{{ $rapportLavage[$i]->taux_rejet }}%</td>
                                <td>{{ $rapportLavage[$i]->taux_retouche }}%</td>
                                <td></td>
                            </tr>
                        @endfor


                        </tbody>
                    </table>
                </div>


            </div>
        </div>



        <!-- Modal rapport journalier teinture prod -->
        <div class="modal fade" id="rapportJournalier" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Rapport journalier teinture prod </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('LBT.insertRapportJournalierTeintureProd') }}" method="POST"
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
                                            <label class="texte">Nombre teinte</label><br>
                                            <input type="text" class="form-control" name="nbTeinte" value="0"
                                                required>
                                        </div>
                                        <div class="col-5 ">
                                            <label class="texte">Nombre panneaux</label><br>
                                            <input type="text" name="nbPanneau" class="form-control" value="0"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Nombre rejet panneaux</label><br>
                                            <input type="text" class="form-control" name="nbRejetPanneau"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Nombre retouche panneaux</label><br>
                                            <input type="text" name="nbRetouchePanneau" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Conso gasoil(litre) </label><br>
                                            <input type="text" class="form-control" name="consoGasoil"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Prix unitaire gasoil(Euro)</label><br>
                                            <input type="text" name="prixUnitaireGasoil" class="form-control"
                                                value="1.275" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Conso produit chimique </label><br>
                                            <input type="text" class="form-control" name="consoProduitChimique"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Prix produit chimique(Euro)</label><br>
                                            <input type="text" name="prixProduitChimique" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Conso electrique </label><br>
                                            <input type="text" class="form-control" name="consoElectrique"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Prix kilowattheure(Euro)</label><br>
                                            <input type="text" name="prixKWh" class="form-control" value="0.175"
                                                required>
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


        <!-- Modal rapport journalier teinture dev -->
        <div class="modal fade" id="rapportJournalierTeintureDev" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Rapport journalier teinture dev </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('LBT.insertRapportJournalierTeintureDev') }}" method="POST"
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
                                        <div class="col-3 mr-1">
                                            <label class="texte">Nb couleur recherché</label><br>
                                            <input type="text" class="form-control" name="nbCouleurRecherche"
                                                value="0" required>
                                        </div>
                                        <div class="col-3 mr-1 ">
                                            <label class="texte">Nb couleur realise</label><br>
                                            <input type="text" name="nbCouleurRealise" class="form-control"
                                                value="0" required>
                                        </div>
                                        <div class="col-3 mr-1 ">
                                            <label class="texte">Nb tentative</label><br>
                                            <input type="text" name="nbTentative" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Conso produit chimique</label><br>
                                            <input type="text" class="form-control" name="consoProduitChimique"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Valeur produit chimique</label><br>
                                            <input type="text" name="valeurProduitChimique" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Taux rejet(%) </label><br>
                                            <input type="text" class="form-control" name="tauxRejet"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Taux retouche(%)</label><br>
                                            <input type="text" name="tauxRetouche" class="form-control"
                                                value="0" required>
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

        <!-- Modal rapport journalier lavage -->
        <div class="modal fade" id="rapportJournalierLavage" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Rapport journalier lavage </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('LBT.insertRapportJournalierLavage') }}" method="POST"
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
                                        <div class="col-5  mr-2">
                                            <label class="texte">Type lavage</label><br>
                                            <select class="form-control" name="type">
                                                <option value="Lavage">Lavage</option>
                                                <option value="Blanchissement">Blanchissement</option>
                                            </select>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Nombre pièces lavés </label><br>
                                            <input type="text" class="form-control" name="nbPieceLave"
                                                value="0" required>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Conso gasoil(litre)</label><br>
                                            <input type="text" class="form-control" name="consoGasoil"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Prix unitaire gasoil(Euro)</label><br>
                                            <input type="text" name="prixGasoil" class="form-control"
                                                value="1.275" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Conso produit chimique(kg)</label><br>
                                            <input type="text" class="form-control" name="consoProduitChimique"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Valeur produit chimique(euro)</label><br>
                                            <input type="text" name="valeurProduitChimique" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Conso électrique </label><br>
                                            <input type="text" class="form-control" name="consoElectrique"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Prix kwh</label><br>
                                            <input type="text" name="prixKwh" class="form-control"
                                                value="0.175" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">NC Traités </label><br>
                                            <input type="text" class="form-control" name="ncTraite"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Absenteisme</label><br>
                                            <input type="text" name="absenteisme" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-5 mr-2">
                                            <label class="texte">Taux rejet(%) </label><br>
                                            <input type="text" class="form-control" name="tauxRejet"
                                                value="0" required>
                                        </div>
                                        <div class="col-5">
                                            <label class="texte">Taux retouche(%)</label><br>
                                            <input type="text" name="tauxRetouche" class="form-control"
                                                value="0" required>
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
