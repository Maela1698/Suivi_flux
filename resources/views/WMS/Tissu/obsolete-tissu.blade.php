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
                <h4 class="text-primary m -0 font-weight-bold">STOCK des tissus obsolète</h4>
                <form action="{{ route('WMS.page-tissu-obsolete-sortie') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <button class="btn btn-secondary">Liste sortie obsolete</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <form action="{{ route('WMS.filtre-stock-tissu-obsolete') }}" method="get" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idcategorietissu">
                                    <optgroup label="Catégorie du tissu">
                                        <option value="">Selection du catégorie du tissu</option>
                                        @foreach ($categorie as $categories)
                                            <option value="{{ $categories->id }}">{{ $categories->categorie }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclassematierepremiere">
                                    <optgroup label="Classe du tissu">
                                        <option value="">Sélection de la classe</option>
                                        @foreach ($classeMatiere as $classeMatieres)
                                            <option value="{{ $classeMatieres->id }}">{{ $classeMatieres->classe }}
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
                                        <option value="">Sélection de l'utilisation</option>
                                        @foreach ($utilisation as $utilisations)
                                            <option value="{{ $utilisations->id }}">{{ $utilisations->utilisation }}
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
                                        <option value="">Sélection du client</option>
                                        @foreach ($client as $clients)
                                            <option value="{{ $clients->id }}">{{ $clients->nomtier }}
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
                                        <option value="">Sélection du fournisseur</option>
                                        @foreach ($fournisseur as $fournisseurs)
                                            <option value="{{ $fournisseurs->id }}">{{ $fournisseurs->nomtier }}
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
                                <input type="text" class="form-control" name="recherche" placeholder="Recherche">
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
                    <table class="table my-0" id="dataTable" style="table-layout: fixed; width: 100%;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Désignation</th>
                                <th>Réference</th>
                                <th>Couleur</th>
                                <th>Composition</th>
                                <th>Classe</th>
                                <th>Catégorie</th>
                                <th>Utilisation</th>
                                <th>Somme Entrée</th>
                                <th>Somme Sortie</th>
                                <th>Fournisseur</th>
                                <th>Quantité en stock</th>
                                <th>Prix Unitaire</th>
                                <th>Commentaire</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="color: black">
                            @foreach ($stock as $stocks)
                                <tr>
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
                                    <th>{{ $stocks->fournisseur }}</th>
                                    <th>{{ rtrim(rtrim(number_format($stocks->qtestock ?? 0, 3, ',', ' '), '0'), ',') }}
                                    </th>
                                    <th>{{ rtrim(rtrim(number_format($stocks->prixunitaire ?? 0, 3, ',', ' '), '0'), ',') }}
                                    </th>
                                    <th style="width: 300px;">{{ $stocks->commentaire }}</th>
                                    <td>
                                        <div style="display: flex; gap: 10px;">
                                            {{-- TODO: Page de detail du stock --}}
                                            {{-- <a class="btn btn-secondary" href="#" style="border-radius: 50%">
                                            <i class="fa fa-info-circle"></i>
                                            </a> --}}
                                            <div>
                                                <a class="btn"
                                                    href="{{ route('WMS.tissu-sortie', ['idStock' => $stocks->id]) }}"
                                                    style="border-radius: 50%; background-color: #f57c00; color: white;"
                                                    title="Sortie de Stock">
                                                    <i class="fa fa-share"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <button class="btn btn-info" type="button" data-toggle="modal"
                                                    data-target="#reservation-modal-{{ $stocks->id }}"
                                                    style="border-radius: 50%;">
                                                    <i class="fa fa-bookmark"></i>
                                                </button>
                                            </div>
                                            <div>
                                                <button class="btn btn-danger" type="button" data-toggle="modal"
                                                    data-target="#suppression-modal-{{ $stocks->id }}"
                                                    style="border-radius: 50%;">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>


                                </tr>
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
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Suppression
                                --}}
                                <div class="modal" id="suppression-modal-{{ $stocks->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Suppression</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('supprimer', ['modelName' => 'StockTissu', 'id' => $stocks->id]) }}">
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
            </div>
        </div>
    </div>

</div>
@include('CRM.footer')
