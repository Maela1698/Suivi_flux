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
            <div class="card-header d-flex justify-content-between align-items-center entete">
                <h3 class="entete">NOUVELLE SORTIE </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- DESIGNATION -->
                    <div class="col-md-6">
                        <div class="static-label">DESIGNATION</div>
                        <div class="static-field">{{ $stock->designation }}</div>
                    </div>
                    <!-- REFERENCE -->
                    <div class="col-md-6">
                        <div class="static-label">REFERENCE</div>
                        <div class="static-field">{{ $stock->reference }}</div>
                    </div>
                    <!-- CLASSE -->
                    <div class="col-md-6">
                        <div class="static-label">CLASSE</div>
                        <div class="static-field">{{ $stock->classe }}</div>
                    </div>
                    <!-- FOURNISSEUR -->
                    <div class="col-md-6">
                        <div class="static-label">FOURNISSEUR</div>
                        <div class="static-field">{{ $stock->fournisseur }}</div>
                    </div>
                    <!-- RECEIVED QTY -->
                    <div class="col-md-6">
                        <div class="static-label">QUANTITÉ EN STOCK</div>
                        <div class="static-field">{{ $stock->qtestock }}</div>
                    </div>
                    <!-- COULEUR -->
                    <div class="col-md-6">
                        <div class="static-label">COULEUR</div>
                        <div class="static-field">{{ $stock->couleur }}</div>
                    </div>
                </div>
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
                        <input type="hidden" class="form-control" name="obsolete" value="{{ $stock->obsolete }}">
                        <input type="hidden" class="form-control" name="typeSortie" value="1">
                        <input type="hidden" class="form-control" name="idfamilletissus"
                            value="{{ $stock->idfamilletissus }}">
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Date Sortie</label>
                                    </div>
                                    <div class="col-12">
                                        @error('datesortie')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input type="date" class="form-control" name="datesortie"
                                            value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
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

                            <div class="col-4">
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
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
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
                            <div class="col-4">
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
                            <div class="col-4">
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
