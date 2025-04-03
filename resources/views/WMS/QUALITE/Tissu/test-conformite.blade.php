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
                <p class="text-primary m-0 font-weight-bold">TEST DE CONFORMITE</p>
            </div>
            <div class="card-body">
                @include('WMS.QUALITE.Tissu.info-tissu')
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>SWATCH</th>
                                <th>LAB-DIP</th>
                                <th>QTE CDE</th>
                                <th>QTE REÇU PL</th>
                                <th>LAIZE CDE</th>
                                <th>QTE CDE kg</th>
                                <th>QTE REÇUE PL kg</th>
                                <th>LAIZE REÇUE PL</th>
                                <th>Passed</th>
                                <th>Conformité</th>
                                <th>Observation</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conformite as $conformites)
                                <tr style="color: black">
                                    <td>{{ $conformites->datedebut }}</td>
                                    <!-- resources/views/your-view.blade.php -->

                                    <td>
                                        <a href="data:image/jpeg;base64,{{ $conformites->swatch }}">
                                            <img src="data:image/jpeg;base64,{{ $conformites->swatch }}"
                                                style="width: 50px; height: 50px;" />
                                        </a>
                                    </td>

                                    <td>
                                        <a href="data:image/jpeg;base64,{{ $conformites->lab_dip }}">
                                            <img src="data:image/jpeg;base64,{{ $conformites->lab_dip }}"
                                                style="width: 50px; height: 50px;" />
                                        </a>
                                    </td>
                                    <td>{{ $conformites->qtecde }}</td>
                                    <td>{{ $conformites->qterecupl }}</td>
                                    <td>{{ $conformites->laizecde }}</td>
                                    <td>{{ $conformites->qtecdekg }}</td>
                                    <td>{{ $conformites->qterecuplkg }}</td>
                                    <td>{{ $conformites->laizerecuepl }}</td>
                                    <td>{{ $conformites->passed == 0 ? 'Passed' : 'Failed' }}</td>
                                    <td>{{ $conformites->conforme == 0 ? 'Conforme' : 'Non conforme' }}</td>
                                    <td>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modification-modal-{{ $conformites->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal-{{ $conformites->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>

                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Modification modal
                                --}}
                                {{-- <div class="modal" id="modification-modal-{{ $conformites->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="background-color: white">
                                                <div class="modal-header" style="text-align: left;">
                                                    <h4 class="modal-title" style="color: black">
                                                        Modification</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-center alert alert-info">Modification de la parité
                                                    </p>
                                                    <form id="modification-form"
                                                        action="{{ route('modifier', ['modelName' => 'Parite', 'id' => $conformites->id]) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3"><label class="form-label">Date
                                                                parité</label>
                                                            <input class="form-control" type="date"
                                                                name="dateparite" value="{{ $conformites->dateparite }}">
                                                        </div>
                                                        <div class="mb-3"><label class="form-label">Devise
                                                                Euro</label>
                                                            <input class="form-control" type="text"
                                                                name="deviseeuro" value="{{ $conformites->deviseeuro }}">
                                                        </div>
                                                        <div class="mb-3"><label class="form-label">Devise
                                                                Dollar</label>
                                                            <input class="form-control" type="text"
                                                                name="devisedollar"
                                                                value="{{ $conformites->devisedollar }}">
                                                        </div>
                                                        <div class="mb-3"><label class="form-label">Valeur</label>
                                                            <input class="form-control" type="text" name="valeur"
                                                                value="{{ $conformites->valeur }}">
                                                        </div>
                                                </div>
                                                <div style="text-align: center">
                                                    <div class="modal-footer" style="text-align: center">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-dismiss="modal"
                                                            onclick="resetFormValues({{ $conformites->id }})">Annuler</button>
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
                                <div class="modal" id="suppression-modal-{{ $conformites->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Suppression</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('supprimer', ['modelName' => 'TestConformiteTissu', 'id' => $conformites->id]) }}">
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
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('QUALITE.test-conformite') }}" method="post"
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
                                            value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">SWATCH</label>
                                    </div>
                                    <div class="col-12">
                                        @error('swatch')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="file" class="form-control" name="swatch" accept="image/*"
                                            capture="camera">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">LAB-DIP</label>
                                    </div>
                                    <div class="col-12">
                                        @error('lab_dip')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="file" class="form-control" name="lab_dip" accept="image/*"
                                            capture="camera">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">QTE CDE</label>
                                    </div>
                                    <div class="col-12">
                                        @error('qtecde')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="qtecde"
                                            value="{{ $historyEntree->qtecommande }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">QTE REÇU PL</label>
                                    </div>
                                    <div class="col-12">
                                        @error('qterecupl')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="qterecupl"
                                            value="{{ $historyEntree->qterecu }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">LAIZE CDE</label>
                                    </div>
                                    <div class="col-12">
                                        @error('laizecde')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="laizecde">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">QTE CDE kg</label>
                                    </div>
                                    <div class="col-12">
                                        @error('qtecdekg')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="qtecdekg" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">QTE REÇU PL kg</label>
                                    </div>
                                    <div class="col-12">
                                        @error('qterecuplkg')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="qterecuplkg" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">LAIZE REÇU PL</label>
                                    </div>
                                    <div class="col-12">
                                        @error('laizerecuepl')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="laizerecuepl" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
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
                                            <option value="0">Passed</option>
                                            <option value="1">Not passed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Conforme ?</label>
                                    </div>
                                    <div class="col-12">
                                        @error('conformite')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="conformite">
                                            <option value="">Selection</option>
                                            <option value="0">Conforme</option>
                                            <option value="1">Non conforme</option>
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
                                        <textarea class="form-control requete" name="observation" rows="4" cols="50"></textarea>

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
