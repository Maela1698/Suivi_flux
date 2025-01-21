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
                <p class="text-primary m-0 font-weight-bold">TEST DISGORGING</p>
            </div>
            <div class="card-body">
                @include('WMS.QUALITE.Tissu.info-tissu')
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('QUALITE.test-disgorging') }}" method="post"
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
                                        <label class="col-form-label">Date de debut controle</label>
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
                                        <label class="col-form-label">Date d'evaluation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('endroit')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="dateevaluation"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->dateevaluation : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Passed</label>
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
                                            <option value="1"
                                                {{ isset($inspectionData) && $inspectionData->passed == 1 ? 'selected' : '' }}>
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
                                    <th>PHOTO</th>
                                    <th>Image</th>
                                    <th>TYPE DE FROTTEMENT</th>
                                    <th>ECHELLE DE GRIS</th>
                                    <th>DUREE</th>
                                    <th>VALIDATION TEST</th>
                                    <th>REMARQUES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rouleau as $rouleaus)
                                    <form action="{{ route('QUALITE.test-disgorging-rouleau') }}" method="post"
                                        enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                        <input type="hidden" name="idqualiterouleautissu" value="{{ $rouleaus->id }}">
                                        <tr>
                                            <td>
                                                <input type="file" class="form-control" name="image"
                                                    accept="image/*" capture="camera">
                                            </td>
                                            <td>
                                                <a href="data:image/jpeg;base64,{{ $rouleaus->image }}">
                                                    <img src="data:image/jpeg;base64,{{ $rouleaus->image }}"
                                                        style="width: 50px; height: 50px;" />
                                                </a>
                                            </td>
                                            <td>
                                                <select class="form-control" name="typefrottement">
                                                    <optgroup label="Frottement">
                                                        <option value="">Selectionner</option>
                                                        <option value="FROTTEMENT A SEC"
                                                            {{ isset($rouleaus->typefrottement) && $rouleaus->typefrottement == 'FROTTEMENT A SEC' ? 'selected' : '' }}>
                                                            FROTTEMENT A SEC</option>
                                                        <option value="FROTTEMENT MOUILLE"
                                                            {{ isset($rouleaus->typefrottement) && $rouleaus->typefrottement == 'FROTTEMENT MOUILLE' ? 'selected' : '' }}>
                                                            FROTTEMENT MOUILLE</option>
                                                    </optgroup>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="echellegris"
                                                    value="{{ $rouleaus->echellegris }}"></td>
                                            <td><input type="text" class="form-control" name="duree"
                                                    value="{{ $rouleaus->duree }}"></td>
                                            <td>
                                                <select class="form-control" name="validationtest">
                                                    <optgroup label="Validation">
                                                        <option value="">Selectionner</option>
                                                        <option value="0"
                                                            {{ isset($rouleaus->typefrottement) && $rouleaus->validationtest == 0 ? 'selected' : '' }}>
                                                            Avec disgorging</option>
                                                        <option value="1"
                                                            {{ isset($rouleaus->typefrottement) && $rouleaus->validationtest == 1 ? 'selected' : '' }}>
                                                            Sans disgorging</option>
                                                    </optgroup>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="remarque"
                                                    value="{{ $rouleaus->remarque }}"></td>
                                            <td><button type="submit" class="btn btn-success">Enregistrer</button>
                                        </tr>
                                    </form>
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
