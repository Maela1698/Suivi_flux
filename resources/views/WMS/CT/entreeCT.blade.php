@include('CRM.header')
@include('CRM.sidebar')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card col-12">
            <div class="card-header d-flex justify-content-between align-items-center entete">
                <h3 class="entete">NOUVELLE ENTREE DE CHAINE ET TRAME</h3>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('WMS.ajout-entree-ct') }}" method="post"
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
                                        {{-- TODO: Non modifiable --}}
                                        <label class="col-form-label">Numéro BC </label>
                                    </div>
                                    <div class="col-12">
                                        @error('numerobc')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="numerobc" class="form-control"
                                            placeholder="Numéro du BC"
                                            {{ isset($data->numerobc) ? 'value=' . $data->numerobc . '' : '' }}>
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
                                            placeholder="Numéro du BC">
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
                                        <select class="form-control" name="fournisseur">
                                            {!! isset($data->fournisseur)
                                                ? '<option value="' . $data->fournisseur . '">' . $data->fournisseur . '</option>'
                                                : '' !!}
                                            <option value="">Selection</option>
                                            @foreach ($fournisseur as $fournisseurs)
                                                <option value="{{ $fournisseurs->nomtier }}">
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
                                        <select class="form-control" name="client">
                                            {!! isset($data->client) ? '<option value="' . $data->client . '">' . $data->client . '</option>' : '' !!}
                                            <option value="">Selection</option>
                                            @foreach ($client as $clients)
                                                <option value="{{ $clients->nomtier }}">
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
                                            {{ isset($data->des_tissus) ? 'value=' . $data->des_tissus . '' : '' }}>
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
                                            {{ isset($data->ref_tissus) ? 'value=' . $data->ref_tissus . '' : '' }}>
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
                                            {{ isset($data->composition_tissus) ? 'value=' . $data->composition_tissus . '' : '' }}>
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
                                        {{-- TODO: create a view for this and change to autocomplete --}}
                                        <label class="col-form-label">Cellule</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idcellule')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idcellule">
                                            <option value="">Selection</option>
                                            @foreach ($cellule as $cellules)
                                                <option value="{{ $cellules->id }}">
                                                    {{ $cellules->designation }}</option>
                                            @endforeach
                                        </select>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        console.log('jQuery version:', $.fn.jquery);
        console.log('Select2 loaded:', typeof $.fn.select2 !== 'undefined');

        // Initialize Numéro BC select2
        $('.form-control.bc').select2({
            width: '100%',
            ajax: {
                url: '{{ route('WMS.autocomplete-num-bc') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        query: params.term,
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(bc) {
                            return {
                                id: bc.id_donne_bc,
                                text: bc.numerobc
                            };
                        })
                    };
                },
                cache: true
            }
        });

        // Handle selection of Numéro BC
        $('.form-control.bc').on('select2:select', function(e) {
            const selectednumBc = e.params.data.id; // Get the ID for further requests

            // Clear and disable the des select initially
            $('.form-control.des').empty().prop('disabled', true);

            // Fetch data for the des dropdown based on selected bc
            $.ajax({
                url: '{{ route('WMS.autocomplete-des-tissu', ['id' => '']) }}' + selectednumBc,
                dataType: 'json',
                success: function(data) {
                    const options = data.map(function(des) {
                        return {
                            id: des.id_donne_bc,
                            text: des.des_tissus
                        };
                    });

                    // Initialize the des select2 with new options
                    $('.form-control.des').select2('destroy')
                        .empty(); // Destroy previous instance
                    $('.form-control.des').select2({
                        width: '100%',
                        data: options
                    }).prop('disabled', false);
                },
                error: function() {
                    console.error('Error fetching des data');
                }
            });
        });
    });
</script>
