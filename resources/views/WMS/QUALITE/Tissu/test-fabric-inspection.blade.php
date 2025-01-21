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
        <div class="card col-12">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">TEST FABRIC INSPECTION</p>
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
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('QUALITE.test-fabric-inspection') }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <h4 class="text-center"></h4>
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
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Date</label>
                                    </div>
                                    <div class="col-12">
                                        @error('datedebut')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="datedebut"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->datedebut : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Tolerance</label>
                                    </div>
                                    <div class="col-12">
                                        @error('tolerance')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="tolerance"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->tolerance : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Inspecteur</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idlisteemploye')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idlisteemploye">
                                            <optgroup label="Inspecteur">
                                                <option value="">Sélection de l'inspecteur</option>
                                                <option value="">Eric</option>
                                                <option value="">Njaka</option>
                                                {{-- @foreach ($listeemployee as $listeemployees)
                                                    <option value="{{ $listeemployees->id }}">
                                                        {{ $listeemployees->nom . ' ' . $listeemployees->prenom }}
                                                    </option>
                                                @endforeach --}}
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Speed Machine</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idspeedmachine')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idspeedmachine">
                                            <optgroup label="Speed Machine">
                                                <option value="">Speed Machine</option>
                                                @foreach ($speedMachine as $speedMachines)
                                                    <option value="{{ $speedMachines->id }}"
                                                        {{ isset($inspectionData) && $inspectionData->idspeedmachine == $speedMachines->id ? 'selected' : '' }}>
                                                        {{ $speedMachines->speed }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Choix</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idchoixqualite')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idchoixqualite">
                                            <optgroup label="Choix">
                                                <option value="">Choix</option>
                                                @foreach ($choix as $choixs)
                                                    <option value="{{ $choixs->id }}"
                                                        {{ isset($inspectionData) && $inspectionData->idchoixqualite == $choixs->id ? 'selected' : '' }}>
                                                        {{ $choixs->choix }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Sens</label>
                                    </div>
                                    <div class="col-12">
                                        @error('sens')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="sens">
                                            <optgroup label="sens">
                                                <option value="">Sens</option>
                                                <option value="0"
                                                    {{ isset($inspectionData) && $inspectionData->sens == 0 ? 'selected' : '' }}>
                                                    Avec</option>
                                                <option value="1"
                                                    {{ isset($inspectionData) && $inspectionData->sens == 1 ? 'selected' : '' }}>
                                                    Sans</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">N Tissu</label>
                                    </div>
                                    <div class="col-12">
                                        @error('numtissu')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="numtissu"
                                            class="form-control"{{ isset($inspectionData) ? 'value=' . $inspectionData->numtissu : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">Tot longueur après inspection</label>
                                    </div>
                                    <div class="col-12">
                                        @error('longueur')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="longueur" class="form-control"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->longueur : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Grammage</label>
                                    </div>
                                    <div class="col-12">
                                        @error('grammage')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="grammage" class="form-control"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->grammage : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Passed ?</label>
                                    </div>
                                    <div class="col-12">
                                        @error('passed')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="passed">
                                            <option value="">Selection</option>
                                            <option value="0"
                                                {{ isset($inspectionData) && $inspectionData->passed == 0 ? 'selected' : '' }}>
                                                Passed</option>
                                            <option
                                                value="1"{{ isset($inspectionData) && $inspectionData->passed == 1 ? 'selected' : '' }}>
                                                Not passed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive table mt-2" id="dataTable" role="grid"
                        aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th>REFERENCE</th>
                                    <th>LOT</th>
                                    <th>LAIZE</th>
                                    <th>METRAGE</th>
                                    <th>POIDS</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rouleau as $rouleaus)
                                    <tr>
                                        <td>{{ $rouleaus->reference }}</td>
                                        <td>{{ $rouleaus->lot }}</td>
                                        <td>{{ $rouleaus->laize }}</td>
                                        <td>{{ $rouleaus->metrage }}</td>
                                        <td>{{ $rouleaus->poids }}</td>
                                        <td>
                                            <a class="btn btn-facebook"
                                                href="{{ route('QUALITE.page-test-fabric-inspection-defaut', ['idqualiterouleautissu' => $rouleaus->id, 'identreetissu' => $identreetissu]) }}">Defaut</a>
                                        </td>
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
@include('CRM.footer')
