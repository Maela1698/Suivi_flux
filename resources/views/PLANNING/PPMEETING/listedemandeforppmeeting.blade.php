@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.PLANNING.PPM.styleListePPMTrace')
<style>

    .code {
        display: flex;
        gap: 4px;
        /* Espace entre les cercles */
    }

    .circle {
        border: solid thin black;
        width: 30px;
        /* Largeur du cercle */
        height: 30px;
        /* Couleur de fond du cercle */
        color: white;
        /* Couleur du texte */
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        /* Rend le div rond */
        font-size: 24px;
        /* Taille du texte */
    }

    label {
        color: black;
        font-size: 12px;
    }

    #suggestionsListSaison {
        max-height: 200px;
        overflow-y: auto;
        color: white;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: black;
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
        color: white;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: black;
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
        color: white;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: black;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }
</style>
<!--**********************************
            Content body start
         ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: start;">
                    <h3 class="entete">LISTE DEMANDE FOR PPMEETING</h3>
                </div>

                <div class="card-body" style="margin-top: -15px;overflow: auto;">
                    {{-- KPI--}}
                    <div class="row">
                        {{-- KPI PPMEETING--}}
                        <div class="col-lg-6 col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">PPMeeting</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="card">
                                                <div class="stat-widget-one card-body ppm">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="fas fa-calendar total-nbr"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text ppm-color">PPM</div>
                                                        <div class="stat-digit ppm-color"><span class="nb-ppm">{{ $stat_ppm->nb_ppm }}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="card">
                                                <div class="stat-widget-one card-body achevement">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="fas fa-check-circle fini"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text achevement-color">Fini</div>
                                                        <div class="stat-digit achevement-color"><span class="taux-achevement">{{ $stat_ppm->taux_fini }}%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="card">
                                                <div class="stat-widget-one card-body retard">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="fas fa-clock retard"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text retard-color">Retard</div>
                                                        <div class="stat-digit retard-color"><span class="taux-retard">{{ $stat_ppm->taux_retard }}%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="card">
                                                <div class="stat-widget-one card-body temps">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="fas fa-user-slash absence"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text temps-color">Absence</div>
                                                        <div class="stat-digit temps-color"><span class="taux-abs">{{ $stat_ppm->taux_abs }}%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- KPI PPMEETING END--}}
                        {{-- KPI TRACE--}}
                        <div class="col-lg-6 col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">TRACE</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="card">
                                                <div class="stat-widget-one card-body ppm">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="fas fa-calendar total-nbr"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text ppm-color">TRACE</div>
                                                        <div class="stat-digit ppm-color"><span class="nb-ppm">{{ $stat_trace->nb_trace }}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="card">
                                                <div class="stat-widget-one card-body achevement">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="fas fa-check-circle fini"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text achevement-color">COMPLETION</div>
                                                        <div class="stat-digit achevement-color"><span class="taux-achevement">{{ $stat_trace->taux_fini }}%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="card">
                                                <div class="stat-widget-one card-body retard">
                                                    <div class="stat-icon d-inline-block">
                                                        <i class="fas fa-clock retard"></i>
                                                    </div>
                                                    <div class="stat-content d-inline-block">
                                                        <div class="stat-text retard-color">RETARD</div>
                                                        <div class="stat-digit retard-color"><span class="taux-retard">{{ $stat_trace->taux_retard }}%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- KPI TRACE END--}}
                    </div>
                    {{-- KPI END --}}
                    <form action="{{ route('LRP.listeDemandeForPpmeeting') }}" method="get" autocomplete="off">
                        @csrf
                        {{--NOTIA <div class="recherche" style="display: flex; flex-wrap: wrap; align-items: center;">

                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput">Client</label>
                                <input type="text" id="nomTiers" name="nomTiers" value="{{ $nomTiers }}"
                                    class="form-control" oninput="syncHiddenField('nomTiers', 'idTiers')">
                                <input type="hidden" id="idTiers" name="idTiers" value="{{ $idTiers }}">
                                <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput">Modele</label>
                                <input type="text" class="form-control mr-sm-2" id="inlineFormInput" name="modele"
                                    value="{{ $modele }}">
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput" style="color: transparent;">Search</label>
                                <input type="submit" style="background-color: rgb(51, 208, 51);width:80px;"
                                    class="form-control mr-sm-2" id="inlineFormInput" value="Filtrer">
                            </div>
                        </div> --}}
                        <div class="row align-items-end">
                            <div class="col-lg">
                                <label>Client</label>
                                <input class="form-control" list="clients" id="clientInput" name="client" placeholder="Client" value="{{ request('client') }}">
                                <datalist id="clients">
                                    @foreach ($clients as $client)
                                        <option data-id="{{ $client->id }}" value="{{ $client->nomtier }}"></option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" id="id_client" name="id_client" value="{{ request('id_client') }}">
                            </div>
                            <div class="col-lg">
                                <label>Modele</label>
                                <input class="form-control" type="text" name="nom_modele" placeholder="Modele" value="{{ request('nom_modele') }}">
                            </div>
                            <div class="col-lg">
                                <label>Date PPM</label>
                                <input class="form-control" id="date_ppm" type="text" name="date_ppm" placeholder="Date PPMeeting" value="{{ request('date_ppm') }}">
                            </div>
                            <div class="col-lg">
                                <label>Date Trace</label>
                                <input class="form-control" id="date_trace" type="text" name="date_trace" placeholder="Date Trace" value="{{ request('date_trace') }}">
                            </div>
                            <div class="col-lg">
                                <label>Date Ex-Usine</label>
                                <input class="form-control" id="date_ex" type="text" name="date_ex" placeholder="Date Ex-Factory" value="{{ request('date_ex') }}">
                            </div>
                            <div class="col-lg d-flex align-items-end">
                                <button class="btn btn-success" style="width: 100px">Filtrer</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Couleur</th>
                                <th>Date PPM</th>
                                <th>Date trace</th>
                                <th>Chaine</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Qté</th>
                                <th>VA</th>
                                <th>Date entree chaine</th>
                                <th>Date entree coupe</th>
                                <th>Date entree finition</th>
                                <th>Date ex usine</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($liste as $d)
                                <tr style="color: rgb(77, 77, 77);cursor: pointer;" data-demande="{{ $d->id }}"
                                    data-datemeeting="{{ $d->dateppm }}" data-designation="{{ $d->designation }}"
                                    data-entreechaine="{{ $d->date_entree_chaine }}"
                                    data-entreecoupe="{{ $d->date_entree_coupe }}"
                                    data-entreefinition="{{ $d->date_entree_finition }}"
                                    data-heuredebut="{{ $d->heure_debut }}"
                                    data-effectifprevu="{{ $d->effectif_prevu }}"
                                    data-effectifreel="{{ $d->effectif_reel }}"
                                    data-etat="{{ $d->etat_detailmeeting }}" data-commentaire="{{ $d->commentaire }}"
                                    data-idchaine="{{ $d->id_chaine }}" data-accessoire="{{ $d->accy }}"
                                    data-okprod="{{ $d->okprod }}" onclick="ouvrirModalPPMeeting(this)"
                                    @if ($d->tissus) onclick="ouvrirModalPPMeeting(this)"
                                        @else
                                        onclick="messageErreurTissu(this)" @endif>
                                    <td>
                                        <div class="code">
                                            @if ($d->tissus)
                                                <div class="circle"
                                                    style="background-color: green;font-size: 12px;color:white;">T</div>
                                            @else
                                                <div class="circle"
                                                    style="background-color: white;font-size: 12px;color:black;">T</div>
                                            @endif
                                            @if ($d->accy)
                                                <div class="circle"
                                                    style="background-color: green;font-size: 12px;color:white;">A</div>
                                            @else
                                                <div class="circle"
                                                    style="background-color: white;font-size: 12px;color:black;">A</div>
                                            @endif
                                            @if ($d->okprod)
                                                <div class="circle"
                                                    style="background-color: green;font-size: 12px;color:white;">Ok
                                                </div>
                                            @else
                                                <div class="circle"
                                                    style="background-color: white;font-size: 12px;color:black;">Ok
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($d->dateppm)
                                            {{ \Carbon\Carbon::parse($d->dateppm)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->datetrace)
                                            @if ($d->etat_trace == 1)
                                                <input type="text" name="datecalcule"
                                                    style="border: none;width:120px;text-align:center;border-radius:5px;cursor: pointer;  background-color:green; color: black"
                                                    value="{{ $d->datetrace }}" data-trace="{{ $d->datetrace }}"
                                                    data-demande="{{ $d->id }}"
                                                    data-etat="{{ $d->etat_trace }}"
                                                    onclick="modificationTrace(event, this)">
                                            @else
                                                <input type="text" name="datecalcule"
                                                    style="border: none;width:120px;text-align:center;border-radius:5px;cursor: pointer; background-color:#c7c4c4; color: black;"
                                                    value="{{ $d->datetrace }}" data-trace="{{ $d->datetrace }}"
                                                    data-demande="{{ $d->id }}"
                                                    data-etat="{{ $d->etat_trace }}"
                                                    onclick="modificationTrace(event, this)">
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $d->designation }}/{{ $d->id }}</td>
                                    <td>{{ $d->nomtier }}</td>
                                    <td>{{ $d->nom_modele }}</td>
                                    <td>{{ $d->qte_commande_provisoire }}</td>
                                    <td>{{ $d->types_valeur_ajout }}</td>
                                    <td>
                                        @if ($d->date_entree_chaine)
                                            {{ \Carbon\Carbon::parse($d->date_entree_chaine)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->date_entree_coupe)
                                            {{ \Carbon\Carbon::parse($d->date_entree_coupe)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->date_entree_finition)
                                            {{ \Carbon\Carbon::parse($d->date_entree_finition)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->ex_factory)
                                            {{ \Carbon\Carbon::parse($d->ex_factory)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Ajout ppmeeting -->
        <div class="modal fade" id="ppmeeting" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 360px" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Ajout PPMeeting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body texte" style="max-height: 800px; overflow-y: auto;">

                        <form action="{{ route('LRP.ajoutPPMeeting') }}" method="POST" autocomplete="off">
                            @csrf
                            <input type="hidden" name="demandePasse" id="demandePasse">
                            <input type="hidden" name="daty" id="daty">
                            <input type="hidden" name="modele" value="{{ $modele }}">
                            <input type="hidden" name="nomTiers" value="{{ $nomTiers }}">
                            <input type="hidden" name="idTiers" value="{{ $idTiers }}">
                            <div id="checkboxContainer" class="mr-3" style="margin-top: 10px;">
                                <label for="checkboxCondition">Fini</label>
                                <input type="checkbox" id="checkboxCondition" value="true" name="fini">
                            </div>

                            <div class="form-group">
                                <label>Date ppmeeting</label>
                                <input type="date" class="form-control" id="datys" name="dateppmeeting"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Heure ppmeeting</label>
                                <input type="time" class="form-control" id="heuredebuts" name="heureppmeeting"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Effectifs prévus</label>
                                <input type="number" class="form-control" id="effectifprevus" name="effectifPrevu"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Effectifs réels</label>
                                <input type="number" class="form-control" id="effectifreels" name="effectifReel"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Chaine</label>
                                <select class="form-control" name="chaineMeeting">
                                    @for ($c = 0; $c < count($chaine); $c++)
                                        <option value="{{ $chaine[$c]->id_chaine }}">{{ $chaine[$c]->designation }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Date entrée chaîne</label>
                                <input type="date" class="form-control" id="entreechaines" name="dateChaine"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Date entrée coupe</label>
                                <input type="date" class="form-control" id="entreecoupes" name="dateCoupe"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Date entrée finition</label>
                                <input type="date" class="form-control" id="entreefinitions" name="dateFinition"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Commentaire</label>
                                <input type="text" class="form-control" id="commentaires" name="commentaire"
                                    required>
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


        <!-- Erreur meeting -->
        <div class="modal fade" id="erreurtissu" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 360px" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">⚠️Attention</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body texte">
                        <div class="form-group">
                            <label>Le tissu n'est pas encore disponible du coup vous n'avez pas le droit de faire une
                                ppmetting sur cette modèle.</label>
                        </div>
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmation -->
        <div class="modal fade" id="confirmationAccessoire" tabindex="-1" role="dialog"
            aria-labelledby="confirmationAccessoireLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 360px" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationAccessoireLabel">⚠️Accessoire non disponible</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body texte">
                        <p>L'accessoire n'est pas disponible. Voulez-vous continuer ?</p>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-success" id="confirmerSuite">Continuer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal modification trace -->
        <div class="modal fade" id="modifTrace" tabindex="-1" role="dialog"
            aria-labelledby="confirmationAccessoireLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 360px" role="document">
                <div class="modal-content modal-content-custom">
                    <form action="{{ route('LRP.updateTrace') }}" autocomplete="off" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationAccessoireLabel">Modification trace</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body texte">
                            <input type="hidden" name="demandeTrace" id="demandeTrace">
                            <input type="hidden" name="modele" value="{{ $modele }}">
                            <input type="hidden" name="nomTiers" value="{{ $nomTiers }}">
                            <input type="hidden" name="idTiers" value="{{ $idTiers }}">
                            <div id="checkboxContainer" class="mr-3" style="margin-top: 10px;">
                                <label for="checkboxCondition">Fini</label>
                                <input type="checkbox" id="checkfiniTrace" value="1" name="finiTrace">
                            </div>

                            <div class="form-group">
                                <label>Date ppmeeting</label>
                                <input type="date" class="form-control" id="datetrace" name="datetrace" required>
                            </div>
                        </div>
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success">Modifier</button>
                        </div>
                    </form>
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
                                    <li>{{ session('error') }}</li>
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

    </div>
</div>


<!--**********************************
            Content body end
        ***********************************-->
@include('PLANNING.JS.jsListeDemandePPM')

@include('CRM.footer')



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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomStyle = document.getElementById('nomStyle');
        var idStyle = document.getElementById('idStyle');
        var suggestionsList = document.getElementById('suggestionsListStyle');

        nomStyle.addEventListener('input', function() {
            var query = nomStyle.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-style') }}?nomStyle=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var styles = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (styles.length > 0) {
                        styles.forEach(function(style) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = style.nom_style;
                            li.addEventListener('click', function() {
                                nomStyle.value = style.nom_style;
                                idStyle.value = style.id;
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
            if (!nomStyle.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>
<script>
    function syncHiddenField(textInputId, hiddenInputId) {
        const textInput = document.getElementById(textInputId);
        const hiddenInput = document.getElementById(hiddenInputId);

        if (textInput.value.trim() === '') {
            hiddenInput.value = ''; // Clear the hidden field if the text input is empty
        }
    }
</script>

{{--  modal de modification ppmeeting  --}}
<script>
    function ouvrirModalPPMeeting(button) {
        var iddemande = button.getAttribute('data-demande');
        var datemeeting = button.getAttribute('data-datemeeting');
        var entreechaine = button.getAttribute('data-entreechaine');
        var entreecoupe = button.getAttribute('data-entreecoupe');
        var entreefinition = button.getAttribute('data-entreefinition');
        var heuredebut = button.getAttribute('data-heuredebut');
        var effectifprevu = button.getAttribute('data-effectifprevu');
        var effectifreel = button.getAttribute('data-effectifreel');
        var commentaire = button.getAttribute('data-commentaire');
        var idchaine = button.getAttribute('data-idchaine');
        var designation = button.getAttribute('data-designation');
        var etat = button.getAttribute('data-etat');
        var accessoire = button.getAttribute('data-accessoire');

        // Remplir les champs du formulaire
        document.getElementById('daty').value = datemeeting;
        document.getElementById('datys').value = datemeeting;
        document.getElementById('demandePasse').value = iddemande;
        document.getElementById('entreechaines').value = entreechaine;
        document.getElementById('entreecoupes').value = entreecoupe;
        document.getElementById('entreefinitions').value = entreefinition;
        document.getElementById('heuredebuts').value = heuredebut;
        document.getElementById('effectifprevus').value = effectifprevu;
        document.getElementById('effectifreels').value = effectifreel;
        document.getElementById('commentaires').value = commentaire;

        const checkboxCondition = document.getElementById('checkboxCondition');
        if (etat == false) {
            checkboxCondition.checked = false;
        } else {
            checkboxCondition.checked = true;
        }

        if (!accessoire) {
            var modalConfirmation = new bootstrap.Modal(document.getElementById('confirmationAccessoire'));
            modalConfirmation.show();

            // Ajouter un événement pour continuer après confirmation
            document.getElementById('confirmerSuite').onclick = function() {
                modalConfirmation.hide();
                var modal = new bootstrap.Modal(document.getElementById('ppmeeting'));
                modal.show();
            };
        } else {
            // Ouvrir la modal
            var modal = new bootstrap.Modal(document.getElementById('ppmeeting'));
            modal.show();
        }
    }
</script>

<script>
    // Afficher automatiquement le modal si une erreur est présente
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>

{{--  modal aucun tissu  --}}
<script>
    function messageErreurTissu(button) {

        var modal = new bootstrap.Modal(document.getElementById('erreurtissu'));
        modal.show();
    }
</script>

<script>
    function modificationTrace(event, element) {
        event.stopPropagation(); // Empêche l'exécution des autres onclick sur <tr>
        var trace = element.getAttribute('data-trace');
        var demande = element.getAttribute('data-demande');
        var etat = element.getAttribute('data-etat');
        document.getElementById('datetrace').value = trace;
        document.getElementById('demandeTrace').value = demande;
        const checkfiniTrace = document.getElementById('checkfiniTrace');
        if (etat == 0) {
            checkfiniTrace.checked = false;
        } else {
            checkfiniTrace.checked = true;
        }

        var modal = new bootstrap.Modal(document.getElementById('modifTrace'));
        modal.show();
    }
</script>
