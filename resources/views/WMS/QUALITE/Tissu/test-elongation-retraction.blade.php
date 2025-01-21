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
                <p class="text-primary m-0 font-weight-bold">TEST ELONGATION/RETRACTION INSPECTION</p>
            </div>
            <div class="card-body">
                @include('WMS.QUALITE.Tissu.info-tissu')
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('QUALITE.test-retraction') }}" method="post"
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
                                        <label class="col-form-label">Date de preparation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('datepreparation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="datepreparation"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->datepreparation : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Date évaluation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('dateevaluation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="dateevaluation"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->dateevaluation : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Laize Utilisable</label>
                                    </div>
                                    <div class="col-12">
                                        @error('laizeutilisable')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="laizeutilisable">
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
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Type de lavage</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idtypelavage')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idtypelavage">
                                            <optgroup label="Lavage">
                                                <option value="">Sélection du type de lavage</option>
                                                @foreach ($typeLavage as $typeLavages)
                                                    <option value="{{ $typeLavages->id }}"
                                                        {{ isset($inspectionData) && $inspectionData->idtypelavage == $typeLavages->id ? 'selected' : '' }}>
                                                        {{ $typeLavages->type }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">Temps de relaxation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('tempsrelaxation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="tempsrelaxation">
                                            <optgroup label="Temps">
                                                <option value="">Sélection du temps de relaxation</option>
                                                <option value="24"
                                                    {{ isset($inspectionData) && $inspectionData->tempsrelaxation == 24 ? 'selected' : '' }}>
                                                    24h</option>
                                                <option
                                                    value="48"{{ isset($inspectionData) && $inspectionData->tempsrelaxation == 48 ? 'selected' : '' }}>
                                                    48h</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">Observation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('observation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="observation" class="form-control"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->observation : '' }}>
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
                                            <option
                                                value="0"{{ isset($inspectionData) && $inspectionData->idtypelavage == 0 ? 'selected' : '' }}>
                                                Passed</option>
                                            <option
                                                value="1"{{ isset($inspectionData) && $inspectionData->idtypelavage == 1 ? 'selected' : '' }}>
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
                                    <th>QTE</th>
                                    <th>LOT</th>
                                    <th>Elongation % Longueur</th>
                                    <th>Elongation % Laize</th>
                                    <th>Retrait % Longueur</th>
                                    <th>Retrait % Laize</th>
                                    <th>Retrait Ecart ANG</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rouleau as $rouleaus)
                                    <tr>
                                        <td>{{ $rouleaus->reference }}</td>
                                        <td>{{ $rouleaus->metrage }}</td>
                                        <td>{{ $rouleaus->lot }}</td>
                                        <form action="{{ route('QUALITE.test-retraction-rouleau') }}" method="post"
                                            enctype="multipart/form-data" autocomplete="off">
                                            @csrf
                                            <input type="hidden" name="idqualiterouleautissu"
                                                value="{{ $rouleaus->id }}">
                                            <td><input type="text" name="longueurelong" class="form-control"
                                                    value="{{ $rouleaus->longueurelong }}"></td>
                                            <td><input type="text"name="laizeelong" class="form-control"
                                                    value="{{ $rouleaus->laizeelong }}"></td>
                                            <td><input type="text"name="longueurretrait" class="form-control"
                                                    value="{{ $rouleaus->longueurretrait }}"></td>
                                            <td><input type="text"name="laizeretrait" class="form-control"
                                                    value="{{ $rouleaus->laizeretrait }}"></td>
                                            <td><input type="text"name="ecartretrait"
                                                    class="form-control"value="{{ $rouleaus->ecartretrait }}"></td>
                                            <td><button type="submit" class="btn btn-success">Enregistrer</button>
                                            </td>
                                        </form>
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
