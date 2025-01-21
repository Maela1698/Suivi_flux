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
                <p class="text-primary m-0 font-weight-bold">Fiche d'inspection accessoire</p>
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
                        <div class="static-field">{{ $historyEntree->numbc }}</div>
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
                        <div class="static-field">{{ $historyEntree->nom }}</div>
                    </div>

                    <!-- MODELE -->
                    <div class="col-md-6">
                        <div class="static-label">MODELE</div>
                        <div class="static-field">{{ $historyEntree->modele }}</div>
                    </div>

                    <!-- DESIGNATION -->
                    <div class="col-md-6">
                        <div class="static-label">DESIGNATION</div>
                        <div class="static-field">{{ $historyEntree->designation }}</div>
                    </div>

                    <!-- QTE COMMANDE -->
                    <div class="col-md-6">
                        <div class="static-label">QTE COMMANDE</div>
                        <div class="static-field">{{ $historyEntree->qtecommande }}</div>
                    </div>

                    <!-- RECEIVED QTY -->
                    <div class="col-md-6">
                        <div class="static-label">RECEIVED QTY</div>
                        <div class="static-field">{{ $historyEntree->qteentree }}</div>
                    </div>

                    <!-- REFERENCE -->
                    <div class="col-md-6">
                        <div class="static-label">REFERENCE</div>
                        <div class="static-field">{{ $historyEntree->reference }}</div>
                    </div>

                    <!-- COULEUR -->
                    <div class="col-md-6">
                        <div class="static-label">COULEUR</div>
                        <div class="static-field">{{ $historyEntree->couleur }}</div>
                    </div>
                </div>
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('QUALITE.test-inspection-accessoire') }}" method="post"
                        enctype="multipart/form-data" autocomplete="off" style="color: black">
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
                        <input type="hidden" name="identreewms" value="{{ $historyEntree->id }}">
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Date debut d'inspection</label>
                                    </div>
                                    @error('datedebut')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <input type="date" class="form-control" name="datedebut"
                                        {{ isset($inspectionData) ? 'value=' . $inspectionData->datedebut : '' }}>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">date fin</label>
                                    </div>
                                    <div class="col-12">
                                        @error('datefin')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="datefin"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->datefin : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Image</label>
                                    </div>
                                    <div class="col-12">
                                        @error('lab_dip')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="file" class="form-control" name="image" accept="image/*"
                                            capture="camera">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Pack total</label>
                                    </div>
                                    <div class="col-12">
                                        @error('packtotal')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="packtotal"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->packtotal : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">AQL Used</label>
                                    </div>
                                    <div class="col-12">
                                        @error('aql')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="aql">
                                            <option value="">Selection AQL</option>
                                            <option value="1.5"
                                                {{ isset($inspectionData) && $inspectionData->aql == 1.5 ? 'selected' : '' }}>
                                                1.5 %</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Pourcentage inspecter</label>
                                    </div>
                                    <div class="col-12">
                                        @error('pourcentageinspect')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input class="form-control" name="pourcentageinspect" type="text"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->pourcentageinspect : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">Pack total selectionner</label>
                                    </div>
                                    <div class="col-12">
                                        @error('packtotalselect')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="packtotalselect" class="form-control"
                                            class="form-control"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->packtotalselect : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="table-responsive table mt-2" id="dataTable" role="grid"
                            aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Code</th>
                                        <th>Check list</th>
                                        <th>Defect quantity</th>
                                        <th>Gravite</th>
                                        <th>Remarque</th>
                                    </tr>
                                </thead>
                                <tbody style="color: black">
                                    @foreach ($codification as $index => $codifications)
                                        @php
                                            // Find the matching defect if it exists
                                            $matchingDefaut =
                                                $defaut->firstWhere('idcodificationaccessoire', $codifications->id) ??
                                                null;
                                        @endphp
                                        <tr>
                                            <input class="gravitedefault" type="hidden" name="gravitedefault"
                                                value="{{ $codifications->gravitedefault }}">
                                            <input type="hidden"
                                                name="fields[{{ $index }}][idcodificationaccessoire]"
                                                value="{{ $codifications->id }}">
                                            <td>{{ $codifications->code }}</td>
                                            <td>{{ $codifications->checklist }}</td>
                                            <td><input type="text" class="form-control defectquantity"
                                                    name="fields[{{ $index }}][defectquantity]"
                                                    placeholder="Defect Quantity" oninput="calculateTotals()"
                                                    value="{{ $matchingDefaut ? $matchingDefaut->defectquantity : '' }}">
                                            </td>
                                            <td><input class="form-control" type="text"
                                                    name="fields[{{ $index }}][gravitedefault]"
                                                    value="{{ $codifications->gravitedefault }}" readonly></td>
                                            <td>
                                                {{-- <textarea class="form-control" name="fields[{{ $index }}][remarque]" id="" cols="30"
                                            rows="10"></textarea> --}}
                                                <input class="form-control" type="text"
                                                    name="fields[{{ $index }}][remarque]"
                                                    placeholder="Remarque"
                                                    value="{{ $matchingDefaut ? $matchingDefaut->remarque : '' }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group row">

                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">Total defaut</label>
                                    </div>
                                    <div class="col-12">
                                        @error('totaldefect')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" id="totaldefect" name="totaldefect"
                                            class="form-control"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->totaldefect : '' }}
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Defaut Majeur</label>
                                    </div>
                                    <div class="col-12">
                                        @error('majordefect')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" id="majordefect" name="majordefect"
                                            class="form-control"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->majordefect : '' }}
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Defaut Mineur</label>
                                    </div>
                                    <div class="col-12">
                                        @error('minordefect')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" id="minordefect" name="minordefect"
                                            class="form-control"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->minordefect : '' }}
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">% Defaut</label>
                                    </div>
                                    <div class="col-12">
                                        @error('pourcentagedefect')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" id="pourcentagedefect" name="pourcentagedefect"
                                            class="form-control"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->pourcentagedefect : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Corrective action</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idwmsqualitycorrectiveaction')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idwmsqualitycorrectiveaction">
                                            <option value="">Selection de l'action</option>
                                            @foreach ($correctiveAction as $correctiveActions)
                                                <option value="{{ $correctiveActions->id }}"
                                                    {{ isset($inspectionData) && $inspectionData->idwmsqualitycorrectiveaction == $correctiveActions->id ? 'selected' : '' }}>
                                                    {{ $correctiveActions->action }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
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
                                                Failed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Observation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('observation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <textarea class="form-control requete" name="observation" rows="4" cols="50"
                                            {{ isset($inspectionData) ? 'value=' . $inspectionData->observation : '' }}></textarea>
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
                </div>
            </div>
        </div>
    </div>
</div>
@include('CRM.footer')
<script>
    function calculateTotals() {
        const qteEntree = {{ $historyEntree->qteentree }};
        let totalDefectQuantity = 0;
        let majorDefect = 0;
        let minorDefect = 0;

        // Select all defectquantity inputs and gravitedefault hidden fields
        const defectInputs = document.querySelectorAll('.defectquantity');
        const graviteDefaults = document.querySelectorAll('.gravitedefault');

        defectInputs.forEach((input, index) => {
            const defectQuantity = parseFloat(input.value);
            const graviteDefault = graviteDefaults[index].value
                .trim(); // Get the string value (e.g., "MA" or "MI")

            if (!isNaN(defectQuantity)) {
                totalDefectQuantity += defectQuantity;

                // Check gravitedefault to categorize defects
                if (graviteDefault === "MA") {
                    majorDefect += defectQuantity; // Major defect
                } else if (graviteDefault === "MI") {
                    minorDefect += defectQuantity; // Minor defect
                }
            }
        });
        const pourcentageDefect = qteEntree > 0 ? (totalDefectQuantity / qteEntree) * 100 : 0;
        // Update total, major, and minor defects
        document.getElementById('totaldefect').value = totalDefectQuantity;
        document.getElementById('majordefect').value = majorDefect;
        document.getElementById('minordefect').value = minorDefect;
        document.getElementById('pourcentagedefect').value = pourcentageDefect;
    }
</script>
