@include('CRM.header')
@include('CRM.sidebar')
<style>
    .static-field {
        padding: 8px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        color: #313030;
    }

    .static-label {
        font-weight: bold;
        font-size: 14px;
        color: black;
    }
</style>
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="row">
            <div class="col-md-6 col-xl-4 mb-4">
                <a href="{{ route('QUALITE.page-test-conformite-tissu', ['identreetissu' => $identreetissu]) }}"
                    class="card h-100 shadow border-left-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col">
                                <div class="text-uppercase text-primary font-weight-bold text-xs mb-1">
                                    <span>Test de conformité</span>
                                </div>
                                <div class="text-dark font-weight-light mb-0">

                                    {{-- <span
                                        style="font-weight: bold; font-size: 20px;color: {{ $conformite->passed == 0 ? 'green' : ($conformite->passed == 1 ? 'red' : 'blue') }}; background-color: {{ $conformite->passed == 0 ? '#d4edda' : ($conformite->passed == 1 ? '#f8d7da' : 'blue') }};padding: 5px;border-radius: 5px;">
                                        {{ $conformite->passed === null ? 'En attente' : ($conformite->passed == 0 ? 'Passed' : 'Failed') }}
                                    </span> --}}
                                </div>

                            </div>
                        </div>
                    </div>

                </a>
            </div>
            <div class="col-md-6 col-xl-4 mb-4">
                <a href="{{ route('QUALITE.page-test-fabric-inspection', ['identreetissu' => $identreetissu]) }}"
                    class="card h-100 shadow border-left-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Fabric
                                        inspection
                                    </span></div>
                                <div class="text-dark font-weight-light mb-0">
                                    <span></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-4 mb-4">
                <a href="{{ route('QUALITE.page-test-elongation-retraction', ['identreetissu' => $identreetissu]) }}"
                    class="card h-100 shadow border-left-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>Elongation /
                                        Retraction test
                                    </span></div>
                                <div class="text-dark font-weight-light mb-0">
                                    <span></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-4 mb-4">
                <a href="{{ route('QUALITE.page-test-nuance', ['identreetissu' => $identreetissu]) }}"
                    class="card h-100 shadow border-left-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span>Shade
                                        test</span></div>
                                <div class="text-dark font-weight-light mb-0">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-4 mb-4 ">
                <a href="{{ route('QUALITE.page-test-disgorging', ['identreetissu' => $identreetissu]) }}"
                    class="card h-100 shadow border-left-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-exception font-weight-bold text-xs mb-1">
                                    <span>Discorging
                                        test</span>
                                </div>
                                <div class="text-dark font-weight-light mb-0">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Inspection Tissu</h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- DATE D'ENTREE -->
                    <div class="col-md-6">
                        <div class="static-label">DATE D'ENTREE</div>
                        <div class="static-field">{{ $historyEntree->dateentree }}</div>
                    </div>

                    <!-- N° BC -->
                    <div class="col-md-6">
                        <div class="static-label">N° BC</div>
                        <div class="static-field">{{ $historyEntree->numerobc }}</div>
                    </div>

                    <!-- CLIENT -->
                    <div class="col-md-6">
                        <div class="static-label">CLIENT</div>
                        <div class="static-field">{{ $historyEntree->client }}</div>
                    </div>

                    <!-- CLASSE -->
                    <div class="col-md-6">
                        <div class="static-label">CLASSE</div>
                        <div class="static-field">{{ $historyEntree->classe }}</div>
                    </div>

                    <!-- FOURNISSEUR -->
                    <div class="col-md-6">
                        <div class="static-label">FOURNISSEUR</div>
                        <div class="static-field">{{ $historyEntree->fournisseur }}</div>
                    </div>

                    <!-- FAMILLE -->
                    <div class="col-md-6">
                        <div class="static-label">FAMILLE</div>
                        <div class="static-field">{{ $historyEntree->famille_tissus }}</div>
                    </div>

                    <!-- MODELE -->
                    <div class="col-md-6">
                        <div class="static-label">MODELE</div>
                        <div class="static-field">{{ $historyEntree->modele }}</div>
                    </div>

                    <!-- DESIGNATION -->
                    <div class="col-md-6">
                        <div class="static-label">DESIGNATION</div>
                        <div class="static-field">{{ $historyEntree->des_tissu }}</div>
                    </div>

                    <!-- QTE COMMANDE -->
                    <div class="col-md-6">
                        <div class="static-label">QTE COMMANDE</div>
                        <div class="static-field">{{ $historyEntree->qtecommande }}</div>
                    </div>

                    <!-- RECEIVED QTY -->
                    <div class="col-md-6">
                        <div class="static-label">RECEIVED QTY</div>
                        <div class="static-field">{{ $historyEntree->qterecu }}</div>
                    </div>

                    <!-- REFERENCE -->
                    <div class="col-md-6">
                        <div class="static-label">REFERENCE</div>
                        <div class="static-field">{{ $historyEntree->reftissu }}</div>
                    </div>

                    <!-- COULEUR -->
                    <div class="col-md-6">
                        <div class="static-label">COULEUR</div>
                        <div class="static-field">{{ $historyEntree->couleur }}</div>
                    </div>
                </div>
                <div class="form-validation mt-4">
                    <form action="{{ route('enregistrer', ['modelName' => 'QualiteRouleauTissu']) }}"method="post"
                        enctype="multipart/form-data">
                        @csrf
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
                        <input type="hidden" name="identreetissu" value="{{ $identreetissu }}">
                        <div class="row">
                            <div class="col-md-3 col-lg-2 mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="reference" placeholder="Reference">
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-2 mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="lot" placeholder="Lot">
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-2 mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="laize" placeholder="Laize">
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-2 mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="metrage" placeholder="Métrage">
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-2 mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="poids" placeholder="Poids">
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-2 mb-3">
                                <div class="input-group">
                                    <button class="btn btn-success">Ajout Rouleau</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                    aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>REFERENCE</th>
                                <th>LOT</th>
                                <th>LAIZE</th>
                                <th>METRAGE</th>
                                <th>POIDS</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rouleau as $rouleaus)
                                <tr style="color: black">
                                    <td>{{ $rouleaus->reference }}</td>
                                    <td>{{ $rouleaus->lot }}</td>
                                    <td>{{ $rouleaus->laize }}</td>
                                    <td>{{ $rouleaus->metrage }}</td>
                                    <td>{{ $rouleaus->poids }}</td>
                                    <td>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modification-modal-{{ $rouleaus->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal-{{ $rouleaus->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>

                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Modification modal
                                --}}
                                <div class="modal" id="modification-modal-{{ $rouleaus->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Modification</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Modification des rouleau</p>
                                                <form id="modification-form"
                                                    action="{{ route('modifier', ['modelName' => 'QualiteRouleauTissu', 'id' => $rouleaus->id]) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3"><label class="form-label">Reference</label>
                                                        <input class="form-control" type="text" name="reference"
                                                            value="{{ $rouleaus->reference }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Lot</label>
                                                        <input class="form-control" type="text" name="lot"
                                                            value="{{ $rouleaus->lot }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Laize</label>
                                                        <input class="form-control" type="text" name="laize"
                                                            value="{{ $rouleaus->laize }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Métrage</label>
                                                        <input class="form-control" type="text" name="metrage"
                                                            value="{{ $rouleaus->metrage }}">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Poids</label>
                                                        <input class="form-control" type="text" name="poids"
                                                            value="{{ $rouleaus->poids }}">
                                                    </div>
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal"
                                                        onclick="resetFormValues({{ $rouleaus->id }})">Annuler</button>
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
                                <div class="modal" id="suppression-modal-{{ $rouleaus->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Suppression</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('supprimer', ['modelName' => 'QualiteRouleauTissu', 'id' => $rouleaus->id]) }}">
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
