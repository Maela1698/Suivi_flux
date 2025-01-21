@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">

            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Entrée {{ $familleTissu->famille_tissus }}</h4>
                <form action="{{ route('WMS.tissu-entree', ['idfamilletissus' => $familleTissu->id]) }}" method="get">
                    @csrf
                    <div class="input-group">
                        <button class="btn btn-secondary">Ajout nouvelle entrée</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <form action="#" method="get">
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
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Parité</th>
                                <th>Date d'entrée</th>
                                <th>Date de facturation</th>
                                <th>Catégorie</th>
                                <th>Classe</th>
                                <th>Utilisation</th>
                                <th>Numéro BC</th>
                                <th>Numéro BL</th>
                                <th>Numéro Facture</th>
                                <th>Fournisseur</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Saison</th>
                                <th>Désignation</th>
                                <th>Reference tissu</th>
                                <th>Composition</th>
                                <th>Couleur</th>
                                <th>Laize</th>
                                <th>Quantité commander</th>
                                <th>Unité commande</th>
                                <th>Quantité reçu</th>
                                <th>Taux ecart</th>
                                <th>Nombre de rouleau</th>
                                <th>Nombre de lot</th>
                                <th>Prix unitaire</th>
                                <th>Unité monétaire</th>
                                <th>Reste à recevoir</th>
                                <th>Fret</th>
                                <th>Commentaire</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historyEntree as $historyEntrees)
                                <tr>
                                    <th>{{ $historyEntrees->valeur }}</th>
                                    <th>{{ $historyEntrees->dateentree }}</th>
                                    <th>{{ $historyEntrees->datefacturation }}</th>
                                    <th>{{ $historyEntrees->categorie }}</th>
                                    <th>{{ $historyEntrees->classe }}</th>
                                    <th>{{ $historyEntrees->utilisation }}</th>
                                    <th>{{ $historyEntrees->numerobc }}</th>
                                    <th>{{ $historyEntrees->numerobl }}</th>
                                    <th>{{ $historyEntrees->numerofacture }}</th>
                                    <th>{{ $historyEntrees->fournisseur }}</th>
                                    <th>{{ $historyEntrees->client }}</th>
                                    <th>{{ $historyEntrees->modele }}</th>
                                    <th>{{ $historyEntrees->saison }}</th>
                                    <th>{{ $historyEntrees->des_tissu }}</th>
                                    <th>{{ $historyEntrees->reftissu }}</th>
                                    <th>{{ $historyEntrees->composition }}</th>
                                    <th>{{ $historyEntrees->couleur }}</th>
                                    <th>{{ $historyEntrees->laize }}</th>
                                    <th>{{ $historyEntrees->qtecommande }}</th>
                                    <th>{{ $historyEntrees->unite_mesure }}</th>
                                    <th>{{ $historyEntrees->qterecu }}</th>
                                    <th>{{ $historyEntrees->tauxecart . '%' }}</th>
                                    <th>{{ $historyEntrees->nbrouleau }}</th>
                                    <th>{{ $historyEntrees->nblot }}</th>
                                    <th>{{ $historyEntrees->prixunitaire }}</th>
                                    <th>{{ $historyEntrees->unite_monetaire }}</th>
                                    <th>{{ $historyEntrees->resterecevoir }}</th>
                                    <th>{{ $historyEntrees->fret }}</th>
                                    <th>{{ $historyEntrees->commentaire }}</th>

                                    <td>
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modification-modal" style="border-radius: 50%">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" data-toggle="modal"
                                            data-target="#suppression-modal" style="border-radius: 50%">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>
                                {{-- ---------------------------------------------------------------------------- --}}
                                {{--
                                    * Modification modal
                                --}}
                                <div class="modal" id="modification-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header" style="text-align: left;">
                                                <h4 class="modal-title" style="color: black">
                                                    Modification</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center alert alert-info">Modification de la rack</p>
                                                <form id="modification-form" action="#" method="post"
                                                    enctype="multipart/form-data">
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
                                                        <select class="form-control" name="idcategorietissu">
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
                                <div class="modal" id="suppression-modal">
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
