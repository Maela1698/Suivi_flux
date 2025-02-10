@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.MES.suiviFlux.styleListeSuiviFlux')

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
        <div class="row kpi">
            <div class="col-3">
                <div class="card" style="height: 150px">
                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">QUANTITE PO </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">{{ number_format($qte_po, 0, ' ', ' ') }}</p>
                            <span style="color: #000000;">Nombre Of: {{ $nombreOf }}</span>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card" style="height: 150px">
                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">
                                @if ($etat == 1)
                                    <i class="fa-solid fa-check text-success" style="font-size: 20px;"></i>
                                @endif
                                QUANTITE COUPE
                            </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">{{ number_format($qte_coupe, 0, ' ', ' ') }}</p>

                            <span style="color: #000000">Rejet: {{ number_format($pourcentageRejetCoupe, 0) }}%</span>
                        </center>
                        <h6>
                            <span class="pull-right">{{ number_format($pourcentageCoupe, 0) }}%</span>
                        </h6>
                        <div class="progress ">
                            <div class="progress-bar  progress-animated"
                                style="width: {{ number_format($pourcentageCoupe, 0) }}%; height:6px;"
                                role="progressbar">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card" style="height: 150px; cursor: pointer;"
                    onclick="ouvrirModal('{{ $qte_entree_chaine }}', '{{ $qte_transfere }}', '{{ $balanceatransferer }}')">

                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">SORTIE CHAINE</h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">{{ number_format($qte_transfere, 0, ' ', ' ') }}
                            </p>
                            <span style="color: white">Rejet: </span>
                        </center>
                        <h6>
                            <span class="pull-right">{{ number_format($pourcentageTransferer, 0) }}%</span>
                        </h6>
                        <div class="progress">
                            <div class="progress-bar progress-animated"
                                style="width: {{ number_format($pourcentageTransferer, 0) }}%; height:6px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card" style="height: 150px" onclick="ouvrirModalBalance('{{ $balancealivrer }}')">
                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">BOXING </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">
                                {{ number_format($qte_pret_livrer, 0, ' ', ' ') }}
                            </p>

                            <span style="color: #000000">Rejet: {{ number_format($pourcentageRejetChaine, 0) }}%</span>
                        </center>
                        <h6>
                            <span class="pull-right">{{ number_format($pourcentageBoxing, 0) }}%</span>
                        </h6>
                        <div class="progress ">
                            <div class="progress-bar  progress-animated"
                                style="width: {{ number_format($pourcentageBoxing, 0) }}%; height:6px;"
                                role="progressbar">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row gep mt-1">
            @include('MES.suivi.flux.deliveryDate')
            <div class="col-right">
                <div class="card" onclick="ouvrirModalBalance('{{ $balancealivrer }}')">
                    <div class="card-header d-block center">
                        <center>
                            <h4 class="card-title">EXPEDIEE </h4>
                        </center>
                    </div>
                    <div class="card-body">
                        <center>
                            <p style="font-size: 17px; color: #000000;">{{ $qte_deja_livrer }}</p>
                            <span style="color: white">Rejet: {{ number_format($pourcentageRejetChaine, 0) }}%</span>
                        </center>
                        <h6>
                            <span class="pull-right">{{ number_format($pourcentageExpediee, 0) }}%</span>
                        </h6>
                        <div class="progress ">
                            <div class="progress-bar  progress-animated"
                                style="width: {{ number_format($pourcentageExpediee, 0) }}%; height:6px;"
                                role="progressbar">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card col-12">
                <div style="display: flex;justify-content:space-between;">
                    <h3 class="entete mt-3">LISTE SUIVIS FLUX MES</h3>
                    <form action="{{ route('exportCSV') }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-file-csv"></i>Télécharger CSV
                        </button>
                    </form>
                </div>
                <br>
                <div>
                    <form action="{{ route('MES.suiviFlux') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="row g-3">
                            <!-- Date ex-factory -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold" style="color:rgb(122, 121, 121);">Date
                                    ex-factory</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="startEntree"
                                        value="{{ $startEntree }}">
                                    <span class="input-group-text">à</span>
                                    <input type="date" class="form-control" name="endEntree"
                                        value="{{ $endEntree }}">
                                </div>
                            </div>

                            <!-- OF -->
                            <div class="col-md-2">
                                <label class="form-label fw-bold" style="color:rgb(122, 121, 121);">OF</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    <input type="text" name="of" class="form-control"
                                        value="{{ $of }}">
                                </div>
                            </div>

                            <!-- Style -->
                            <div class="col-md-2">
                                <label class="form-label fw-bold" style="color:rgb(122, 121, 121);">Style</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tshirt"></i></span>
                                    <input type="text" name="modele" class="form-control"
                                        value="{{ $modele }}">
                                </div>
                            </div>

                            <!-- Client -->
                            <div class="col-md-2">
                                <label class="form-label fw-bold" style="color:rgb(122, 121, 121);">Client</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="nomTiers" name="nomTiers" class="form-control"
                                        value="{{ $nomTiers }}">
                                    <input type="hidden" id="idTiers" name="idTiers"
                                        value="{{ $idTiers }}">
                                    <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>

                            <!-- Designation -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold"
                                    style="color:rgb(122, 121, 121);">Designation</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" id="nomStyle" name="nomStyle" class="form-control"
                                        value="{{ $nomStyle }}">
                                    <input type="hidden" id="idStyle" name="idStyle"
                                        value="{{ $idStyle }}">
                                    <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>
                            <!-- Boutons -->
                            <button type="submit" class="btn btn-success"
                                style="margin-left:13px;margin-top: 15px;justify-content: flex-end;">
                                <i class="fas fa-filter"></i> Filtrer
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead class="thead-dark">
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
                                <th>Entree repassage</th>
                                <th>Sortie repassage</th>
                                <th>Balance repassage</th>

                                <th>Pret a livrer(BOXING)</th>
                                <th>Qte deja livre(Expediee)</th>
                                <th>Balance a livrer(Expediee)</th>
                                <th>Ex-Factory</th>
                                <th>Commentaire</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">

                            @for ($i = 0; $i < count($suivi); $i++)
                                <tr data-qtepo="{{ $suivi[$i]->qte_po }}"
                                    data-qtecoupe="{{ $suivi[$i]->qte_coupe }}"
                                    data-qteentreechaine="{{ $suivi[$i]->qte_entree_chaine }}"
                                    data-qtetransferes="{{ $suivi[$i]->qte_transfere }}"
                                    data-pretalivrer="{{ $suivi[$i]->qte_pret_livrer }}"
                                    data-qtedejalivre="{{ $suivi[$i]->qte_deja_livrer }}"
                                    data-entreerepassage="{{ $suivi[$i]->entree_repassage }}"
                                    data-sortierepassage="{{ $suivi[$i]->sortie_repassage }}"
                                    data-commentaire="{{ $suivi[$i]->commentaire }}"
                                    data-idsuivi="{{ $suivi[$i]->id }}"
                                    data-rejetcoupe="{{ $suivi[$i]->qte_rejet_coupe }}"
                                    data-rejetchaine="{{ $suivi[$i]->qte_rejet_chaine }}"
                                    data-etat="{{ $suivi[$i]->etat }}"
                                    data-exped="{{ $suivi[$i]->etat_exp }}" onclick="ouvrirModifSuiviFlux(this)">
                                    <td>
                                        {{ $suivi[$i]->nomtier }}
                                    </td>
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
                                    <td>{{ $suivi[$i]->entree_repassage }}</td>
                                    <td>{{ $suivi[$i]->sortie_repassage }}</td>
                                    <td>{{ $suivi[$i]->balancerepassage }}</td>
                                    <td>{{ $suivi[$i]->qte_pret_livrer }}</td>
                                    <td>{{ $suivi[$i]->qte_deja_livrer }}</td>
                                    <td>{{ $suivi[$i]->balancealivrer }}</td>
                                    <td> {{ \Carbon\Carbon::parse($suivi[$i]->ex_factory)->format('d/m/y') }}</td>
                                    <td onclick="event.stopPropagation();">
                                        <?php
                                        $descriptions = substr($suivi[$i]->commentaire, 0, 20);
                                        $hasMore = strlen($suivi[$i]->commentaire) > 20;
                                        ?>
                                        <button data-toggle="modal" data-target="#commentaireSuivi"
                                            data-commentaires="{{ $suivi[$i]->commentaire }}"
                                            style="background-color: transparent; border: none;">
                                            {{ $descriptions }}
                                            @if ($hasMore)
                                                ...
                                            @endif
                                        </button>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="repassageModal" tabindex="-1" aria-labelledby="repassageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repassageModalLabel">Détails du sortie</h5>

                    </div>
                    <div class="modal-body texte">
                        <p><strong>Entrée chaine :</strong> <span id="modalEntreeRepassage"></span></p>
                        <p><strong>Sortie chaine :</strong> <span id="modalSortieRepassage"></span></p>
                        <p><strong>Balance à transferer :</strong> <span id="modalBalanceRepassage"></span></p>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="balanceLivrer" tabindex="-1" aria-labelledby="repassageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repassageModalLabel">Détails du Transfert</h5>

                    </div>
                    <div class="modal-body texte">
                        <p><strong>Balance a livrer :</strong> <span id="balancealivrer"></span></p>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

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
                            @if (session('error'))
                                <ul style="color: red;">
                                    @foreach (explode('|', session('error')) as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <!-- Modification suiviFlux -->
        <div class="modal fade" id="modifSuiviFlux" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Modification suivi flux
                            {{ session('employe')[0]['role'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body texte">
                        <form action="{{ route('MES.modificationSuiviMes') }}" method="POST" autocomplete="off">
                            @csrf
                            @if (session('employe')[0]['role'] == 'Coupe' || session('employe')[0]['role'] == 'Admin')
                                <div id="checkboxContainer" class="mr-3" style="display: none; margin-top: 10px;">
                                    <label for="checkboxCondition">Coupe final</label>
                                    <input type="checkbox" id="checkboxCondition" value="1" name="coupeFinal">
                                </div>
                            @else
                                <div id="checkboxContainer" class="mr-3" style="display: none; margin-top: 10px;">
                                    <label for="checkboxCondition">Coupe final</label>
                                    <input type="checkbox" id="checkboxCondition" value="1" name="coupeFinal"
                                        readonly>
                                </div>
                            @endif
                            <div id="checkboxExpediee" class="mr-3" style="display: none; margin-top: 10px;">
                                <label for="checkboxCondition">Expediee</label>
                                <input type="checkbox" id="checkboxExpediees" value="true" name="expediee">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="startEntree"
                                    value="{{ $startEntree }}">
                                <input type="hidden" class="form-control" name="endEntree"
                                    value="{{ $endEntree }}">
                                <input type="hidden" name="of" class="form-control"
                                    value="{{ $of }}">
                                <input type="hidden" name="modele" class="form-control"
                                    value="{{ $modele }}">
                                <input type="hidden" name="nomTiers" value="{{ $nomTiers }}">
                                <input type="hidden" name="idTiers" value="{{ $idTiers }}">
                                <input type="hidden" name="nomStyle" value="{{ $nomStyle }}">
                                <input type="hidden" name="idStyle" value="{{ $idStyle }}">
                                <input type="hidden" name="idSuivi" id="idSuivi">
                                <label for="qtePo">Qte P.O</label>
                                <input type="text" class="form-control" id="qtePo1" name="qtePo">
                            </div>

                            @if (session('employe')[0]['role'] == 'Coupe' || session('employe')[0]['role'] == 'Admin')
                                <div class="form-group">
                                    <label for="qteCoupe">Qte Coupe</label>
                                    <input type="text" class="form-control" id="qteCoupe" name="qteCoupes">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="qteCoupe">Qte Coupe</label>
                                    <input type="text" class="form-control" id="qteCoupe" name="qteCoupes" readonly>
                                </div>
                            @endif

                            @if (session('employe')[0]['role'] == 'Prod' || session('employe')[0]['role'] == 'Admin')
                                <div class="form-group">
                                    <label for="qteEntreeChaine">Qte Entree chaine</label>
                                    <input type="text" class="form-control" id="qteEntreeChaine"
                                        name="qteEntreeChaine">
                                </div>
                                <div class="form-group">
                                    <label for="qteTransferes">Qte transferes (sortie chaine)</label>
                                    <input type="text" class="form-control" id="qteTransferes"
                                        name="qteTransferes">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="qteEntreeChaine">Qte Entree chaine</label>
                                    <input type="text" class="form-control" id="qteEntreeChaine"
                                        name="qteEntreeChaine" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="qteTransferes">Qte transferes (sortie chaine)</label>
                                    <input type="text" class="form-control" id="qteTransferes"
                                        name="qteTransferes" readonly>
                                </div>
                            @endif

                            @if (session('employe')[0]['role'] == 'Finition' || session('employe')[0]['role'] == 'Admin')
                                <div class="form-group">
                                    <label for="pretALivrer">Pret a livrer (BOXING)</label>
                                    <input type="text" class="form-control" id="pretALivrer" name="pretALivrer">
                                </div>
                                <div class="form-group">
                                    <label for="qteDejaLivre">Qte deja livree (Expediee)</label>
                                    <input type="text" class="form-control" id="qteDejaLivre"
                                        name="qteDejaLivre">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="pretALivrer">Pret a livrer (BOXING)</label>
                                    <input type="text" class="form-control" id="pretALivrer" name="pretALivrer"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="qteDejaLivre">Qte deja livree (Expediee)</label>
                                    <input type="text" class="form-control" id="qteDejaLivre" name="qteDejaLivre"
                                        readonly>
                                </div>
                            @endif


                            <div class="form-group">
                                {{--  <label for="entreeRepassage">Entree Repassage</label>  --}}
                                <input type="hidden" class="form-control" id="entreeRepassage"
                                    name="entreeRepassage">
                            </div>
                            <div class="form-group">
                                {{--  <label for="sortieRepassage">Sortie Repassage</label>  --}}
                                <input type="hidden" class="form-control" id="sortieRepassage"
                                    name="sortieRepassage">
                            </div>

                            @if (session('employe')[0]['role'] == 'Coupe' || session('employe')[0]['role'] == 'Admin' || session('employe')[0]['role'] == 'CRM')
                                <div class="form-group">
                                    <label for="rejetCoupe">Qte rejet coupe</label>
                                    <input type="text" class="form-control" id="rejetCoupe" name="rejetCoupe">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="rejetCoupe">Qte rejet coupe</label>
                                    <input type="text" class="form-control" id="rejetCoupe" name="rejetCoupe"
                                        readonly>
                                </div>
                            @endif

                            @if (session('employe')[0]['role'] == 'Prod' || session('employe')[0]['role'] == 'Admin')
                                <div class="form-group">
                                    <label for="rejetChaine">Qte rejet chaine</label>
                                    <input type="text" class="form-control" id="rejetChaine" name="rejetChaine">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="rejetChaine">Qte rejet chaine</label>
                                    <input type="text" class="form-control" id="rejetChaine" name="rejetChaine"
                                        readonly>
                                </div>
                            @endif

                            @if (session('employe')[0]['role'] == 'Prod' ||
                                    session('employe')[0]['role'] == 'Finition' ||
                                    session('employe')[0]['role'] == 'Coupe' || session('employe')[0]['role'] == 'Admin'
                                    || session('employe')[0]['role'] == 'CRM')
                                <div class="form-group">
                                    <label for="sortieRepassage">Commentaire</label>
                                    <input type="text" class="form-control" id="commentaires" name="commentaire">
                                </div>

                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="sortieRepassage">Commentaire</label>
                                    <input type="text" class="form-control" id="commentaires" name="commentaire"
                                        readonly>
                                </div>

                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-success" disabled>Enregistrer</button>
                                </div>
                            @endif
                        </form>
                    </div>


                </div>
            </div>
        </div>


        <!-- Commentaire -->
        <div class="modal fade" id="commentaireSuivi" tabindex="-1" role="dialog"
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
        $('#commentaireSuivi').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché l'ouverture
            var modal = $(this);
            console.log('hey');
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

<script>
    // Afficher automatiquement le modal si une erreur est présente
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>

<!-- Script JavaScript -->
<script>
    function ouvrirModal(entree, sortie, balance) {
        document.getElementById('modalEntreeRepassage').textContent = Number(entree).toLocaleString('fr-FR');
        document.getElementById('modalSortieRepassage').textContent = Number(sortie).toLocaleString('fr-FR');
        document.getElementById('modalBalanceRepassage').textContent = Number(balance).toLocaleString('fr-FR');

        // Ouvrir la modal
        var modal = new bootstrap.Modal(document.getElementById('repassageModal'));
        modal.show();
    }
</script>

<!-- Script JavaScript -->
<script>
    function ouvrirModalBalance(balance) {
        document.getElementById('balancealivrer').textContent = Number(balance).toLocaleString('fr-FR');;

        // Ouvrir la modal
        var modal = new bootstrap.Modal(document.getElementById('balanceLivrer'));
        modal.show();
    }
</script>

<script>
    function ouvrirModifSuiviFlux(button) {
        // Récupérer les valeurs des attributs data-*
        var qtePo = button.getAttribute('data-qtepo');
        var qteCoupe = button.getAttribute('data-qtecoupe');
        var qteEntreeChaine = button.getAttribute('data-qteentreechaine');
        var qteTransferes = button.getAttribute('data-qtetransferes');
        var pretALivrer = button.getAttribute('data-pretalivrer');
        var qteDejaLivre = button.getAttribute('data-qtedejalivre');
        var entreeRepassage = button.getAttribute('data-entreerepassage');
        var sortieRepassage = button.getAttribute('data-sortierepassage');
        var commentaire = button.getAttribute('data-commentaire');
        var idsuivi = button.getAttribute('data-idsuivi');
        var rejetcoupe = button.getAttribute('data-rejetcoupe');
        var rejetchaine = button.getAttribute('data-rejetchaine');
        var etat = button.getAttribute('data-etat');
        var etatExp = button.getAttribute('data-exped');

        // Remplir les champs du formulaire
        document.getElementById('qtePo1').value = qtePo;
        document.getElementById('qteCoupe').value = qteCoupe;
        document.getElementById('qteEntreeChaine').value = qteEntreeChaine;
        document.getElementById('qteTransferes').value = qteTransferes;
        document.getElementById('pretALivrer').value = pretALivrer;
        document.getElementById('qteDejaLivre').value = qteDejaLivre;
        document.getElementById('entreeRepassage').value = entreeRepassage;
        document.getElementById('sortieRepassage').value = sortieRepassage;
        document.getElementById('commentaires').value = commentaire;
        document.getElementById('rejetCoupe').value = rejetcoupe;
        document.getElementById('rejetChaine').value = rejetchaine;
        document.getElementById('idSuivi').value = idsuivi;

        // Gérer l'affichage de la checkbox
        const checkboxContainer = document.getElementById('checkboxContainer');
        checkboxContainer.style.display = (qtePo <= qteCoupe) ? 'block' : 'none';

        const checkboxExpediee = document.getElementById('checkboxExpediee');
        checkboxExpediee.style.display = (qtePo <= qteDejaLivre) ? 'block' : 'none';

        // Désactiver ou activer l'input et la checkbox selon l'état
        const inputQteCoupe = document.getElementById('qteCoupe');
        const inputQDejaLivrer = document.getElementById('qteDejaLivre');
        const checkboxCondition = document.getElementById('checkboxCondition');
        const checkboxExpediees = document.getElementById('checkboxExpediees');

        if (etat == 1) {
            inputQteCoupe.readOnly = true;
            checkboxCondition.checked = true;
            checkboxCondition.disabled = true;

        } else {
            inputQteCoupe.readOnly = false;
            checkboxCondition.checked = false;
            checkboxCondition.disabled = false;
        }

        if(etatExp== true){
            inputQDejaLivrer.readOnly = true;
            checkboxExpediees.checked = true;
            checkboxCondition.disabled = true;
        }else{
            inputQDejaLivrer.readOnly = false;
            checkboxExpediees.checked = false;
            checkboxCondition.disabled = false;
        }

        // Ouvrir la modal
        var modal = new bootstrap.Modal(document.getElementById('modifSuiviFlux'));
        modal.show();
    }
</script>



@include('CRM.footer')
