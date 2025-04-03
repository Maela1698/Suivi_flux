@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card col-12">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">FABRIC INSPECTION DEFAUTS</p>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    {{-- !route! --}}
                    <form class="form-valide" action="{{ route('QUALITE.test-liste-rouleau-fabric-inspection') }}"
                        method="post" enctype="multipart/form-data" autocomplete="off">
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
                        <input type="hidden" name="idqualiterouleautissu" value="{{ $idqualiterouleautissu }}">
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Laize Utilisable</label>
                                    </div>
                                    <div class="col-12">
                                        @error('laizeutilisable')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="laizeutilisable"
                                            value="{{ isset($rouleaufabrictissu->laizeutilisable) ? $rouleaufabrictissu->laizeutilisable : $rouleau->laize }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Métrage réel</label>
                                    </div>
                                    <div class="col-12">
                                        @error('metragereel')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="metragereel"
                                            value="{{ isset($rouleaufabrictissu->metragereel) ? $rouleaufabrictissu->metragereel : $rouleau->metrage }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Longueur pour inspection</label>
                                    </div>
                                    <div class="col-12">
                                        @error('longueurinspect')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="longueurinspect"
                                            {{ isset($rouleaufabrictissu->longueurinspect) ? 'value=' . $rouleaufabrictissu->longueurinspect : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Poids réel</label>
                                    </div>
                                    <div class="col-12">
                                        @error('poidsreel')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="poidsreel"
                                            value="{{ isset($rouleaufabrictissu->poidsreel) ? $rouleaufabrictissu->poidsreel : $rouleau->poids }}">
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
                                        <textarea class="form-control" cols="10" rows="10" name="observation">{{ isset($rouleaufabrictissu->observation) ? $rouleaufabrictissu->observation : '' }}
                                        </textarea>
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
                                    <th>Photo</th>
                                    <th>Metrage</th>
                                    <th>Defaut</th>
                                    <th>Demerit</th>
                                    {{-- <th></th>
                                    <th></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inspectionDefaut as $inspectionDefauts)
                                    <tr style="color: black">
                                        <td>
                                            <a href="data:image/jpeg;base64,{{ $inspectionDefauts->image }}">
                                                <img src="data:image/jpeg;base64,{{ $inspectionDefauts->image }}"
                                                    style="width: 50px; height: 50px;" onclick="expandImage(this)" />
                                            </a>
                                        </td>
                                        <td>{{ $inspectionDefauts->metrage }}</td>
                                        @foreach ($defectFabricType as $defectFabricTypes)
                                            @if ($inspectionDefauts->iddefectfabrictype == $defectFabricTypes->id)
                                                <td>{{ $defectFabricTypes->typedefaut }}</td>
                                            @endif
                                        @endforeach

                                        <td>{{ $inspectionDefauts->defectpoint . '.' . $inspectionDefauts->demeritpoint . '.' . $inspectionDefauts->sonnette }}
                                        </td>
                                        {{-- <td>
                                            <button class="btn btn-primary" type="button" data-toggle="modal"
                                                data-target="#modification-modal-" style="border-radius: 50%">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" type="button" data-toggle="modal"
                                                data-target="#suppression-modal-" style="border-radius: 50%">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td> --}}

                                    </tr>

                                    {{-- ---------------------------------------------------------------------------- --}}
                                    {{--
                                    * Modification modal
                                --}}
                                    {{-- <div class="modal" id="modification-modal-">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="background-color: white">
                                                <div class="modal-header" style="text-align: left;">
                                                    <h4 class="modal-title" style="color: black">
                                                        Modification</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-center alert alert-info">Modification
                                                    </p>
                                                    <form id="modification-form" action="#" method="post"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                </div>
                                                <div style="text-align: center">
                                                    <div class="modal-footer" style="text-align: center">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-dismiss="modal">Annuler</button>
                                                        <button class="btn btn-primary"
                                                            type="submit">Modifier</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- ---------------------------------------------------------------------------- --}}
                                    {{-- ---------------------------------------------------------------------------- --}}
                                    {{--
                                    * Suppression
                                --}}
                                    {{-- <div class="modal" id="suppression-modal-">
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
                                    </div> --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- !Route! --}}
                    <form class="form-valide" action="{{ route('QUALITE.test-fabric-inspection-defaut') }}"
                        method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <input type="hidden" name="idqualiterouleautissu" value="{{ $idqualiterouleautissu }}">
                        <h4 class="text-center"></h4>
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Photo</label>
                                    </div>
                                    <div class="col-12">
                                        @error('laizeutilisable')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="file" class="form-control" name="image" accept="image/*"
                                            capture="camera">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Métrage</label>
                                    </div>
                                    <div class="col-12">
                                        @error('metrage')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="metrage">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Defaut</label>
                                    </div>
                                    <div class="col-12">
                                        @error('defaut')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="iddefectfabrictype">
                                            <optgroup>
                                                <option value="">Choisir le defaut</option>
                                                @foreach ($defectFabricType as $defectFabricTypes)
                                                    <option value="{{ $defectFabricTypes->id }}">
                                                        {{ $defectFabricTypes->typedefaut }}
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
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Defect Point </label>
                                        </div>
                                        <div class="col-12">
                                            @error('defectpoint')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input type="text" class="form-control" name="defectpoint">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Demerit Point</label>
                                    </div>
                                    <div class="col-12">
                                        @error('demeritpoint')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="demeritpoint">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Sonnette</label>
                                    </div>
                                    <div class="col-12">
                                        @error('sonnette')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="sonnette" id="">
                                            <optgroup>
                                                <option value="AS">AS</option>
                                                <option value="NS">NS</option>
                                            </optgroup>
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
                </div>
            </div>
        </div>
    </div>
</div>
@include('CRM.footer')
<script>
    function expandImage(img) {
        // Get the original dimensions and position
        var originalWidth = img.width;
        var originalHeight = img.height;
        var originalLeft = img.offsetLeft;
        var originalTop = img.offsetTop;

        // Calculate the new dimensions to fill the viewport
        var newWidth = window.innerWidth;
        var newHeight = window.innerHeight;

        // Calculate the new position to center the image
        var newLeft = (window.innerWidth - newWidth) / 2;
        var newTop = (window.innerHeight - newHeight) / 2;

        // Apply the new dimensions and position to the image
        img.style.width = newWidth + "px";
        img.style.height = newHeight + "px";
        img.style.left = newLeft + "px";
        img.style.position = "absolute";
        img.style.top = newTop + "px";
        img.style.zIndex = "999"; // Ensure it's on top
        window.open(img.src, '_blank');
    }
</script>
