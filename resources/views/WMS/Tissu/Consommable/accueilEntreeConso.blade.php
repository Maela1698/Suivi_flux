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
            <div class="col-md-6 col-xl-4 mb-4">
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
        </div>
        <div class="card">
            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Historique Entrée Consommable</h4>
                <form action="{{ route('WMS.page-entree-consommable') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <button class="btn btn-secondary">Ajout nouvelle entrée</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <form class="mb-4" action="#" method="get">
                    @csrf
                    <div class="row">
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
                    <table class="table my-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Désignation</th>
                                <th>Reference</th>
                                <th>Couleur</th>
                                <th>Saison</th>
                                <th>Fournisseur</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Date d'entrée</th>
                                <th>Date de facturation</th>
                                <th>Numéro BC</th>
                                <th>Numéro BL</th>
                                <th>Quantité commander</th>
                                <th>Quantité reçu</th>
                                <th>Reste à recevoir</th>
                                <th>Unité commande</th>
                                <th>Prix unitaire</th>
                                <th>Unité monétaire</th>
                                <th>Parité</th>
                                <th>Fret</th>
                                <th>Commentaire</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entreeConsommable as $entreeConsommables)
                                <tr style="color: black">
                                    <th>{{ $entreeConsommables->designation }}</th>
                                    <th>{{ $entreeConsommables->reference }}</th>
                                    <th>{{ $entreeConsommables->couleur }}</th>
                                    <th>{{ $entreeConsommables->saison }}</th>
                                    <th>{{ $entreeConsommables->fournisseur }}</th>
                                    <th>{{ $entreeConsommables->client }}</th>
                                    <th>{{ $entreeConsommables->modele }}</th>
                                    <th>{{ $entreeConsommables->dateentree }}</th>
                                    <th>{{ $entreeConsommables->datefacturation }}</th>
                                    <th>{{ $entreeConsommables->numbc }}</th>
                                    <th>{{ $entreeConsommables->numbl }}</th>
                                    <th>{{ $entreeConsommables->qtecommande }}</th>
                                    <th>{{ $entreeConsommables->qterecu }}</th>
                                    <th>{{ $entreeConsommables->resterecevoir }}</th>
                                    <th>{{ $entreeConsommables->unite_mesure }}</th>
                                    <th>{{ $entreeConsommables->prixunitaire }}</th>
                                    <th>{{ $entreeConsommables->unite_monetaire }}</th>
                                    <th>{{ $entreeConsommables->valeur }}</th>
                                    <th>{{ $entreeConsommables->fret == null ? 'Non reference' : $entreeConsommables->fret }}
                                    </th>
                                    <th>{{ $entreeConsommables->commentaire }}</th>
                                    <td>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modification-modal" style="border-radius: 50%">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal" style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Modification modal
                                --}}
                                <div class="modal" id="modification-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Modification</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Modification de la rack</p>
                                                <form id="modification-form" action="#" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3"><label class="form-label">Section</label>
                                                        <select class="form-control" name="idsectionwms">
                                                            <optgroup label="Section">
                                                                <option value="#">Tissu</option>
                                                                <option value="#">Tissu obsolète</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Catégorie du
                                                            tissu</label>
                                                        <select class="form-control" name="idcategorietissu">
                                                            <optgroup label="Catégorie de tissu">
                                                                <option value="#">BIO</option>
                                                                <option value="#">NON-BIO</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Désignation</label>
                                                        <input class="form-control" type="text" name="designation"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Largeur</label>
                                                        <input class="form-control" type="number" name="largeur"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Longueur</label>
                                                        <input class="form-control" type="number" name="longueur"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Hauteur</label>
                                                        <input class="form-control" type="number" name="hauteur"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Commentaire</label>
                                                        <textarea class="form-control" type="text" name="commentaire" value=""></textarea>
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
            </div>
        </div>
    </div>

</div>
@include('CRM.footer')
