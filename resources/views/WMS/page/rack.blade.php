@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">

            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Rack</p>
            </div>
            <div class="card-body">
                <form action="{{ route('enregistrer', ['modelName' => 'Rack']) }}" method="post"
                    style="border-radius: 34px;" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-center">Ajout Rack</h4>
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
                    <div class="form-group d-flex flex-column align-items-center">
                        @error('idsectionwms')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <select class="form-control w-50" name="idsectionwms">
                            <optgroup label="Section">
                                <option value="">Selection de section</option>
                                @foreach ($section as $sections)
                                    <option value="{{ $sections->id }}">
                                        {{ $sections->section }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group d-flex flex-column align-items-center">
                        @error('idcategorietissus')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <select class="form-control w-50" name="idcategorietissu">
                            <optgroup label="Catégorie de tissu">
                                <option value="">Sélection de catégorie</option>
                                @foreach ($catTissu as $catTissus)
                                    <option value="{{ $catTissus->id }}">
                                        {{ $catTissus->categorie }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group d-flex flex-column align-items-center">
                        @error('designation')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <input class="form-control w-50" type="text" name="designation" placeholder="Désignation">
                    </div>

                    <div class="form-group d-flex flex-column align-items-center">
                        @error('largeur')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <input class="form-control w-50" type="number" name="largeur" placeholder="Largeur">
                    </div>

                    <div class="form-group d-flex flex-column align-items-center">
                        @error('longueur')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <input class="form-control w-50" type="number" name="longueur" placeholder="Longueur">
                    </div>

                    <div class="form-group d-flex flex-column align-items-center">
                        @error('hauteur')
                            <span class="text-danger mb-1">{{ $message }}</span>
                        @enderror
                        <input class="form-control w-50" type="number" name="hauteur" placeholder="Hauteur">
                    </div>

                    <div class="form-group d-flex flex-column align-items-center">
                        <textarea class="form-control w-50" type="text" name="commentaire" placeholder="Commentaire"></textarea>
                    </div>
                    <div class="form-group d-flex flex-column align-items-center">
                        <button class="btn btn-primary" type="submit">Ajouter</button>
                    </div>
                </form>
                <div>
                    @if (Session::has('DonneErreur'))
                        <div class="alert alert-warning" style="text-align: center;color: #495057">
                            {{ Session::get('DonneErreur') }}
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success" style="text-align: center;color: #495057">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::has('fail'))
                        <div class="alert alert-danger" style="text-align: center;color: #495057">
                            {{ Session::get('fail') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger" style="text-align: center;color: #495057">
                            {{ Session::get('erreur') }}
                        </div>
                    @endif
                </div>
                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                    aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Section</th>
                                <th>Catégorie du tissu</th>
                                <th>Désignation</th>
                                <th>Largeur</th>
                                <th>Longueur</th>
                                <th>Hauteur</th>
                                <th>Commentaire</th>
                                <th>Cellule</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rack as $racks)
                                <tr>
                                    {{-- TODO:Afficher les nom de section et categorie --}}
                                    <td>{{ $racks->idsectionwms }}</td>
                                    <td>{{ $racks->idcategorietissus }}</td>
                                    <td>{{ $racks->designation }}</td>
                                    <td>{{ $racks->largeur }}</td>
                                    <td>{{ $racks->longueur }}</td>
                                    <td>{{ $racks->hauteur }}</td>
                                    <td>{{ $racks->commentaire }}</td>
                                    <td>
                                        <a class="btn btn-primary"
                                            href="{{ route('WMS.cellule', ['idrack' => $racks->id]) }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-box-open"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modification-modal-{{ $racks->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal-{{ $racks->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Modification modal
                                --}}
                                <div class="modal" id="modification-modal-{{ $racks->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Modification</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Modification de la rack</p>
                                                <form id="modification-form"
                                                    action="{{ route('modifier', ['modelName' => 'Rack', 'id' => $racks->id]) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3"><label class="form-label">Section</label>
                                                        <select class="form-control" name="idsectionwms">
                                                            <optgroup label="Section">
                                                                <option value="#">Tissu</option>
                                                                <option value="#">Tissu obsolète</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Catégorie du
                                                            tissu</label>
                                                        <select class="form-control" name="idcategorietissus">
                                                            <optgroup label="Catégorie de tissu">
                                                                <option value="#">BIO</option>
                                                                <option value="#">NON-BIO</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Désignation</label>
                                                        <input class="form-control" type="text" name="designation"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Largeur</label>
                                                        <input class="form-control" type="number" name="largeur"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Longueur</label>
                                                        <input class="form-control" type="number" name="longueur"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Hauteur</label>
                                                        <input class="form-control" type="number" name="hauteur"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Commentaire</label>
                                                        <textarea class="form-control" type="text" name="commentaire" value=""></textarea>
                                                    </div>
                                            </div>
                                            <div style="text-align: center">
                                                <div class="modal-footer" style="text-align: center">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal"
                                                        onclick="resetFormValues()">Annuler</button>
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
                                <div class="modal" id="suppression-modal-{{ $racks->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Suppression</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('supprimer', ['modelName' => 'Rack', 'id' => $racks->id]) }}">
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
{{-- <script>
    $(document).ready(function() {
        @foreach ($utilisateur as $utilisateurs)
            $('#fonction_id_{{ $utilisateurs->id }}').select2({
                width: '100%',
                ajax: {
                    url: '{{ route('p-autocomplete-fonction') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            query: params.term, // Search term
                            page: params.page
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(fonction) {
                                return {
                                    id: fonction.id,
                                    text: fonction.nom
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        @endforeach

    });
</script> --}}
{{-- <script>
    function resetFormValues(directionId) {
        // Reset the form fields to their initial values
        document.getElementById(`modification-form-${directionId}`).reset();
    }
    @foreach ($utilisateur as $utilisateurs)
        $('#modification-modal-{{ $utilisateurs->id }}').on('hidden.bs.modal', function() {
            resetFormValues({{ $utilisateurs->id }});
        });
    @endforeach
</script> --}}
