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
                                <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Total Sortie
                                    </span></div>
                                <div class="text-dark font-weight-light mb-0">
                                    <span
                                        style="font-weight: bold;font-size: 20px">{{ number_format($totalSortie ?? 0, 0, ',', ' ') }}
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
                                        moyenne sortie
                                    </span></div>
                                <div class="text-dark font-weight-bold h5 mb-0">
                                    <span
                                        style="font-size: 20px">{{ number_format($frequenceSortie ?? 0, 3, ',', ' ') }}</span>
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
            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Liste sortie obsolete</h4>
            </div>
            <div class="card-body">
                <form class="mb-4" action="{{ route('WMS.filtre-sortie-tissu-obsolete') }}" method="get">
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
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="debut">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="fin">
                            </div>
                        </div>
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
                    <table class="table my-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date sortie</th>
                                <th>NumeroBCI</th>
                                <th>Catégorie</th>
                                <th>Référence tissu</th>
                                <th>Désignation</th>
                                <th>Composition</th>
                                <th>Couleur</th>
                                <th>Fournisseur</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Saison</th>
                                <th>Laize</th>
                                <th>Destinataire</th>
                                <th>Receveur</th>
                                <th>Quantité livré</th>
                                <th>Prix unitaire</th>
                                <th>Commentaire</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="color: black">
                            @foreach ($sortie as $sorties)
                                <tr>
                                    <th>{{ $sorties->datesortie }}</th>
                                    <th>{{ $sorties->numbci }}</th>
                                    <th>{{ $sorties->categorie }}</th>
                                    <th>{{ $sorties->reference }}</th>
                                    <th>{{ $sorties->designation }}</th>
                                    <th>{{ $sorties->composition }}</th>
                                    <th>{{ $sorties->couleur }}</th>
                                    <th>{{ $sorties->fournisseur }}</th>
                                    <th>{{ $sorties->client }}</th>
                                    <th>{{ $sorties->modele }}</th>
                                    <th>{{ $sorties->saison }}</th>
                                    <th>{{ $sorties->laize }}</th>
                                    <th>{{ $sorties->destinataire }}</th>
                                    <th>{{ $sorties->receveur }}</th>
                                    <th>{{ $sorties->qtesortie }}</th>
                                    <th>{{ $sorties->prixunitaire }}</th>
                                    <th>{{ $sorties->commentaire }}</th>
                                    <td>
                                        <div style="display: flex">
                                            <div>
                                                <button class="btn btn-danger" type="button" data-toggle="modal"
                                                    data-target="#retour-modal-{{ $sorties->id }}"
                                                    style="border-radius: 50%;margin-right:10px">
                                                    <i class="fa fa-arrow-circle-o-left"></i>
                                                </button>
                                            </div>
                                            {{-- TODO: A FAIRE --}}
                                            {{-- <div>
                                                <a class="btn" href="#"
                                                    style="border-radius: 50%; background-color: #f57c00; color: white;margin-right:10px"
                                                    title="Sortie de Stock">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <button class="btn btn-danger" type="button" data-toggle="modal"
                                                    data-target="#suppression-modal-{{ $sorties->id }}"
                                                    style="border-radius: 50%">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div> --}}
                                        </div>

                                    </td>
                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Retour
                                --}}
                                <div class="modal" id="retour-modal-{{ $sorties->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Retour</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('WMS.retour-tissu') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <p class="alert alert-primary" style="color: black">
                                                        Vous allez faire un retour</p>

                                                    <input type="hidden" name="idsortietissu"
                                                        value="{{ $sorties->id }}">

                                                    <div class="mb-3"><label class="form-label">Date de
                                                            retour</label>
                                                        @error('dateretour')
                                                            <span class="text-danger mb-1">{{ $message }}</span>
                                                        @enderror
                                                        <input class="form-control" type="date" name="dateretour">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité à
                                                            retourner</label>
                                                        @error('qteretour')
                                                            <span class="text-danger mb-1">{{ $message }}</span>
                                                        @enderror
                                                        <input class="form-control" type="text" name="qteretour"
                                                            placeholder="Quantité à retourner">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Annuler</button>
                                                <button class="btn btn-success" type="submit">Retour</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Suppression
                                --}}
                                <div class="modal" id="suppression-modal-{{ $sorties->id }}">
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
                    @if ($sortie->lastPage() > 1)
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item {{ $sortie->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $sortie->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo; Previous</span>
                                </a>
                            </li>

                            <!-- Pagination Links -->
                            @php
                                $currentPage = $sortie->currentPage();
                                $lastPage = $sortie->lastPage();
                                $visiblePages = min($lastPage, 4); // Maximum number of visible pages
                                $startPage = max(1, $currentPage - floor($visiblePages / 2));
                                $endPage = min($lastPage, $startPage + $visiblePages - 1);
                            @endphp

                            @if ($startPage > 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            @for ($i = $startPage; $i <= $endPage; $i++)
                                <li class="page-item {{ $sortie->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $sortie->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($endPage < $lastPage)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            <!-- Next Page Link -->
                            <li
                                class="page-item {{ $sortie->currentPage() == $sortie->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $sortie->nextPageUrl() }}" aria-label="Next">
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
