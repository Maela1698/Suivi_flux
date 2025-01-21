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
                <p class="text-primary m-0 font-weight-bold">TEST NUANCE INSPECTION</p>
            </div>
            <div class="card-body">
                @include('WMS.QUALITE.Tissu.info-tissu')
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('QUALITE.test-nuance') }}" method="post"
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
                                        <label class="col-form-label">Date d'execution</label>
                                    </div>
                                    <div class="col-12">
                                        @error('datepreparation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="dateexecution"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->dateexecution : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Endroit tissu</label>
                                    </div>
                                    <div class="col-12">
                                        @error('endroit')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="endroit">
                                            <optgroup label="Inspecteur">
                                                <option value="">Sélection de l'envers</option>
                                                <option value="INTERIEUR ROULEAUX"
                                                    {{ isset($inspectionData) && $inspectionData->endroit == 'INTERIEUR ROULEAUX' ? 'selected' : '' }}>
                                                    INTERIEUR ROULEAUX</option>
                                                <option value="EXTERIEUR ROULEAUX"
                                                    {{ isset($inspectionData) && $inspectionData->endroit == 'EXTERIEUR ROULEAUX' ? 'selected' : '' }}>
                                                    EXTERIEUR ROULEAUX</option>
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
                                            <option value="1"
                                                {{ isset($inspectionData) && $inspectionData->passed == 1 ? 'selected' : '' }}>
                                                Not passed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Envers tissu</label>
                                    </div>
                                    <div class="col-12">
                                        @error('envers')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="envers">
                                            <optgroup label="Inspecteur">
                                                <option value="">Sélection de l'envers</option>
                                                <option value="INTERIEUR ROULEAUX"
                                                    {{ isset($inspectionData) && $inspectionData->envers == 'INTERIEUR ROULEAUX' ? 'selected' : '' }}>
                                                    INTERIEUR ROULEAUX</option>
                                                <option value="EXTERIEUR ROULEAUX"
                                                    {{ isset($inspectionData) && $inspectionData->envers == 'EXTERIEUR ROULEAUX' ? 'selected' : '' }}>
                                                    EXTERIEUR ROULEAUX</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Nuance</label>
                                    </div>
                                    <div class="col-12">
                                        @error('nuance')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="nuance">
                                            <optgroup label="Inspecteur">
                                                <option value="">Sélection de la nuance</option>
                                                <option value="0"
                                                    {{ isset($inspectionData) && $inspectionData->nuance == 0 ? 'selected' : '' }}>
                                                    Sans</option>
                                                <option value="1"
                                                    {{ isset($inspectionData) && $inspectionData->nuance == 1 ? 'selected' : '' }}>
                                                    Avec</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Commentaire</label>
                                    </div>
                                    <div class="col-12">
                                        @error('laizeutilisable')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <textarea type="text" class="form-control" name="commentaire"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->commentaire : '' }}> </textarea>
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
                            <thead class="thead-dark">
                                <tr>
                                    <th>PHOTO</th>
                                    <th>Image</th>
                                    <th>ROULEAU N</th>
                                    <th>LOT</th>
                                    <th>LAIZE</th>
                                    <th>METRAGE REEL</th>
                                    <th>REFERENCE</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rouleau as $rouleaus)
                                    <form action="{{ route('QUALITE.test-nuance-rouleau') }}" method="post"
                                        enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                        <input type="hidden" name="idqualiterouleautissu"
                                            value="{{ $rouleaus->id }}">
                                        <tr style="color: black">
                                            <td><input type="file" class="form-control" name="image"
                                                    accept="image/*" capture="camera"></td>
                                            <td><a href="data:image/jpeg;base64,{{ $rouleaus->image }}">
                                                    <img src="data:image/jpeg;base64,{{ $rouleaus->image }}"
                                                        style="width: 50px; height: 50px;" />
                                                </a></td>
                                            <td></td>
                                            <td>{{ $rouleaus->lot }}</td>
                                            <td>{{ $rouleaus->laize }}</td>
                                            <td>{{ $rouleaus->metrage }}</td>
                                            <td>{{ $rouleaus->reference }}</td>
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
