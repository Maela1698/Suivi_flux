@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">

            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Sortie</h4>
                <form action="#" method="get">
                    @csrf
                    <div class="input-group">
                        <button class="btn btn-secondary">Ajout nouvelle entrée</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <form action="#" method="get" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idcategorietissu">
                                    <optgroup label="Catégorie du tissu">
                                        <option value="#">BIO</option>
                                        <option value="#">NON-BIO</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclassematierepremiere">
                                    <optgroup label="Catégorie de la matière">
                                        <option value="#">Current</option>
                                        <option value="#">En cours</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idutilisationwms">
                                    <optgroup label="Utilisation">
                                        <option value="#">Coupe type</option>
                                        <option value="#">Production</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclient">
                                    <optgroup label="Client">
                                        <option value="#">JACADI</option>
                                        <option value="#">ORCHESTRA</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idfournisseur">
                                    <optgroup label="Fournisseur">
                                        <option value="#">SOMACOU</option>
                                        <option value="#">SOCOTA</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="startEntree"
                                    value="{{ request()->startEntree }}">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="endEntree"
                                    value="{{ request()->endEntree }}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="text" class="form-control" name="startEntree" placeholder="Recherche"
                                    value="{{ request()->startEntree }}">
                            </div>
                        </div>

                        <div class="col-1">
                            <button class="btn btn-success">Filtrer</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                    aria-describedby="dataTable_info">
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
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Date sortie</th>
                                <th>NumeroBCI</th>
                                <th>Catégorie</th>
                                <th>Classe</th>
                                <th>Utilisation</th>
                                <th>Référence tissu</th>
                                <th>Désignation</th>
                                <th>Composition</th>
                                <th>Couleur</th>
                                <th>Fournisseur</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Saison</th>
                                <th>Laize</th>
                                <th>Destinataire</th>
                                <th>Receveur</th>
                                <th>Quantité livré</th>
                                <th>Prix unitaire</th>
                                <th>Commentaire</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sortie as $sorties)
                                <tr>
                                    <th>{{ $sorties->datesortie }}</th>
                                    <th>{{ $sorties->numbci }}</th>
                                    <th>{{ $sorties->categorie }}</th>
                                    <th>{{ $sorties->classe }}</th>
                                    <th>{{ $sorties->utilisation }}</th>
                                    <th>{{ $sorties->reference }}</th>
                                    <th>{{ $sorties->designation }}</th>
                                    <th>{{ $sorties->composition }}</th>
                                    <th>{{ $sorties->couleur }}</th>
                                    <th>{{ $sorties->fournisseur }}</th>
                                    <th>{{ $sorties->client }}</th>
                                    <th>{{ $sorties->modele }}</th>
                                    <th>{{ $sorties->saison }}</th>
                                    <th>{{ $sorties->laize }}</th>
                                    <th>{{ $sorties->destinataire }}</th>
                                    <th>{{ $sorties->receveur }}</th>
                                    <th>{{ $sorties->qtesortie }}</th>
                                    <th>{{ $sorties->prixunitaire }}</th>
                                    <th>{{ $sorties->commentaire }}</th>
                                    <td>
                                        <div style="display: flex">
                                            <div>
                                                <button class="btn btn-danger" type="button" data-toggle="modal"
                                                    data-target="#retour-modal-{{ $sorties->id }}"
                                                    style="border-radius: 50%;margin-right:10px">
                                                    <i class="fa fa-arrow-circle-o-left"></i>
                                                </button>
                                            </div>
                                            <div>
                                                <a class="btn" href="#"
                                                    style="border-radius: 50%; background-color: #f57c00; color: white;margin-right:10px"
                                                    title="Sortie de Stock">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <button class="btn btn-danger" type="button" data-toggle="modal"
                                                    data-target="#suppression-modal-{{ $sorties->id }}"
                                                    style="border-radius: 50%">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Retour
                                --}}
                                <div class="modal" id="retour-modal-{{ $sorties->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Retour</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('WMS.retour-tissu') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <p class="alert alert-primary" style="color: black">
                                                        Vous allez faire un retour</p>

                                                    <input type="hidden" name="idsortietissu"
                                                        value="{{ $sorties->id }}">

                                                    <div class="mb-3"><label class="form-label">Date de
                                                            retour</label>
                                                        @error('dateretour')
                                                            <span class="text-danger mb-1">{{ $message }}</span>
                                                        @enderror
                                                        <input class="form-control" type="date" name="dateretour">
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Quantité à
                                                            retourner</label>
                                                        @error('qteretour')
                                                            <span class="text-danger mb-1">{{ $message }}</span>
                                                        @enderror
                                                        <input class="form-control" type="text" name="qteretour"
                                                            placeholder="Quantité à retourner">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Annuler</button>
                                                <button class="btn btn-success" type="submit">Retour</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Suppression
                                --}}
                                <div class="modal" id="suppression-modal-{{ $sorties->id }}">
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
{{-- <table class="table my-0" id="dataTable">
    <thead>
        <tr>
            <th>Date sortie</th>
            <th>NumeroBCI</th>
            <th>Catégorie</th>
            <th>Classe</th>
            <th>Utilisation</th>
            <th>Référence tissu</th>
            <th>Désignation</th>
            <th>Composition</th>
            <th>Couleur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>2024-10-23</td>
            <td>123</td>
            <td>BIO</td>
            <td>en cours</td>
            <td>Coupe Type</td>
            <td>31317R</td>
            <td>LOVENAX</td>
            <td>50%</td>
            <td>CREAM</td>
            <td>
                <a href="#" class="voir-plus" data-target="extra-123">Voir plus</a>
            </td>
        </tr>
        <tr id="extra-123" class="extra-info" style="display: none;">
            <td colspan="10">
                <strong>Fournisseur:</strong> SOCOTA<br>
                <strong>Client:</strong> JACADI<br>
                <strong>Modèle:</strong> M1<br>
                <strong>Saison:</strong> E25<br>
                <strong>Laize:</strong> 154<br>
                <strong>Destinataire:</strong> DEV<br>
                <strong>Receveur:</strong> Tianara<br>
                <strong>Prix unitaire:</strong> 12,50<br>
                <strong>Commentaire:</strong> Aucun commentaire
            </td>
        </tr>
    </tbody>
</table> --}}
{{-- <script>
    $(document).ready(function() {
        $('.voir-plus').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target'); // Get the target row ID
            $('#' + target).toggle(); // Toggle visibility of the extra row
            $(this).text($(this).text() === 'Voir plus' ? 'Voir moins' : 'Voir plus'); // Change text
        });
    });
</script> --}}


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
