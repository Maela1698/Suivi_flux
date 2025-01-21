@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card col-12">
            <div class="card-header d-flex justify-content-between align-items-center entete">
                <h3 class="entete">Nouvelle Entree {{ $typeWMS->type }}</h3>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('WMS.ajout-entree-wms') }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
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
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Désignation </label>
                                    </div>
                                    <div class="col-12">
                                        @error('designation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="designation">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Réference</label>
                                    </div>
                                    <div class="col-12">
                                        @error('reference')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="reference">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Code</label>
                                    </div>
                                    <div class="col-12">
                                        @error('code')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Numéro facture</label>
                                    </div>
                                    <div class="col-12">
                                        @error('numerofacture')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="numerofacture">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Couleur</label>
                                    </div>
                                    <div class="col-12">
                                        @error('couleur')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="couleur">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Saison</label>
                                    </div>
                                    <div class="col-12">
                                        @error('saison')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="saison">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Fournisseur Tissu</label>
                                    </div>
                                    <div class="col-12">
                                        @error('fournisseur')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idfournisseur">
                                            <option value="">Selection</option>
                                            @foreach ($fournisseur as $fournisseurs)
                                                <option value="{{ $fournisseurs->id }}"
                                                    {{ isset($data->fournisseur) && $data->fournisseur == $fournisseurs->nomtier ? 'selected' : '' }}>
                                                    {{ $fournisseurs->nomtier }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Client</label>
                                    </div>
                                    <div class="col-12">
                                        @error('client')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idclient">
                                            <option value="">Selection</option>
                                            @foreach ($client as $clients)
                                                <option value="{{ $clients->id }}"
                                                    {{ isset($data->client) && $data->client == $clients->nomtier ? 'selected' : '' }}>
                                                    {{ $clients->nomtier }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">Modèle </label>
                                    </div>
                                    <div class="col-12">
                                        @error('modele')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="modele" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Date d'entrée</label>
                                    </div>
                                    <div class="col-12">
                                        @error('dateentree')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" name="dateentree" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Date de facturation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('datefacturation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" name="datefacturation" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Num BC</label>
                                    </div>
                                    <div class="col-12">
                                        @error('numbc')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="numbc" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Num BL</label>
                                    </div>
                                    <div class="col-12">
                                        @error('numbc')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="numbl" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Quantité commander</label>
                                    </div>
                                    <div class="col-12">
                                        @error('qtecommande')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="qtecommande" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Quantité reçue</label>
                                    </div>
                                    <div class="col-12">
                                        @error('qteentree')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="qteentree" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Image</label>
                                    </div>
                                    <div class="col-12">
                                        @error('image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Unité QC</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idunitemesurematierepremiere')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idunitemesurematierepremiere">
                                            <option value="">Selectionner l'unité'</option>
                                            @foreach ($uniteCommande as $uniteCommandes)
                                                <option value="{{ $uniteCommandes->id }}"
                                                    {{ isset($data) && $data->unite == $uniteCommandes->unite_mesure ? 'selected' : '' }}>
                                                    {{ $uniteCommandes->unite_mesure }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Prix Unitaire</label>
                                    </div>
                                    <div class="col-12">
                                        @error('prixunitaire')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="prixunitaire" class="form-control"
                                            {{ isset($data->prix_unitaire) ? 'value=' . $data->prix_unitaire . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Unité monétaire</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idunitemonetaire')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idunitemonetaire">
                                            <option value="">Selectionner la catégorie</option>
                                            @foreach ($uniteMonetaire as $uniteMonetaires)
                                                <option value="{{ $uniteMonetaires->id }}"
                                                    {{ isset($data) && $data->devise == $uniteMonetaires->unite ? 'selected' : '' }}>
                                                    {{ $uniteMonetaires->unite }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Fret</label>
                                    </div>
                                    <div class="col-12">
                                        @error('fret')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="fret" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        {{-- TODO: CHANGE THIS TO CELLULE OF WMS --}}
                                        <label class="col-form-label">Cellule</label>
                                    </div>
                                    <div class="col-12">
                                        @error('cellule')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select name="cellule[]" id="cellule" multiple
                                            class="form-control"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Classe</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idclassematierepremiere')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idclassematierepremiere" id="classe"
                                            style="width: 100%">
                                            <option value="">Selectionner la classe</option>
                                            @foreach ($classeMatiere as $classeMatieres)
                                                <option value="{{ $classeMatieres->id }}">
                                                    {{ $classeMatieres->classe }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Famille</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idfamillewms')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idfamillewms" id="classe"
                                            style="width: 100%">
                                            <option value="">Selectionner la Famille</option>
                                            @foreach ($familleWMS as $familleWMSs)
                                                <option value="{{ $familleWMSs->id }}">
                                                    {{ $familleWMSs->nom }}
                                                </option>
                                            @endforeach
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
                                        <textarea class="form-control requete" name="commentaire" rows="4" cols="50"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('CRM.footer')
<style>
    /* Custom styling for Select2 dropdown */
    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
        /* Set border color */
        height: 38px;
        /* Adjust height */
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #495057;
        /* Set placeholder color */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 5px;
        /* Adjust arrow position */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        /* Adjust line height */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #495057 transparent transparent transparent;
        /* Adjust arrow color */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
        /* Adjust arrow container height */
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        console.log('jQuery version:', $.fn.jquery);
        console.log('Select2 loaded:', typeof $.fn.select2 !== 'undefined');

        // Initialize the Select2 for fournisseur field
        $('.fournisseur').select2({
            width: '100%',
            ajax: {
                url: '{{ route('WMS.autocomplete-fournisseur') }}', // Ensure this route returns the correct JSON response
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        query: params.term, // Search term
                    };
                },
                processResults: function(data) {
                    // Map the returned JSON data to a format Select2 understands
                    return {
                        results: data.map(function(fournisseur) {
                            return {
                                id: fournisseur
                                    .id, // Map to 'id' field from the JSON response
                                text: fournisseur
                                    .nomtier // Map to 'nomtier' field from the JSON response
                            };
                        })
                    };
                },
                cache: true
            }
        });

    });
</script>
<script>
    $('#cellule').select2({
        placeholder: 'Selection de cellule',
        ajax: {
            url: '{{ route('WMS.autocomplete-cellule-tissu') }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term // search term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.idcellule, // the id of the cellule
                            text: item.designation // the designation to display in the dropdown
                        };
                    })
                };
            },
            cache: true
        }
    });
</script>
