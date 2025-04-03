@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="row">
            <div class="col-md-6 col-xl-4 mb-4">
                <a href="#" class="card h-100 shadow border-left-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Total Stock
                                    </span></div>
                                <div class="text-dark font-weight-light mb-0">
                                    <span
                                        style="font-weight: bold;font-size: 20px">{{ number_format($totalEntree ?? 0, 0, ',', ' ') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-4 mb-4">
                <a href="#" class="card h-100 shadow border-left-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>Prix Total
                                    </span></div>
                                <div class="text-dark font-weight-bold h5 mb-0">
                                    <span style="font-size: 20px">{{ number_format($prixTotal ?? 0, 3, ',', ' ') }}
                                        €</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-4 mb-4">
                <a href="#" class="card h-100 shadow border-left-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span>Total
                                        métrage</span></div>
                                <div class="text-dark font-weight-bold h5 mb-0">
                                    <span style="font-size: 20px">{{ number_format($totalMetrage ?? 0, 3, ',', ' ') }}
                                        m</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="card">


            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h4 class="text-primary m-0 font-weight-bold">
                    STOCK {{ $familleTissu->famille_tissus }}
                </h4>

                <form action="{{ route('WMS.exportCSVStockTissu') }}" method="GET">
                    <input type="hidden" name="idcategorietissu" value="{{ $idCategorie }}/{{ $nomCategorie }}">
                    <input type="hidden" value="{{ $familleTissu->id }}" name="idfamilletissu">
                    <input type="hidden" value="{{ $idClasse }}/{{ $nomClasse }}" name="idclassematierepremiere">
                    <input type="hidden" value="{{ $idUtilisationWMS }}/{{ $nomUtilisationWMS }}" name="idutilisationwms">
                    <input type="hidden" value="{{ $idClient }}/{{ $nomClient }}" name="idclient">
                    <input type="hidden" value="{{ $idFournisseur }}/{{ $nomFournisseur }}" name="idfournisseur">
                    <input type="hidden" value="{{ $recherche }}" name="recherche">

                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-file-csv"></i> Exporter CSV
                    </button>
                </form>
            </div>



            <div class="card-body">
                <form action="{{ route('WMS.filtre-stock-tissu') }}" method="get" autocomplete="off">
                    @csrf
                    <input type="hidden" name="idfamilletissu" value="{{ $familleTissu->id }}">
                    <div class="row">
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idcategorietissu">
                                    <optgroup label="Catégorie du tissu">
                                        @if ($idCategorie == null)
                                            <option value="">Selection du catégorie du tissu</option>
                                        @else
                                            <option value="{{ $idCategorie }}/{{ $nomCategorie }}">{{ $nomCategorie }}
                                            </option>
                                            <option value="">Selection du catégorie du tissu</option>
                                        @endif
                                        @foreach ($categorie as $categories)
                                            <option value="{{ $categories->id }}/{{ $categories->categorie }}">
                                                {{ $categories->categorie }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclassematierepremiere">
                                    <optgroup label="Classe du tissu">
                                        @if ($idClasse == null)
                                            <option value="">Selection de la classe du tissu</option>
                                        @else
                                            <option value="{{ $idClasse }}/{{ $nomClasse }}">
                                                {{ $nomClasse }}</option>
                                            <option value="">Selection de la classe du tissu</option>
                                        @endif
                                        @foreach ($classeMatiere as $classeMatieres)
                                            <option value="{{ $classeMatieres->id }}/{{ $classeMatieres->classe }}">
                                                {{ $classeMatieres->classe }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idutilisationwms">
                                    <optgroup label="Utilisation">
                                        @if ($idUtilisationWMS == null)
                                            <option value="">Sélection de l'utilisation</option>
                                        @else
                                            <option value="{{ $idUtilisationWMS }}/{{ $nomUtilisationWMS }}">
                                                {{ $nomUtilisationWMS }}
                                            </option>
                                            <option value="">Sélection de l'utilisation</option>
                                        @endif
                                        @foreach ($utilisation as $utilisations)
                                            <option value="{{ $utilisations->id }}/{{ $utilisations->utilisation }}">
                                                {{ $utilisations->utilisation }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclient">
                                    <optgroup label="Client">
                                        @if ($idClient == null)
                                            <option value="">Sélection du client</option>
                                        @else
                                            <option value="{{ $idClient }}/{{ $nomClient }}">
                                                {{ $nomClient }}</option>
                                            <option value="">Sélection du client</option>
                                        @endif
                                        @foreach ($client as $clients)
                                            <option value="{{ $clients->id }}/{{ $clients->nomtier }}">
                                                {{ $clients->nomtier }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idfournisseur">
                                    <optgroup label="Fournisseur">
                                        @if ($idFournisseur == null)
                                            <option value="">Sélection du fournisseur</option>
                                        @else
                                            <option value="{{ $idFournisseur }}/{{ $nomFournisseur }}">
                                                {{ $nomFournisseur }}</option>
                                            <option value="">Sélection du fournisseur</option>
                                        @endif
                                        @foreach ($fournisseur as $fournisseurs)
                                            <option value="{{ $fournisseurs->id }}/{{ $fournisseurs->nomtier }}">
                                                {{ $fournisseurs->nomtier }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="debut">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="fin">
                            </div>
                        </div> --}}
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="text" class="form-control" name="recherche" placeholder="Recherche"
                                    value="{{ $recherche }}">
                            </div>
                        </div>

                        <div class="col-1">
                            <button class="btn btn-success">Filtrer</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                    aria-describedby="dataTable_info">
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('erreur') }}</div>
                    @endif
                    @if ($errors->has('error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <table class="table my-0" id="dataTable" style="width: 100%;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Classe Pareto</th>
                                <th>Cellule</th>
                                <th>Désignation</th>
                                <th>Réference</th>
                                <th>Couleur</th>
                                <th>Composition</th>
                                <th>Classe</th>
                                <th>Catégorie</th>
                                <th>Utilisation</th>
                                <th>Somme Entrée</th>
                                <th>Somme Sortie</th>
                                <th>Retour Manque</th>
                                <th>Retour Surplus</th>
                                <th>Retour Inventaire</th>
                                <th>Fournisseur</th>
                                <th>Client </th>
                                <th>Modèle </th>
                                <th>Quantité en stock</th>
                                <th>Prix Unitaire</th>
                                {{-- <th>Commentaire</th> --}}
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="color: black">
                            @foreach ($stock as $stocks)
                                <tr>
                                    <th>{{ $stocks->pareto_classification }}</th>
                                    <th>{{ $stocks->designation_cellue }}</th>
                                    <th>{{ $stocks->designation }}</th>
                                    <th>{{ $stocks->reference }}</th>
                                    <th>{{ $stocks->couleur }}</th>
                                    <th>{{ $stocks->composition }}</th>
                                    <th>{{ $stocks->classe }}</th>
                                    <th>{{ $stocks->categorie }}</th>
                                    <th>{{ $stocks->utilisation }}</th>
                                    <th>{{ rtrim(rtrim(number_format($stocks->sommeqterecu ?? 0, 3, ',', ' '), '0'), ',') }}
                                    </th>
                                    <th>{{ rtrim(rtrim(number_format($stocks->sommeqtesortie ?? 0, 3, ',', ' '), '0'), ',') }}
                                    </th>
                                    <th>{{ $stocks->retour_manque }}</th>
                                    <th>{{ $stocks->retour_surplus }}</th>
                                    <th>{{ $stocks->retour_inventaire }}</th>
                                    <th>{{ $stocks->fournisseur }}</th>
                                    <th>{{ $stocks->nomtier }}</th>
                                    <th>{{ $stocks->modele }}</th>
                                    <th>{{ rtrim(rtrim(number_format($stocks->qtestock ?? 0, 3, ',', ' '), '0'), ',') }}
                                    </th>
                                    <th>{{ rtrim(rtrim($stocks->prixunitaire, '0'), ',') }}
                                    </th>
                                    {{-- <th style="width: 300px;">{{ $stocks->commentaire }}</th> --}}
                               <td>

                                        <div class="dropdown" style="position: relative;">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Voir +
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                style="max-height: 200px; overflow-y: auto; position: absolute; z-index: 1050; width: 300px; border: 1px solid #ccc; background: #fff;">
                                                {{-- <div class="col-12 mt-2 mb-2 w-100">
                                                    <a class="btn btn-primary w-100"
                                                        href="{{ route('WMS.rajout-tscf-tissu', ['idStock' => $stocks->id]) }}">
                                                        Faire un rajout de stock
                                                    </a>
                                                </div> --}}
                                                <div class="col-12 mt-2 mb-2 w-100">
                                                    <a class="btn btn-primary w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#rajout-modal-{{ $stocks->id }}"
                                                        href="#">
                                                        Faire un rajout de stock
                                                    </a>
                                                </div>
                                                <div class="col-12 mt-2 mb-2 w-100">
                                                    <a class="btn btn-primary w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#modificatiion-cellule-{{ $stocks->id }}"
                                                        href="#">
                                                        Modification cellule
                                                    </a>
                                                </div>
                                                <div class="col-12 mt-2 mb-2 ">
                                                    <a class="btn btn-secondary btn-lg w-100" href="#">
                                                        Detail du tissu
                                                    </a>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <a class="btn w-100"
                                                        href="{{ route('WMS.tissu-sortie', ['idStock' => $stocks->id]) }}"
                                                        style="background-color: #f57c00; color: white;"
                                                        title="Sortie de Stock">
                                                        Faire une sortie
                                                    </a>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-info w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#reservation-modal-{{ $stocks->id }}">
                                                        Faire une réservation
                                                    </button>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-danger w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#obsolete-modal-{{ $stocks->id }}"
                                                        title="Rendre obsolète">
                                                        Rendre le tissu obsolète
                                                    </button>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-danger w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#retour-manque-modal-{{ $stocks->id }}">
                                                        Faire un retour manque
                                                    </button>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-danger w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#retour-surplus-modal-{{ $stocks->id }}">
                                                        Faire un retour surplus
                                                    </button>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-danger w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#retour-inventaire-modal-{{ $stocks->id }}">
                                                        Faire un retour inventaire
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>


                                </tr>
                                {{-- ! Modal retour manque! --}}
                                <x-w-m-s.retour-modal-stock-tissu idstock="{{ $stocks->id }}" typeretour="manque"
                                    idtyperetour="2" />
                                {{-- ! Modal retour surplus! --}}
                                <x-w-m-s.retour-modal-stock-tissu idstock="{{ $stocks->id }}" typeretour="surplus"
                                    idtyperetour="3" />
                                {{-- ! Modal retour Inventaire! --}}
                                <x-w-m-s.retour-modal-stock-tissu idstock="{{ $stocks->id }}"
                                    typeretour="inventaire" idtyperetour="4" />

                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Rajout modal
                                --}}
                                <div class="modal" id="rajout-modal-{{ $stocks->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Rajout</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info" style="color: black">Rajout au
                                                    stock</p>
                                                <form id="modification-form"
                                                    action="{{ route('WMS.insert-rajout') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    {{-- TODO: Remplir la value --}}
                                                    <input type="hidden" name="idstocktissu"
                                                        value="{{ $stocks->id }}">
                                                    <input type="hidden" name="typeSortie" value="0">
                                                    <div class="mb-3"><label class="form-label">Date entrée</label>
                                                        <input class="form-control" type="date" name="dateentree">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Date
                                                            facturation</label>
                                                        <input class="form-control" type="date"
                                                            name="datefacturation">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Numéro de
                                                            facture</label>
                                                        <input class="form-control" type="text"
                                                            name="numerofacture">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Num BC</label>
                                                        <input class="form-control" type="text" name="numerobc"
                                                            {{ isset($stocks->numbc) ? 'value=' . $stocks->numbc : '' }}>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Num BL</label>
                                                        <input class="form-control" type="text" name="numerobl">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Modèle</label>
                                                        <input class="form-control" type="text" name="modele">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité
                                                            commander</label>
                                                        <input class="form-control" type="text" name="qtecommande"
                                                            {{ isset($stocks->qtecommande) ? 'value=' . $stocks->qtecommande : '' }}>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité
                                                            reçue</label>
                                                        <input class="form-control" type="text" name="qterecu">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Nb Lot</label>
                                                        <input class="form-control" type="text" name="nblot">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Nb rouleau</label>
                                                        <input class="form-control" type="text" name="nbrouleau">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Grammage</label>
                                                        <input class="form-control" type="text" name="grammage">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Laize</label>
                                                        <input class="form-control" type="text" name="laize">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Taux reçu</label>
                                                        <input class="form-control" type="text" name="tauxecart">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Prix
                                                            Unitaire</label>
                                                        <input class="form-control" type="text"
                                                            name="prixunitaire">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Unité
                                                            monetaire</label>
                                                        <select class="form-control" name="idunitemonetaire">
                                                            <option value="">Selectionner la devise</option>
                                                            @foreach ($uniteMonetaire as $uniteMonetaires)
                                                                <option value="{{ $uniteMonetaires->id }}"
                                                                    {{ isset($stocks->idunitemonetaire) && $stocks->idunitemonetaire == $uniteMonetaires->id ? 'selected' : '' }}>
                                                                    {{ $uniteMonetaires->unite }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{--  <div class="mb-3">
                                                        <label class="form-label">Cellule</label>
                                                        <select name="cellule[]" class="form-control"
                                                            multiple>
                                                            @for ($r = 0; $r < count($rackCellule); $r++)
                                                                <option value="{{ $rackCellule[$r]->idcellule }}">{{ $rackCellule[$r]->designation }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>  --}}

                                                    <div class="mb-3">
                                                        <label class="form-label">Cellule</label>
                                                        <select name="cellule[]" class="form-control cellule-select"
                                                            multiple>
                                                            @for ($r = 0; $r < count($rackCellule); $r++)
                                                                <option value="{{ $rackCellule[$r]->idcellule }}">
                                                                    {{ $rackCellule[$r]->designation }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="mb-3"><label class="form-label">Commentaire</label>
                                                        <textarea class="form-control requete" name="commentaire" rows="4" cols="50"></textarea>
                                                    </div>
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Annuler</button>
                                                    <button class="btn btn-primary" type="submit">Rajouter</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--  modification cellule  --}}
                                <div class="modal" id="modificatiion-cellule-{{ $stocks->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Modification</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info" style="color: black">Modification cellule</p>
                                                <form id="modification-form"
                                                    action="{{ route('WMS.modificationCellule') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    {{-- TODO: Remplir la value --}}
                                                    <input type="hidden" name="idstocktissu"
                                                        value="{{ $stocks->id }}">
                                                    <input type="hidden" name="typeSortie" value="0">

                                                    <div class="mb-3">
                                                        <label class="form-label">Cellule</label>
                                                        <select name="cellule[]" class="form-control cellule-select"
                                                            multiple>
                                                            @for ($r = 0; $r < count($rackCellule); $r++)
                                                                <option value="{{ $rackCellule[$r]->idcellule }}">
                                                                    {{ $rackCellule[$r]->designation }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Annuler</button>
                                                    <button class="btn btn-warning" type="submit">Modifier</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Reservation modal
                                --}}
                                <div class="modal" id="reservation-modal-{{ $stocks->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Reservation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Réserver le tissu</p>
                                                <form id="modification-form"
                                                    action="{{ route('WMS.ajout-reservation-tissu') }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3"><label class="form-label">Date de
                                                            réservation</label>
                                                        <input class="form-control" type="date"
                                                            name="datereservation" value="{{ date('Y-m-d') }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité à
                                                            réserver</label>
                                                        <input class="form-control" type="text" name="qtereserve"
                                                            placeholder="Quantité">
                                                    </div>

                                                    <input type="hidden" name="idstocktissu"
                                                        value="{{ $stocks->id }}">

                                                    <div class="mb-3"><label class="form-label">Commentaire</label>
                                                        <textarea class="form-control" type="text" name="commentaire" value=""></textarea>
                                                    </div>
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Annuler</button>
                                                    <button class="btn btn-success" type="submit">Réserver</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Obsolete modal
                                --}}
                                <div class="modal" id="obsolete-modal-{{ $stocks->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Obsolète</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-danger" style="color: black">Rendre
                                                    le tissu obsolète ?
                                                </p>
                                                <form id="modification-form"
                                                    action="{{ route('WMS.obsolete-tissu', ['idstocktissu' => $stocks->id]) }}"
                                                    method="get" enctype="multipart/form-data">
                                                    @csrf
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Annuler</button>
                                                    <button class="btn btn-success" type="submit">Transferer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{--  <div class="pagination justify-content-center">
                    @if ($stock->lastPage() > 1)
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item {{ $stock->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $stock->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo; Previous</span>
                                </a>
                            </li>

                            <!-- Pagination Links -->
                            @php
                                $currentPage = $stock->currentPage();
                                $lastPage = $stock->lastPage();
                                $visiblePages = min($lastPage, 4); // Maximum number of visible pages
                                $startPage = max(1, $currentPage - floor($visiblePages / 2));
                                $endPage = min($lastPage, $startPage + $visiblePages - 1);
                            @endphp

                            @if ($startPage > 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            @for ($i = $startPage; $i <= $endPage; $i++)
                                <li class="page-item {{ $stock->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $stock->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($endPage < $lastPage)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <!-- Next Page Link -->
                            <li
                                class="page-item {{ $stock->currentPage() == $stock->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $stock->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">Next &raquo;</span>
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>  --}}
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        // Select the dropdown menu
        var dropdownMenu = $('.dropdown-menu');

        // Calculate the total height of the content
        var contentHeight = 0;
        dropdownMenu.find('.col-12').each(function() {
            contentHeight += $(this).outerHeight(true);
        });

        // Set the max-height of the dropdown menu
        dropdownMenu.css('max-height', contentHeight);
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.cellule-select').select2({
            placeholder: "Sélectionnez une ou plusieurs cellules", // Texte d'indication
            allowClear: true, // Permet de supprimer toutes les sélections
            width: '100%' // Pour s'assurer que le champ occupe tout l'espace disponible
        });
    });
</script>

<script>
    // Initialize Select2 for all elements with the "cellule-select" class
    $('#cellules').select2({
        placeholder: 'Selection de cellule',
        ajax: {
            url: '{{ route('WMS.autocomplete-cellule-tissu') }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term // search term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.idcellule, // the id of the cellule
                            text: item.designation // the designation to display in the dropdown
                        };
                    })
                };
            },
            cache: true
        }
    });
</script>

@include('CRM.footer')
