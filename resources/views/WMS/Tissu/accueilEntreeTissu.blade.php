@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <a href="#" class="card h-100 shadow border-left-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Total Entrée
                                    </span></div>
                                <div class="text-dark font-weight-light mb-0">
                                    <span
                                        style="font-weight: bold;font-size: 20px">{{ number_format($totalEntree ?? 0, 3, ',', ' ') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <a href="#" class="card h-100 shadow border-left-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Fréquence
                                        moyenne entrée
                                    </span></div>
                                <div class="text-dark font-weight-bold h5 mb-0">
                                    <span
                                        style="font-size: 20px">{{ number_format($frequenceEntree ?? 0, 3, ',', ' ') }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
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
            <div class="col-md-6 col-xl-3 mb-4">
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
                    Entrée {{ $familleTissu->famille_tissus }}
                </h4>

                <div class="d-flex gap-2">
                    <form action="{{ route('WMS.tissu-entree', ['idfamilletissus' => $familleTissu->id]) }}" method="get">
                        @csrf
                        <button class="btn btn-secondary mr-1">Ajout nouvelle entrée</button>
                    </form>

                    <form action="{{ route('WMS.exportCSVEntreeTissu') }}" method="GET">
                        <input type="hidden" name="idcategorietissu" value="{{ $idCategorie }}/{{ $nomCategorie }}">
                        <input type="hidden" value="{{ $familleTissu->id }}" name="idfamilletissu">
                        <input type="hidden" value="{{ $idClasse }}/{{ $nomClasse }}" name="idclassematierepremiere">
                        <input type="hidden" value="{{ $idUtilisationWMS }}/{{ $nomUtilisationWMS }}" name="idutilisationwms">
                        <input type="hidden" value="{{ $idClient }}/{{ $nomClient }}" name="idclient">
                        <input type="hidden" value="{{ $idFournisseur }}/{{ $nomFournisseur }}" name="idfournisseur">
                        <input type="hidden" value="{{ $debut }}" name="debut">
                        <input type="hidden" value="{{ $fin }}" name="fin">
                        <input type="hidden" value="{{ $recherche }}" name="recherche">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-file-csv"></i> Exporter CSV
                        </button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                {{-- TODO: Corriger l'action {{ route('WMS.filtre-entree-tissu') }} --}}
                <form class="mb-4" action="{{ route('WMS.filtre-tissu-entree') }}" method="get" autocomplete="off">
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
                                            <option value="{{ $idCategorie }}/{{ $nomCategorie }}">{{ $nomCategorie }}</option>
                                            <option value="">Selection du catégorie du tissu</option>
                                        @endif
                                        @foreach ($categorie as $categories)
                                            <option value="{{ $categories->id }}/{{ $categories->categorie }}">{{ $categories->categorie }}</option>
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
                                            <option value="{{ $idClasse }}/{{ $nomClasse }}">{{ $nomClasse }}</option>
                                            <option value="">Selection de la classe du tissu</option>
                                        @endif
                                        @foreach ($classeMatiere as $classeMatieres)
                                            <option value="{{ $classeMatieres->id }}/{{ $classeMatieres->classe }}">{{ $classeMatieres->classe }}
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
                                            <option value="{{ $idUtilisationWMS }}/{{ $nomUtilisationWMS }}">{{ $nomUtilisationWMS }}
                                            </option>
                                            <option value="">Sélection de l'utilisation</option>
                                        @endif
                                        @foreach ($utilisation as $utilisations)
                                            <option value="{{ $utilisations->id }}/{{ $utilisations->utilisation }}">{{ $utilisations->utilisation }}
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
                                            <option value="{{ $idClient }}/{{ $nomClient }}">{{ $nomClient }}</option>
                                            <option value="">Sélection du client</option>
                                        @endif
                                        @foreach ($client as $clients)
                                            <option value="{{ $clients->id }}/{{ $clients->nomtier }}">{{ $clients->nomtier }}
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
                                            <option value="{{ $idFournisseur }}/{{ $nomFournisseur }}">{{ $nomFournisseur }}</option>
                                            <option value="">Sélection du fournisseur</option>
                                        @endif
                                        @foreach ($fournisseur as $fournisseurs)
                                            <option value="{{ $fournisseurs->id }}/{{ $fournisseurs->nomtier }}">{{ $fournisseurs->nomtier }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="debut" value="{{ $debut }}">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="fin" value="{{ $fin }}">
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
                                <th>Reference tissu</th>
                                <th>Composition</th>
                                <th>Couleur</th>
                                <th>Catégorie</th>
                                <th>Classe</th>
                                <th>Utilisation</th>
                                <th>Saison</th>
                                <th>Fournisseur</th>
                                <th>Client</th>
                                <th style="width: 5px">Modèle</th>
                                <th>Laize</th>
                                <th>Date d'entrée</th>
                                <th>Date de facturation</th>
                                <th>Numéro BC</th>
                                <th>Numéro BL</th>
                                <th>Numéro Facture</th>
                                <th>Quantité commander</th>
                                <th>Quantité reçu</th>
                                <th>Reste à recevoir</th>
                                <th>Unité commande</th>
                                <th>Taux reçu</th>
                                <th>Grammage</th>
                                <th>Nombre de rouleau</th>
                                <th>Nombre de lot</th>
                                <th>Prix unitaire</th>
                                <th>Unité monétaire</th>
                                <th>Parité</th>
                                <th>Fret</th>
                                <th>Commentaire</th>
                                <th>Quantité retourner au fournisseur</th>
                                <th>Modification</th>
                                <th>Retour fournisseur</th>
                                {{-- <th>Suppression</th> --}}
                            </tr>
                        </thead>
                        <tbody style="color: black">
                            @foreach ($historyEntree as $historyEntrees)
                                <tr>
                                    <th>{{ $historyEntrees->des_tissu }}</th>
                                    <th>{{ $historyEntrees->reftissu }}</th>
                                    <th>{{ $historyEntrees->composition }}</th>
                                    <th>{{ $historyEntrees->couleur }}</th>
                                    <th>{{ $historyEntrees->categorie }}</th>
                                    <th>{{ $historyEntrees->classe }}</th>
                                    <th>{{ $historyEntrees->utilisation }}</th>
                                    <th>{{ $historyEntrees->saison }}</th>
                                    <th>{{ $historyEntrees->fournisseur }}</th>
                                    <th>{{ $historyEntrees->client }}</th>
                                    <th style="width: 5px">{{ $historyEntrees->modele }}</th>
                                    <th>{{ $historyEntrees->laize }}</th>
                                    <th>{{ $historyEntrees->dateentree }}</th>
                                    <th>{{ $historyEntrees->datefacturation }}</th>
                                    <th>{{ $historyEntrees->numerobc }}</th>
                                    <th>{{ $historyEntrees->numerobl }}</th>
                                    <th>{{ $historyEntrees->numerofacture }}</th>
                                    <th>{{ $historyEntrees->qtecommande }}</th>
                                    <th>{{ $historyEntrees->qterecu }}</th>
                                    @if ($historyEntrees->resterecevoir > 0)
                                        <th>{{ $historyEntrees->resterecevoir }}</th>
                                    @else
                                        <th>0</th>
                                    @endif
                                    {{-- <th>{{ $historyEntrees->resterecevoir < 0 ? 0 : $historyEntrees->resterecevoir }} --}}
                                    </th>
                                    <th>{{ $historyEntrees->unite_mesure }}</th>
                                    <th>{{ $historyEntrees->tauxecart . '%' }}</th>
                                    <th>{{ $historyEntrees->grammage ? $historyEntrees->grammage : 'non referencé' }}
                                    </th>
                                    <th>{{ $historyEntrees->nbrouleau }}</th>
                                    <th>{{ $historyEntrees->nblot }}</th>
                                    <th>{{ $historyEntrees->prixunitaire }}</th>
                                    <th>{{ $historyEntrees->unite_monetaire }}</th>
                                    <th>{{ $historyEntrees->valeur }}</th>
                                    <th>{{ $historyEntrees->fret }}</th>
                                    <th>{{ $historyEntrees->commentaire }}</th>
                                    <th>{{ $historyEntrees->retour_fournisseur}}</th>
                                    <td>
                                        <a class="btn" href="#" data-toggle="modal"
                                            data-target="#modification-modal-{{ $historyEntrees->id }}"
                                            style="border-radius: 50%; background-color: #281acb; color: white;">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn" href="#" data-toggle="modal"
                                            data-target="#retour-modal-{{ $historyEntrees->id }}"
                                            style="border-radius: 50%; background-color: #f57c00; color: white;">
                                            <i class="fa fa-share"></i>
                                        </a>
                                    </td>
                                    {{-- <td>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal" style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td> --}}

                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Retour modal
                                --}}
                                <div class="modal" id="retour-modal-{{ $historyEntrees->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Retour</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info" style="color: black">Faire un
                                                    retour fournisseur</p>
                                                <form id="modification-form"
                                                    action="{{ route('WMS.retour-tissu-wms-type') }}" method="get"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="identreetissu"
                                                        value="{{ $historyEntrees->id }}">
                                                    <input type="hidden" name="date_retour"
                                                        value="{{ date('Y-m-d') }}">
                                                    <input type="hidden" name="idtyperetour" value="1">
                                                    <div class="mb-3"><label class="form-label">Quantité</label>
                                                        <input class="form-control" type="text" name="quantite">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Commentaire</label>
                                                        <textarea class="form-control" type="text" name="commentaire"></textarea>
                                                    </div>
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal"
                                                        onclick="resetFormValues()">Annuler</button>
                                                    <button class="btn btn-danger" type="submit">Retourner</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Modification modal
                                --}}
                                <div class="modal" id="modification-modal-{{ $historyEntrees->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Modification</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Modification de l'entrée</p>
                                                <form id="modification-form"
                                                    action="{{ route('WMS.modif-entree-tissu') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="identreetissu"
                                                        value="{{ $historyEntrees->id }}">
                                                    <input type="hidden" name="idstocktissu"
                                                        value="{{ $historyEntrees->idstocktissu }}">
                                                    <div class="mb-3"><label class="form-label">Date de
                                                            facturation</label>
                                                        <input class="form-control" type="text"
                                                            name="datefacturation"
                                                            value="{{ $historyEntrees->datefacturation }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Numéro BL</label>
                                                        <input class="form-control" type="text" name="numbl"
                                                            value="{{ $historyEntrees->numerobl }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Numéro BC</label>
                                                        <input class="form-control" type="text" name="numbc"
                                                            value="{{ $historyEntrees->numerobc }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Modèle</label>
                                                        <input class="form-control" type="text" name="modele"
                                                            value="{{ $historyEntrees->modele }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Qte
                                                            commander</label>
                                                        <input class="form-control" type="text" name="qtecommande"
                                                            value="{{ $historyEntrees->qtecommande }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Taux reçu</label>
                                                        <input class="form-control" type="text" name="tauxecart" value="{{ $historyEntrees->tauxecart }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Commentaire</label>
                                                        <textarea class="form-control" type="text" name="commentaire">{{ $historyEntrees->commentaire }}</textarea>
                                                    </div>
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal"
                                                        onclick="resetFormValues()">Annuler</button>
                                                    <button class="btn btn-primary" type="submit">Modifier</button>
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
                                <div class="modal" id="suppression-modal">
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
                {{--  <div class="pagination justify-content-center">
                    @if ($historyEntree->lastPage() > 1)
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item {{ $historyEntree->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $historyEntree->previousPageUrl() }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo; Previous</span>
                                </a>
                            </li>

                            <!-- Pagination Links -->
                            @php
                                $currentPage = $historyEntree->currentPage();
                                $lastPage = $historyEntree->lastPage();
                                $visiblePages = min($lastPage, 4); // Maximum number of visible pages
                                $startPage = max(1, $currentPage - floor($visiblePages / 2));
                                $endPage = min($lastPage, $startPage + $visiblePages - 1);
                            @endphp

                            @if ($startPage > 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            @for ($i = $startPage; $i <= $endPage; $i++)
                                <li class="page-item {{ $historyEntree->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $historyEntree->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($endPage < $lastPage)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <!-- Next Page Link -->
                            <li
                                class="page-item {{ $historyEntree->currentPage() == $historyEntree->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $historyEntree->nextPageUrl() }}" aria-label="Next">
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
@include('CRM.footer')
