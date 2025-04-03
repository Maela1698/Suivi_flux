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
                <h4 class="text-primary m -0 font-weight-bold">Stock Consommable</h4>
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
                                {{-- TODO: Corrige faute ortho --}}
                                <th>Reference</th>
                                <th>Couleur</th>
                                <th>Somme Entrée</th>
                                <th>Somme Sortie</th>
                                <th>Fournisseur</th>
                                <th>Quantité en stock</th>
                                <th>Prix Unitaire</th>
                                <th>Commentaire</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockConsommable as $stockConsommables)
                                <tr style="color: black">
                                    <th>{{ $stockConsommables->designation }}</th>
                                    <th>{{ $stockConsommables->reference }}</th>
                                    <th>{{ $stockConsommables->couleur }}</th>
                                    <th>{{ $stockConsommables->sommeqterecu ? $stockConsommables->sommeqterecu : 0 }}
                                    </th>
                                    <th>{{ $stockConsommables->sommeqtesortie ? $stockConsommables->sommeqtesortie : 0 }}
                                    </th>
                                    <th>{{ $stockConsommables->fournisseur }}</th>
                                    <th>{{ $stockConsommables->qtestock }}</th>
                                    <th>{{ $stockConsommables->prixunitaire }}</th>
                                    <th>{{ $stockConsommables->commentaire }}</th>
                                    <td>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#rajout-modal-{{ $stockConsommables->id }}"
                                            style="border-radius: 50%" title="Rajout de stock">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        {{-- TODO: Page de detail du stock --}}
                                        <a class="btn btn-secondary" href="#" style="border-radius: 50%">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        <button class="btn" type="button" data-toggle="modal"
                                            data-target="#sortie-modal-{{ $stockConsommables->id }}"
                                            style="border-radius: 50%; background-color: #f57c00; color: white;"
                                            title="Sortie de stock">
                                            <i class="fa fa-share"></i>
                                        </button>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal-{{ $stockConsommables->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Rajout modal
                                --}}
                                <div class="modal" id="rajout-modal-{{ $stockConsommables->id }}">
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
                                                    <input type="hidden" name="idstockconsommable"
                                                        value="{{ $stockConsommables->id }}">
                                                    <div class="mb-3"><label class="form-label">Date entrée</label>
                                                        <input class="form-control" type="date" name="dateentree">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Date
                                                            facturation</label>
                                                        <input class="form-control" type="date"
                                                            name="datefacturation">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Num BC</label>
                                                        <input class="form-control" type="text" name="numbc"
                                                            {{ isset($stockConsommables->numbc) ? 'value=' . $stockConsommables->numbc : '' }}>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Num BL</label>
                                                        <input class="form-control" type="text" name="numbl">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité
                                                            commander</label>
                                                        <input class="form-control" type="text" name="qtecommande"
                                                            {{ isset($stockConsommables->qtecommande) ? 'value=' . $stockConsommables->qtecommande : '' }}>
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
                                                                    {{ isset($stockConsommables->idunitemonetaire) && $stockConsommables->idunitemonetaire == $uniteMonetaires->id ? 'selected' : '' }}>
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
                                <div class="modal" id="sortie-modal-{{ $stockConsommables->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Sortie</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info" style="color: black">Sortie de
                                                    stock</p>
                                                <form id="modification-form" action="#" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    {{-- TODO: Remplir la value --}}
                                                    <input type="hidden" name="idstock" value="">
                                                    <div class="mb-3"><label class="form-label">Date de
                                                            sortie</label>
                                                        <input class="form-control" type="date" name="dateentree">
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
                                <div class="modal" id="suppression-modal-{{ $stockConsommables->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Suppression</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
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
