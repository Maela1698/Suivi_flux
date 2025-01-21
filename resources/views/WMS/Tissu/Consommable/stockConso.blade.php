@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">

            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Stock </h4>
            </div>
            <div class="card-body">
                <form action="#" method="get" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idcategorietissu">
                                    <optgroup label="Catégorie du tissu">
                                        <option value="#">BIO</option>
                                        <option value="#">NON-BIO</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclassematierepremiere">
                                    <optgroup label="Catégorie de la matière">
                                        <option value="#">Current</option>
                                        <option value="#">En cours</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idutilisationwms">
                                    <optgroup label="Utilisation">
                                        <option value="#">Coupe type</option>
                                        <option value="#">Production</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclient">
                                    <optgroup label="Client">
                                        <option value="#">JACADI</option>
                                        <option value="#">ORCHESTRA</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idfournisseur">
                                    <optgroup label="Fournisseur">
                                        <option value="#">SOMACOU</option>
                                        <option value="#">SOCOTA</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="startEntree"
                                    value="{{ request()->startEntree }}">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="endEntree"
                                    value="{{ request()->endEntree }}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="text" class="form-control" name="startEntree" placeholder="Recherche"
                                    value="{{ request()->startEntree }}">
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
                        <thead>
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stock as $stocks)
                                <tr>
                                    <th>{{ $stocks->designation }}</th>
                                    <th>{{ $stocks->reference }}</th>
                                    <th>{{ $stocks->couleur }}</th>
                                    <th>{{ rtrim(rtrim(number_format($stocks->sommeqterecu ?? 0, 3, ',', ' '), '0'), ',') }}
                                    </th>
                                    <th>{{ rtrim(rtrim(number_format($stocks->sommeqtesortie ?? 0, 3, ',', ' '), '0'), ',') }}
                                    </th>
                                    <th>{{ $stocks->fournisseur }}</th>
                                    <th>{{ rtrim(rtrim(number_format($stocks->qtestock ?? 0, 3, ',', ' '), '0'), ',') }}
                                    </th>
                                    <th>{{ rtrim(rtrim(number_format($stocks->prixunitaire ?? 0, 3, ',', ' '), '0'), ',') }}
                                    </th>
                                    <td>
                                        <a class="btn btn-primary"
                                            href="{{ route('WMS.rajout-tscf-tissu', ['idStock' => $stocks->id]) }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        {{-- TODO: Page de detail du stock --}}
                                        <a class="btn btn-secondary" href="#" style="border-radius: 50%">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        <a class="btn"
                                            href="{{ route('WMS.tissu-sortie', ['idStock' => $stocks->id]) }}"
                                            style="border-radius: 50%; background-color: #f57c00; color: white;"
                                            title="Sortie de Stock">
                                            <i class="fa fa-share"></i>
                                        </a>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal-{{ $stocks->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
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
