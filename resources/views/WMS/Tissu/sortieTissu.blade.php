@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card col-12">
            <div class="card-header d-flex justify-content-between align-items-center entete">
                {{-- TODO: Detailler --}}
                <h3 class="entete">NOUVELLE SORTIE </h3>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('WMS.sortie-stock-tissu') }}" method="post"
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
                        <input type="hidden" class="form-control" name="idstocktissu" value="{{ $stock->id }}">
                        <input type="hidden" class="form-control" name="idunitemesurematierepremiere"
                            value="{{ $stock->idunitemesurematierepremiere }}">
                        <input type="hidden" class="form-control" name="idfamilletissus"
                            value="{{ $stock->idfamilletissus }}">
                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Date Sortie</label>
                                    </div>
                                    <div class="col-12">
                                        @error('datesortie')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="datesortie" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Numéro BC interne</label>
                                    </div>
                                    <div class="col-12">
                                        @error('numbci')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="numbci"
                                            placeholder="Numéro du BC interne" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Catégorie</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idcategorietissus')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idcategorietissus" required>
                                            <option value="">Selectionner la catégorie</option>
                                            @foreach ($catTissu as $catTissus)
                                                <option value="{{ $catTissus->id }}"
                                                    {{ isset($stock) && $stock->categorie == $catTissus->categorie ? 'selected' : '' }}>
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
                                        <select class="form-control" name="idclassematierepremiere" required>
                                            <option value="">Selectionner la classe</option>
                                            @foreach ($classeMatiere as $classeMatieres)
                                                <option value="{{ $classeMatieres->id }}"
                                                    {{ isset($stock) && $stock->idclassematierepremiere == $classeMatieres->id ? 'selected' : '' }}>
                                                    {{ $classeMatieres->classe }}
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
                                        <label class="col-form-label">Utilisation</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idutilisationwms')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control" name="idutilisationwms" required>
                                            <option value="">Selectionner le type d'utilisation</option>
                                            @foreach ($utilisation as $utilisations)
                                                <option value="{{ $utilisations->id }}"
                                                    {{ isset($stock) && $stock->idutilisationwms == $utilisations->id ? 'selected' : '' }}>
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
                                        <label class="col-form-label">Reference tissu</label>
                                    </div>
                                    <div class="col-12">
                                        @error('reference')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="reference"
                                            value="{{ $stock->reference }}">
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
                                        <input type="text" class="form-control" name="designation"
                                            value="{{ $stock->designation }}">
                                    </div>
                                </div>
                            </div>
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
                                            placeholder="Composition" value="{{ $stock->composition }}" required>
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
                                        <input type="text" name="couleur" class="form-control"
                                            value="{{ $stock->couleur }}" placeholder="Couleur" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Fournisseur</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idfournisseur')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="hidden" name="idfournisseur"
                                            value="{{ $stock->idfournisseur }}">
                                        <input type="text" name="fournisseur" class="form-control"
                                            placeholder="Fournisseur" value="{{ $stock->fournisseur }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Client</label>
                                    </div>
                                    <div class="col-12">
                                        @error('idclient')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <select class="form-control client" name="idclient" id="client">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Modèle</label>
                                    </div>
                                    <div class="col-12">
                                        @error('modele')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="modele" class="form-control"
                                            placeholder="Modèle" value="{{ $stock->modele }}">

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Saison</label>
                                    </div>
                                    <div class="col-12">
                                        @error('saison')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="saison" class="form-control"
                                            placeholder="Saison" value="{{ $stock->saison }}">
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
                                        <input type="text" name="laize" class="form-control"
                                            placeholder="Laize" value="{{ $stock->laize }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Destinataire</label>
                                    </div>
                                    <div class="col-12">
                                        @error('destinataire')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="destinataire" class="form-control"
                                            placeholder="Destinataire" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Receveur</label>
                                    </div>
                                    <div class="col-12">
                                        @error('receveur')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" name="receveur" class="form-control"
                                            placeholder="Receveur" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Quantité livré</label>
                                    </div>
                                    <div class="col-12">
                                        @error('qtesortie')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="qtesortie"
                                            placeholder="Quantité Livré">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Prix unitaire</label>
                                    </div>
                                    <div class="col-12">
                                        @error('prixunitaire')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="text" class="form-control" name="prixunitaire"
                                            placeholder="Prix unitaire" value="{{ $stock->prixunitaire }}">
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


                        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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
        height: 35px;
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
        $('.client').select2({
            width: '100%',
            ajax: {
                url: '{{ route('WMS.autocomplete-client') }}', // Ensure this route returns the correct JSON response
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
                        results: data.map(function(client) {
                            return {
                                id: client
                                    .id, // Map to 'id' field from the JSON response
                                text: client
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
