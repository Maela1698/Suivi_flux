@include('CRM.header')
@include('CRM.sidebar')
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
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('MES.headerMES')
        <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
            <div class="col-lg-6 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité PO</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qte_po }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-list"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #f3904f, #3b4371);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité Coupé</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qte_coupe }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-times-circle"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 0;margin-top: -10px;">
            <div class="col-lg-4 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité Entrée Chaine</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qte_entree_chaine }}
                                </h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #82a382, #000c40);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité Transferé</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qte_transfere }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-box"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #667eea, #764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Balance à transferer
                            </h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $balanceatransferer }}
                                </h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-industry"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 0;">
            <div class="col-lg-4 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité Prêt à livrer</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qte_pret_livrer }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #82a382, #000c40);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantité déjà livrer</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qte_deja_livrer }}
                                </h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-box"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #667eea, #764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white"
                                style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Balance à livrer
                            </h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $balancealivrer }}
                                </h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-industry"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 0;">
            <div class="col-lg-4 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white"
                                style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Entrée repassage</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $entree_repassage }}
                                </h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #82a382, #000c40);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white"
                                style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Sortie repassage</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $sortie_repassage }}
                                </h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-box"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #667eea, #764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white"
                                style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Balance repassage
                            </h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $balancerepassage }}
                                </h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-industry"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-12">

            <div class="justify-content-center align-items-center entete">
                <h3 class="entete mt-3">LISTE SUIVIS FLUX MES</h3>
            </div>

            <form action="{{ route('MES.suiviFlux') }}" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-3 mr-1">
                        <div class="row texte">
                            <label>Date ex-factory</label>
                        </div>
                        <div class="row">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="startEntree" value="">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="endEntree" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-2 mr-1">
                        <div class="row texte">
                            <label>OF</label>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <input type="text" name="of" class="form-control" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-2 mr-1">
                        <div class="row texte">
                            <label>Style</label>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <input type="text" name="modele" class="form-control" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 col-lg-2">
                        <div class="row texte">
                            <label>Client</label>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <input type="text" id="nomTiers" name="nomTiers" class="form-control" value="">
                                <input type="hidden" id="idTiers" name="idTiers" value="">
                                <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="row texte">
                            <label>Designation</label>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <input type="text" id="nomStyle" name="nomStyle" class="form-control" value="">
                                <input type="hidden" id="idStyle" name="idStyle" value="">
                                <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>

                    </div>




                </div>
                <div class="row mt-2">
                    <div class="col-9">
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <button class="btn btn-success" style="width: 100px">Filtrer</button>
                    </div>
                </div>

            </form>

            <div class="table-responsive" style="margin-top: -15px;">
                <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>ColorCode</th>
                            <th>Style</th>
                            <th>OF NO</th>
                            <th>Designation</th>
                            <th>Size</th>
                            <th>Qte P.O</th>
                            <th>Qte Coupe</th>
                            <th>Qte Entree chaine</th>
                            <th>Qte transferes(sortie chaine)</th>
                            <th>Balance a transfere</th>
                            <th>Pret a livrer(BOXING)</th>
                            <th>Qte deja livre(Expediee)</th>
                            <th>Balance a livrer(Expediee)</th>
                            <th>Entree repassage</th>
                            <th>Sortie repassage</th>
                            <th>Balance repassage</th>
                            <th>Ex-Factory</th>
                            <th>Commentaire</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody style="cursor: pointer;">
                        {{--  <tr>
                            <td>Client 2</td>
                            <td>ColorCode 2</td>
                            <td>Style 2</td>
                            <td>OF NO 2</td>
                            <td>Designation 2</td>
                            <td>Size 2</td>
                            <td>Qte P.O 2</td>
                            <td>Qte Coupe 2</td>
                            <td>Qte Entree chaine 2</td>
                            <td>Qte transferes(sortie chaine) 2</td>
                            <td>Balance a transfere 2</td>
                            <td>Pret a livrer(BOXING) 2</td>
                            <td>Qte deja livre(Expediee) 2</td>
                            <td>Balance a livrer(Expediee) 2</td>
                            <td>Entree repassage 2</td>
                            <td>Sortie repassage 2</td>
                            <td>Balance repassage 2</td>
                            <td>Ex-Factory 2</td>
                            <td>
                                <button data-toggle="modal" data-target="#commentaire"
                                    data-commentaires="Commentaire 2"
                                    style="background-color: transparent; border: none;"> Commentaire 2</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-finish mt-1 btn-sm"
                                    style="width: 90px;" data-toggle="modal" data-target="#modifSuiviFlux"
                                    data-qtepo="Qte P.O 2" data-qtecoupe="Qte Coupe 2"
                                    data-qteentreechaine="Qte Entree chaine 2"
                                    data-qtetransferes="Qte transferes(sortie chaine) 2"
                                    data-pretalivrer="Pret a livrer(BOXING) 2"
                                    data-qtedejalivre="Qte deja livre(Expediee) 2"
                                    data-entreerepassage="Entree repassage 2"
                                    data-sortierepassage="Sortie repassage 2">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>

                            </td>
                        </tr>  --}}
                        @for ($i = 0; $i < count($suivi); $i++)
                            <tr>
                                <td>{{ $suivi[$i]->nomtier }}</td>
                                <td>{{ $suivi[$i]->couleur }}</td>
                                <td>{{ $suivi[$i]->nom_modele }}</td>
                                <td>{{ $suivi[$i]->numero_commande }}</td>
                                <td>{{ $suivi[$i]->nom_style }}</td>
                                <td>{{ $suivi[$i]->unite_taille }}</td>
                                <td>{{ $suivi[$i]->qte_po }}</td>
                                <td>{{ $suivi[$i]->qte_coupe }}</td>
                                <td>{{ $suivi[$i]->qte_entree_chaine }}</td>
                                <td>{{ $suivi[$i]->qte_transfere }}</td>
                                <td>{{ $suivi[$i]->balanceatransferer }}</td>
                                <td>{{ $suivi[$i]->qte_pret_livrer }}</td>
                                <td>{{ $suivi[$i]->qte_deja_livrer }}</td>
                                <td>{{ $suivi[$i]->balancealivrer }}</td>
                                <td>{{ $suivi[$i]->entree_repassage }}</td>
                                <td>{{ $suivi[$i]->sortie_repassage }}</td>
                                <td>{{ $suivi[$i]->balancerepassage }}</td>
                                <td> {{ \Carbon\Carbon::parse($suivi[$i]->ex_factory)->format('d/m/y') }}</td>
                                <td>
                                    <?php
                                    $descriptions = substr($suivi[$i]->commentaire, 0, 20);
                                    $hasMore = strlen($suivi[$i]->commentaire) > 20;
                                    ?>
                                    <button data-toggle="modal" data-target="#commentaire"
                                        data-commentaires="{{ $suivi[$i]->commentaire }}"
                                        style="background-color: transparent; border: none;"> {{ $descriptions }}
                                        @if ($hasMore)
                                            ...
                                        @endif
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-finish mt-1 btn-sm"
                                        style="width: 90px;" data-toggle="modal" data-target="#modifSuiviFlux"
                                        data-qtepo="{{ $suivi[$i]->qte_po }}"
                                        data-qtecoupe="{{ $suivi[$i]->qte_coupe }}"
                                        data-qteentreechaine="{{ $suivi[$i]->qte_entree_chaine }}"
                                        data-qtetransferes="{{ $suivi[$i]->qte_transfere }}"
                                        data-pretalivrer="{{ $suivi[$i]->qte_pret_livrer }}"
                                        data-qtedejalivre="{{ $suivi[$i]->qte_deja_livrer }}"
                                        data-entreerepassage="{{ $suivi[$i]->entree_repassage }}"
                                        data-sortierepassage="{{ $suivi[$i]->sortie_repassage }}"
                                        data-commentaire="{{ $suivi[$i]->commentaire }}"
                                        data-idsuivi="{{ $suivi[$i]->id }}">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>

                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>


        </div>

        <!-- Modification suiviFlux -->
        <div class="modal fade" id="modifSuiviFlux" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Modification suivi flux</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body texte">
                        <form action="{{ route('MES.modificationSuiviMes') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="idSuivi" id="idSuivi">
                                <label for="qtePo">Qte P.O</label>
                                <input type="text" class="form-control" id="qtePo1" name="qtePo" disabled>
                            </div>
                            <div class="form-group">
                                <label for="qteCoupe">Qte Coupe</label>
                                <input type="text" class="form-control" id="qteCoupe" name="qteCoupe">
                            </div>
                            <div class="form-group">
                                <label for="qteEntreeChaine">Qte Entree chaine</label>
                                <input type="text" class="form-control" id="qteEntreeChaine"
                                    name="qteEntreeChaine">
                            </div>
                            <div class="form-group">
                                <label for="qteTransferes">Qte transferes (sortie chaine)</label>
                                <input type="text" class="form-control" id="qteTransferes" name="qteTransferes">
                            </div>
                            <div class="form-group">
                                <label for="pretALivrer">Pret a livrer (BOXING)</label>
                                <input type="text" class="form-control" id="pretALivrer" name="pretALivrer">
                            </div>
                            <div class="form-group">
                                <label for="qteDejaLivre">Qte deja livree (Expediee)</label>
                                <input type="text" class="form-control" id="qteDejaLivre" name="qteDejaLivre">
                            </div>
                            <div class="form-group">
                                <label for="entreeRepassage">Entree Repassage</label>
                                <input type="text" class="form-control" id="entreeRepassage"
                                    name="entreeRepassage">
                            </div>
                            <div class="form-group">
                                <label for="sortieRepassage">Sortie Repassage</label>
                                <input type="text" class="form-control" id="sortieRepassage"
                                    name="sortieRepassage">
                            </div>
                            <div class="form-group">
                                <label for="sortieRepassage">Commentaire</label>
                                <input type="text" class="form-control" id="commentaires" name="commentaire">
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


        <!-- Commentaire -->
        <div class="modal fade" id="commentaire" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Commentaire</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body texte">
                        <input type="text" class="form-control" id="commentaireModal" disabled>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#modifSuiviFlux').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché l'ouverture
            var modal = $(this);

            // Récupérer les valeurs des attributs data-*
            var qtePo = button.data('qtepo');
            var qteCoupe = button.data('qtecoupe');
            var qteEntreeChaine = button.data('qteentreechaine');
            var qteTransferes = button.data('qtetransferes');
            var pretALivrer = button.data('pretalivrer');
            var qteDejaLivre = button.data('qtedejalivre');
            var entreeRepassage = button.data('entreerepassage');
            var sortieRepassage = button.data('sortierepassage');
            var commentaire = button.data('commentaire');
            var idsuivi = button.data('idsuivi');
            console.log(qtePo);
            // Remplir les champs du formulaire
            modal.find('#qtePo1').val(qtePo);
            modal.find('#qteCoupe').val(qteCoupe);
            modal.find('#qteEntreeChaine').val(qteEntreeChaine);
            modal.find('#qteTransferes').val(qteTransferes);
            modal.find('#pretALivrer').val(pretALivrer);
            modal.find('#qteDejaLivre').val(qteDejaLivre);
            modal.find('#entreeRepassage').val(entreeRepassage);
            modal.find('#sortieRepassage').val(sortieRepassage);
            modal.find('#commentaires').val(commentaire);
            modal.find('#idSuivi').val(idsuivi);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#commentaire').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché l'ouverture
            var modal = $(this);

            // Récupérer les valeurs des attributs data-*
            var commentaires = button.data('commentaires');

            modal.find('#commentaireModal').val(commentaires);
        });
    });
</script>

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
                                idTiers.value = tier.id;
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


{{--  style  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomStyle');
        var idSaison = document.getElementById('idStyle');
        var suggestionsList = document.getElementById('suggestionsListStyle');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-style') }}?nomStyle=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.nom_style;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.nom_style;
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


@include('CRM.footer')
