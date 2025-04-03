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
            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Stock {{ $typeWMS->type }}</h4>
            </div>
            <div class="card-body">
                <form class="mb-4" action="{{ route('WMS.filtre-stock-wms') }}" method="get">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="idwms_type" value="{{ $typeWMS->id }}">
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idfamillewms">
                                    <optgroup label="Famille">
                                        @if ($idFamillewms == null)
                                            <option value="">Sélection de la famille</option>
                                        @else
                                            <option value="{{ $idFamillewms }}/{{ $nomFamille }}">{{ $nomFamille }}
                                            </option>
                                            <option value="">Sélection de la famille</option>
                                        @endif
                                        @foreach ($familleWMS as $familleWMSs)
                                            <option value="{{ $familleWMSs->id }}/{{ $familleWMSs->nom }}">
                                                {{ $familleWMSs->nom }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclassematierepremiere">
                                    <optgroup label="Classe">
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
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="text" class="form-control" name="recherche" placeholder="Recherche" value="{{ $recherche }}">
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
                    <table class="table my-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Désignation</th>
                                <th>Cellule</th>
                                {{-- TODO: Corrige faute ortho --}}
                                <th>Reference</th>
                                <th>Couleur</th>
                                <th>Classe</th>
                                <th>Somme Entrée</th>
                                <th>Somme Sortie</th>
                                <th>Retour Manque</th>
                                <th>Retour Surplus</th>
                                <th>Retour Inventaire</th>
                                <th>Fournisseur</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Quantité en stock</th>
                                <th>Prix Unitaire</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockWMS as $WMSStock)
                                <tr style="color: black">
                                    <th>{{ $WMSStock->designation }}/{{ $WMSStock->id }}</th>
                                    <th>{{ $WMSStock->designations }}</th>
                                    <th>{{ $WMSStock->reference }}</th>
                                    <th>{{ $WMSStock->couleur }}</th>
                                    <th>{{ $WMSStock->classe }}</th>
                                    <th>{{ $WMSStock->sommeqterecu }}</th>
                                    <th>{{ $WMSStock->sommeqtesortie ? $WMSStock->sommeqtesortie : 0 }}</th>
                                    <th>{{ $WMSStock->retour_manque }}</th>
                                    <th>{{ $WMSStock->retour_surplus }}</th>
                                    <th>{{ $WMSStock->retour_inventaire }}</th>
                                    <th>{{ $WMSStock->fournisseur }}</th>
                                    <th>{{ $WMSStock->nomtier }}</th>
                                    <th>{{ $WMSStock->modele }}</th>
                                    <th>{{ $WMSStock->qtestock }}</th>
                                    <th>{{ $WMSStock->prixunitaire }}</th>
                                    <td>
                                        <div class="dropdown" style="position: relative;">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Voir +
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                style="max-height: 200px; overflow-y: auto; position: absolute; z-index: 1050; width: 300px; border: 1px solid #ccc; background: #fff;">
                                                <div class="col-12 mt-2 mb-2 w-100">
                                                    <a class="btn btn-primary w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#rajout-modal-{{ $WMSStock->id }}"
                                                        href="#">
                                                        Faire un rajout de stock
                                                    </a>
                                                </div>
                                                <div class="col-12 mt-2 mb-2 ">
                                                    <a class="btn btn-secondary btn-lg w-100" href="#">
                                                        Detail du tissu
                                                    </a>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <a class="btn w-100" data-toggle="modal"
                                                        data-target="#sortie-modal-{{ $WMSStock->id }}"
                                                        href="#"
                                                        style="background-color: #f57c00; color: white;"
                                                        title="Sortie de Stock">
                                                        Faire une sortie
                                                    </a>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-info w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#reservation-modal-{{ $WMSStock->id }}">
                                                        Faire une réservation
                                                    </button>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-danger w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#obsolete-modal-{{ $WMSStock->id }}"
                                                        title="Rendre obsolète">
                                                        Rendre obsolète
                                                    </button>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-danger w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#retour-manque-modal-{{ $WMSStock->id }}">
                                                        Faire un retour manque
                                                    </button>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-danger w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#retour-surplus-modal-{{ $WMSStock->id }}">
                                                        Faire un retour surplus
                                                    </button>
                                                </div>
                                                <div class="col-12 mt-2 mb-2">
                                                    <button class="btn btn-danger w-100" type="button"
                                                        data-toggle="modal"
                                                        data-target="#retour-inventaire-modal-{{ $WMSStock->id }}">
                                                        Faire un retour inventaire
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                {{-- ! Modal retour manque! --}}
                                <x-w-m-s.retour-modal-stock-wms idstock="{{ $WMSStock->id }}" typeretour="manque"
                                    idtyperetour="2" />
                                {{-- ! Modal retour surplus! --}}
                                <x-w-m-s.retour-modal-stock-wms idstock="{{ $WMSStock->id }}" typeretour="surplus"
                                    idtyperetour="3" />
                                {{-- ! Modal retour Inventaire! --}}
                                <x-w-m-s.retour-modal-stock-wms idstock="{{ $WMSStock->id }}" typeretour="inventaire"
                                    idtyperetour="4" />
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Reservation modal
                                --}}
                                <div class="modal" id="reservation-modal-{{ $WMSStock->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Reservation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Réserver l'accessoire</p>
                                                <form id="modification-form"
                                                    action="{{ route('WMS.ajout-reservation-wms') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3"><label class="form-label">Date de
                                                            réservation</label>
                                                        <input class="form-control" type="date"
                                                            name="datereservation" value="{{ date('Y-m-d') }}"
                                                            readonly>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité à
                                                            réserver</label>
                                                        <input class="form-control" type="text" name="qtereserve"
                                                            placeholder="Quantité">
                                                    </div>

                                                    <input type="hidden" name="idstockwms"
                                                        value="{{ $WMSStock->id }}">

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
                                <div class="modal" id="obsolete-modal-{{ $WMSStock->id }}">
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
                                                    action="{{ route('WMS.rendre-obsolete-accessoire', ['idstockaccessoire' => $WMSStock->id]) }}"
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
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Rajout modal
                                --}}
                                <div class="modal" id="rajout-modal-{{ $WMSStock->id }}">
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
                                                    action="{{ route('WMS.rajout-stock-wms') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    {{-- TODO: Remplir la value --}}
                                                    <input type="hidden" name="idstockwms"
                                                        value="{{ $WMSStock->id }}">
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
                                                        <input class="form-control" type="text" name="numbc"
                                                            {{ isset($WMSStock->numbc) ? 'value=' . $WMSStock->numbc : '' }}>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Num BL</label>
                                                        <input class="form-control" type="text" name="numbl">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité
                                                            commander</label>
                                                        <input class="form-control" type="text" name="qtecommande"
                                                            {{ isset($WMSStock->qtecommande) ? 'value=' . $WMSStock->qtecommande : '' }}>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité
                                                            reçue</label>
                                                        <input class="form-control" type="text" name="qteentree">
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
                                                                    {{ isset($WMSStock->idunitemonetaire) && $WMSStock->idunitemonetaire == $uniteMonetaires->id ? 'selected' : '' }}>
                                                                    {{ $uniteMonetaires->unite }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Cellule</label>
                                                        <select name="cellule[]" id="cellule" multiple
                                                            class="form-control"></select>
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
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Sortie modal
                                --}}
                                <div class="modal" id="sortie-modal-{{ $WMSStock->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Sortie</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info" style="color: black">Sortie de
                                                    stock</p>
                                                <form id="modification-form"
                                                    action="{{ route('WMS.sortie-stock-wms') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    {{-- TODO: Remplir la value --}}
                                                    <input type="hidden" name="typeSortie" value="1">
                                                    <input type="hidden" name="idstockwms"
                                                        value="{{ $WMSStock->id }}">
                                                    <div class="mb-3"><label class="form-label">Date de
                                                            sortie</label>
                                                        <input class="form-control" type="date" name="datesortie" value="{{ date('Y-m-d')}}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Num BCI</label>
                                                        <input class="form-control" type="text" name="numbci">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Destinataire</label>
                                                        <input class="form-control" type="text"
                                                            name="destinataire">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Receveur</label>
                                                        <input class="form-control" type="text" name="receveur">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité à
                                                            sortir</label>
                                                        <input class="form-control" type="text" name="qtesortie">
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
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Suppression
                                --}}
                                <div class="modal" id="suppression-modal-{{ $WMSStock->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Suppression</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="#">
                                                    @csrf
                                                    <p class="alert alert-danger" style="color: black">
                                                        Voulez-vous
                                                        vraiment
                                                        supprimer cette donnée ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Annuler</button>
                                                <button class="btn btn-danger" type="submit">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination justify-content-center">
                    @if ($stockWMS->lastPage() > 1)
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item {{ $stockWMS->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $stockWMS->previousPageUrl() }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo; Previous</span>
                                </a>
                            </li>

                            <!-- Pagination Links -->
                            @php
                                $currentPage = $stockWMS->currentPage();
                                $lastPage = $stockWMS->lastPage();
                                $visiblePages = min($lastPage, 4); // Maximum number of visible pages
                                $startPage = max(1, $currentPage - floor($visiblePages / 2));
                                $endPage = min($lastPage, $startPage + $visiblePages - 1);
                            @endphp

                            @if ($startPage > 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            @for ($i = $startPage; $i <= $endPage; $i++)
                                <li class="page-item {{ $stockWMS->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $stockWMS->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($endPage < $lastPage)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <!-- Next Page Link -->
                            <li
                                class="page-item {{ $stockWMS->currentPage() == $stockWMS->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $stockWMS->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">Next &raquo;</span>
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@include('CRM.footer')
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
<script>
    // Initialize Select2 for all elements with the "cellule-select" class
    $('#cellule').select2({
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
