@include('CRM.header')
@include('CRM.sidebar')

<style>
    #suggestionsList {
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
</style>
<style>
    .entete {

        color: #7571f9;
        /* Ajuster la couleur du texte si n�cessaire */
    }

    .card-small {
        height: 110px;
        /* Ajustez cette valeur selon vos besoins */
        padding: 10px;
    }

    .card-small .card-title {
        font-size: 1.3rem;
        /* Taille de la police du titre */
    }

    .card-small h2 {
        font-size: 2rem;
        /* Taille de la police du chiffre */
    }

    .card-small .display-5 {
        font-size: 2.2rem;
        /* Taille de l'ic�ne */
        opacity: 0.5;
        /* Garder l'opacit� comme avant */
    }


    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        transform: translate3d(0, 0, 0);
        will-change: transform;
        display: none;
    }

    .texte {
        color: black;
    }
</style>

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
</style>

<style>
    /* Style par défaut du bouton */
    .custom-btn {
        transition: background-color 0.2s ease; /* Animation douce */
    }

    /* Style lorsque le bouton est survolé */
    .custom-btn:hover {
        background-color: #5b5b5b; /* Couleur light */
        color: #d9d9d9; /* Texte sombre pour contraster */
    }
    </style>
<!--**********************************
            Content body start
        ***********************************-->

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerBc')
        <div class="row" style="margin-top: -12px;">
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1 card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Nbr Réclamation</h3>
                        <div class="d-inline-block mb-5">
                            <h2 class="text-white">{{ number_format($nombre, 0, ',', ' ') }}
                            </h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-exclamation-circle"
                                style="color: white;font-size:25px;"></i></span>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #e13a4e, #556770);">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Valeur Réclamé</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($valeurreclame, 0, ',', ' ') }}€</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-coins"
                                style="color: white;font-size:25px;"></i></span>

                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-4 card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #16a085, #f4d03f);">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Valeur Compensé</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($compense, 0, ',', ' ') }}€</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-handshake"
                                style="color: white;font-size:25px;"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(135deg, #B48EAD 0%, #5E81AC 100%);">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Reste à Réclamé</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($reste, 0, ',', ' ') }}€</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-hourglass-half"
                                style="color: white;font-size:25px;"></i></span>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="margin-top: -20px;">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">RECLAMATION FOURNISSEUR</h3>
                    <form action="{{ route('CRM.chartreclamation') }}" method="get">
                        @csrf
                        <button class="btn btn-light custom-btn" style="margin-right: 15px;">
                            <img src="../../images/chart.png" alt="Logo" width="30px" height="20px">
                        </button>
                    </form>
                </div>
                <br>
                <div class="card-body" style="margin-top: -15px;">
                    <form action="{{ route('CRM.listeDemande') }}" method="get" autocomplete="off">
                        @csrf
                        <div class="row" style="margin-top: -20px;">
                            <div class="col-4   ">
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startLivre">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="endLivre">
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" id="nomTiers" class="form-control" placeholder="Fournisseur">
                                    <input type="hidden" id="idTiers" name="idTiers">
                                    <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" id="nomSaison" class="form-control"
                                        placeholder="Client">
                                    <input type="hidden" id="idSaison" name="idSaison">
                                    <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" id="nomSaison" class="form-control"
                                        placeholder="Numero BC">
                                    <input type="hidden" id="idSaison" name="idSaison">
                                    <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="form-group">
                                        <button class="btn btn-success">Filtrer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover" style="overflow-x: auto; display: block; white-space: nowrap;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Modèle</th>
                                    <th>Client</th>
                                    <th>Numero BC</th>
                                    <th>Fournisseur</th>
                                    <th>Article</th>
                                    <th>Prix Unitaire</th>
                                    <th>Quantité</th>
                                    <th>Prix total</th>
                                    <th>Date réclamation</th>
                                    <th>Date relance</th>
                                    <th>Qte à réclamer</th>
                                    <th>Qte compensée</th>
                                    <th>Rst à réclamé</th>
                                    <th>Vlr réclamé</th>
                                    <th>Vlr compensé</th>
                                    <th>Commentaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailbc as $d)
                                    <tr onclick="window.location.href = '{{ route('CRM.historiqueReclamation', ['idDonneBc' => $d->donne_bc_id]) }}';" style="cursor: pointer;">
                                        <td>{{ $d->nom_modele }}</td>
                                        <td>{{ $d->client_nomtier }}</td>
                                        <td>{{ $d->numero_bc }}</td>
                                        <td>{{ $d->nomtier }}</td>
                                        @if($d->tissus_id!=null && $d->accessoire_id==null)
                                        <td>{{ $d->donne_bc_designation }}/{{ $d->tissus_ref }}</td>
                                        @endif
                                        @if($d->tissus_id==null && $d->accessoire_id!=null)
                                        <td>{{ $d->donne_bc_designation }}/{{ $d->accessoire_ref }}</td>
                                        @endif
                                        <td>{{ $d->donne_bc_prix_unitaire }}€</td>
                                        <td>{{ $d->donne_bc_quantite }}</td>
                                        <td>{{ $d->donne_bc_prix_unitaire*$d->donne_bc_quantite }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->dateenvoie)->locale('fr')->translatedFormat('j/m/y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->daterelance)->locale('fr')->translatedFormat('j/m/y') }}</td>
                                        <td>{{ $d->total_quantite }}</td>
                                        <td>{{ $d->total_recompensation }}€</td>
                                        <td>{{ $d->total_reste }}€</td>
                                        <td>{{ $d->total_valeurreclame }}€</td>
                                        <td>{{ $d->total_valeurcompense }}€</td>
                                        <td>{{ $d->remarque }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
            Content body end
        ***********************************-->
@include('CRM.footer')
