@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card col-12">
            <div class="card-header d-flex justify-content-between align-items-center entete">
                {{-- TODO: Detailler ceci avec la famille de tissu --}}
                <h3 class="entete">RAJOUT</h3>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('WMS.insert-rajout') }}" method="post"
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
                        <input type="hidden" name="idfamilletissus" value="{{ $data->idfamilletissu }}">
                        @if (isset($iddonnebc))
                            <input type="hidden" name="iddonnebc" value="{{ $iddonnebc }}">
                        @endif
                        @if (isset($stock->id))
                            <input type="hidden" name="idstocktissu" value="{{ $stock->id }}">
                        @endif
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Date entrée </label>
                                    </div>
                                    <div class="col-12">
                                        @error('dateentree')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="dateentree">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">date facturation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('datefacturation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="datefacturation">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Catégorie</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idcategorietissus')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idcategorietissus">
                                            <option value="">Selectionner la catégorie</option>
                                            @foreach ($catTissu as $catTissus)
                                                <option value="{{ $catTissus->id }}"
                                                    {{ isset($data) && $data->categorie == $catTissus->categorie ? 'selected' : '' }}>
                                                    {{ $catTissus->categorie }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
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
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Utilisation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idutilisationwms')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idutilisationwms" id="classe"
                                            style="width: 100%">
                                            <option value="">Selectionner le type d'utilisation</option>
                                            @foreach ($utilisation as $utilisations)
                                                <option value="{{ $utilisations->id }}">
                                                    {{ $utilisations->utilisation }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Numéro BC </label>
                                    </div>
                                    <div class="col-12">
                                        @error('numerobc')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="numerobc" class="form-control"
                                            placeholder="Numéro du BC"
                                            {{ isset($data->numerobc) ? 'value=' . $data->numerobc . '' : '' }}
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">Numéro BL </label>
                                    </div>
                                    <div class="col-12">
                                        @error('numerobl')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="numerobl" class="form-control"
                                            placeholder="Numéro du BL">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">

                                        <label class="col-form-label">Numéro Facture</label>
                                    </div>
                                    <div class="col-12">
                                        @error('numerofacture')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="numerofacture" class="form-control"
                                            placeholder="Numéro du Facture">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    {{-- TODO:change to autocomplete --}}
                                    <div class="col-12">
                                        <label class="col-form-label">Fournisseur Tissu</label>
                                    </div>
                                    <div class="col-12">
                                        @error('fournisseur')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- <select class="form-control fournisseur" name="idfournisseur"
                                            id="fournisseur">
                                        </select> --}}
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
                                    {{-- TODO: change to autocomplete --}}
                                    <div class="col-12">
                                        <label class="col-form-label">Client Tissu</label>
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
                                    {{-- TODO: A mediter si vraiment besoin --}}
                                    <div class="col-12">
                                        <label class="col-form-label">Modèle </label>
                                    </div>
                                    <div class="col-12">
                                        @error('modele')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="modele" class="form-control"
                                            placeholder="Modele"
                                            {{ isset($data->nom_modele) ? 'value=' . $data->nom_modele . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    {{-- TODO: A mediter si vraiment besoin --}}
                                    <div class="col-12">
                                        <label class="col-form-label">Saison</label>
                                    </div>
                                    <div class="col-12">
                                        @error('saison')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="saison" class="form-control"
                                            placeholder="Saison"
                                            {{ isset($data->type_saison) ? 'value=' . $data->type_saison . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Désignation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('designation')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="designation" class="form-control"
                                            placeholder="Désignation"
                                            {{ isset($stock->designation) ? 'value=' . $stock->designation . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Réference tissu</label>
                                    </div>
                                    <div class="col-12">
                                        @error('reftissu')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="reftissu" class="form-control"
                                            placeholder="Reference du tissu"
                                            {{ isset($stock->reference) ? 'value=' . $stock->reference . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Composition</label>
                                    </div>
                                    <div class="col-12">
                                        @error('composition')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="composition" class="form-control"
                                            placeholder="Composition"
                                            {{ isset($stock->composition) ? 'value=' . $stock->composition . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Couleur</label>
                                    </div>
                                    <div class="col-12">
                                        @error('couleur')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="couleur" class="form-control"
                                            placeholder="Couleur"
                                            {{ isset($data->couleur) ? 'value=' . $data->couleur . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Laize</label>
                                    </div>
                                    <div class="col-12">
                                        @error('laize')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="number" name="laize" class="form-control"
                                            placeholder="Laize"
                                            {{ isset($data->laize) ? 'value=' . $data->laize . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Quantité commandé</label>
                                    </div>
                                    <div class="col-12">
                                        @error('qtecommande')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="number" name="qtecommande" class="form-control"
                                            placeholder="Quantité commandé"
                                            {{ isset($data->quantite) ? 'value=' . $data->quantite . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Unité QC</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idunitemesurematierepremiere')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idunitemesurematierepremiere">
                                            {{-- @if ($data->unite)
                                                @php
                                                    $selectedunite = $uniteCommande->firstWhere('unite', $data->unite);
                                                @endphp
                                                @if ($selectedunite)
                                                    <option value="{{ $selectedunite->id }}">
                                                        {{ $selectedunite->unite }}</option>
                                                @endif
                                            @endif --}}
                                            <option value="">Selectionner la catégorie</option>
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
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Quantité reçu</label>
                                    </div>
                                    <div class="col-12">
                                        @error('qterecu')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="number" name="qterecu" class="form-control"
                                            placeholder="Quantité reçu">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Nombre de rouleau</label>
                                    </div>
                                    <div class="col-12">
                                        @error('nbrouleau')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="number" name="nbrouleau" class="form-control"
                                            placeholder="Nombre de rouleau">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Nombre de lot</label>
                                    </div>
                                    <div class="col-12">
                                        @error('nblot')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="number" name="nblot" class="form-control"
                                            placeholder="Nombre de lot">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Prix Unitaire</label>
                                    </div>
                                    <div class="col-12">
                                        @error('prixunitaire')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="number" name="prixunitaire" class="form-control"
                                            placeholder="Prix Unitaire"
                                            {{ isset($data->prix_unitaire) ? 'value=' . $data->prix_unitaire . '' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
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
                        </div>

                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        {{-- TODO: CHANGE THIS TO MULTIPLE CELLULE --}}
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
                                        <label class="col-form-label">Fret</label>
                                    </div>
                                    <div class="col-12">
                                        @error('fret')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="fret" class="form-control"
                                            placeholder="Fret">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Image</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="file" class="form-control" name="image">
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
        var selectedValue = "{{ isset($data->fournisseur) ? $data->fournisseur : '' }}";
        if (selectedValue) {
            $('.fournisseur').val(selectedValue).trigger('change'); // Set the selected value
        }
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
