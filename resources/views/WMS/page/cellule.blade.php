@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        {{-- <h3 class="text-dark mb-4" style="text-align: center">Parité</h3> --}}
        <div class="card">

            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Cellule</p>
            </div>
            <div class="card-body">
                <form action="{{ route('enregistrer', ['modelName' => 'Cellule']) }}" method="post"
                    style="border-radius: 34px;" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-center">Ajout de cellule à la rack {{ $rack->designation }}</h4>
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
                    <div>
                        <input type="hidden" name="idrack" value="{{ $rack->id }}">
                    </div>
                    {{-- TODO : Rectifier le css --}}
                    <div class="form-group d-flex flex-column align-items-center">
                        @error('designation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input class="form-control w-50" type="text" name="designation" placeholder="Désignation">
                    </div>

                    <div class="form-group d-flex justify-content-center">
                        @error('largeur')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input class="form-control w-50" type="number" name="largeur" placeholder="Largeur">
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        @error('longueur')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input class="form-control w-50" type="number" name="longueur" placeholder="Longueur">
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        @error('hauteur')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input class="form-control w-50" type="number" name="hauteur" placeholder="Hauteur">
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        @error('idclassematierepremiere')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <select class="form-control w-50" name="idclassematierepremiere">
                            <optgroup label="Classe de la matière première">
                                <option value="#">Selection de classe</option>
                                @foreach ($classeMatiere as $classeMatieres)
                                    <option value="{{ $classeMatieres->id }}">{{ $classeMatieres->classe }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <textarea class="form-control w-50" type="text" name="commentaire" placeholder="Commentaire"></textarea>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <button class="btn btn-primary" type="submit">Ajouter</button>
                    </div>
                </form>
                <div>
                    @if (Session::has('success'))
                        <div class="alert alert-success" style="text-align: center;color: #495057">
                            {{ Session::get('success') }}
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
                                <th>Désignation</th>
                                <th>Largeur</th>
                                <th>Longueur</th>
                                <th>Hauteur</th>
                                <th>Classe de la matière</th>
                                <th>Commentaire</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cellule as $cellules)
                                <tr>
                                    <td>{{ $cellules->designation }}</td>
                                    <td>{{ $cellules->largeur }}</td>
                                    <td>{{ $cellules->longueur }}</td>
                                    <td>{{ $cellules->hauteur }}</td>
                                    <td>{{ $cellules->idclassematierepremiere }}</td>
                                    <td>{{ $cellules->commentaire }}</td>
                                    <td>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modification-modal-{{ $cellules->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal-{{ $cellules->id }}"
                                            style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Modification modal
                                --}}
                                <div class="modal" id="modification-modal-{{ $cellules->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Modification</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Modification de la cellule</p>
                                                <form id="modification-form" action="#" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3"><label class="form-label">Désignation</label>
                                                        <input class="form-control" type="text" name="designation"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">largeur</label>
                                                        <input class="form-control" type="number" name="largeur"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">longueur</label>
                                                        <input class="form-control" type="number" name="longueur"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">hauteur</label>
                                                        <input class="form-control" type="number" name="hauteur"
                                                            value="">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Classe de la
                                                            matière</label>
                                                        <select class="form-control" name="idsectionwms">
                                                            <optgroup label="Classe">
                                                                <option value="#">Current</option>
                                                                <option value="#">En cours</option>
                                                            </optgroup>
                                                        </select>
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
                                <div class="modal" id="suppression-modal-{{ $cellules->id }}">
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
