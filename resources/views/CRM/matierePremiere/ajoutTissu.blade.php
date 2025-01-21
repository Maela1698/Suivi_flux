@include('CRM.header')
@include('CRM.sidebar')
<title>AjoutTissu</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .form-control {
        border: 1px solid #b5b5b5;
    }

    label {
        color: #767575;
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">AJOUT TISSU</h3>
                </div>

                <div class="card-body" style="background-color: rgb(239, 238, 238); border-radius: 10px;">
                    <center>  <h2>{{ $demande[0]->type_saison }}</h2></center>
                    <div class="row mt-3" style="display: flex; align-items: center;">
                        <div class="col-md-2 mt-1">
                            <center>
                                <img src="data:image/png;base64,{{ $demande[0]->photo_commande }}"
                                    class="img-fluid rounded-start mb-5" alt="Logo" width="120px" height="120px">
                            </center>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte"><b>Date entrée :</b>
                                    {{ \Carbon\Carbon::parse($demande[0]->date_entree)->format('d/m/y') }}</p>
                                    <p class="texte"><b>Periode :</b> {{ $demande[0]->periode }}</p>
                                <p class="texte"><b>Client :</b> {{ $demande[0]->nomtier }}</p>
                                <p class="texte"><b>Modèle :</b>{{ $demande[0]->nom_modele }}</p>
                                <p class="texte"><b>Designation :</b>{{ $demande[0]->nom_style }}</p>
                                <p class="texte"><b>Thème :</b>{{ $demande[0]->theme }}</p>
                                <p class="texte"><b>Quantité prévisionnel
                                        :</b>{{ $demande[0]->qte_commande_provisoire }}</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte">
                                    <b>ETD:</b>{{ \Carbon\Carbon::parse($demande[0]->date_livraison)->format('d/m/y') }}
                                </p>
                                <p class="texte"><b>Stade :</b> {{ $demande[0]->type_stade }}</p>
                                <p class="texte"><b>Grille de taille
                                        :</b>{{ $demande[0]->taillemin }}--{{ $demande[0]->taillemax }}</p>
                                <p class="texte"><b>Taille de base :</b>{{ $demande[0]->taille_base }}</p>
                                <p class="texte"><b>Incontern :</b> {{ $demande[0]->type_incontern }}</p>
                                <p class="texte"><b>Phase :</b> {{ $demande[0]->type_phase }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" action=" {{ route('CRM.ajoutTissu') }} " method="post"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <input type="hidden" name="id_demande_client" value="{{ $idDC }}">
                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Type de tissu</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="typeTissu" class="form-control" placeholder=""
                                                required>
                                            <input type="hidden" id="id_type_tissus" class="form-control"
                                                name="id_type_tissus" required>
                                            <ul id="suggestionsList" class="list-group mt-2" style="display: none;">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Designation</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="designation" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Composition</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="composition" class="form-control" placeholder=""
                                                required>
                                            <input type="hidden" id="id_composition_tissus" class="form-control"
                                                name="id_composition_tissus" required>
                                            <ul id="suggestionsListComposition" class="list-group mt-2"
                                                style="display: none;"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Reference</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="reference">
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
                                            <select class="form-control" name="id_categorie_tissus" required>
                                                @foreach ($categorieTissu as $c)
                                                    <option value="{{ $c->id }}">{{ $c->categorie }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Couleur</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="couleur">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Classe</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="id_classe" required>
                                                @foreach ($classeMP as $classe)
                                                    <option value="{{ $classe->id }}">{{ $classe->classe }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Unité de mesure</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="id_unite_mesure_matiere" required>
                                                @foreach ($uniteMesureMP as $u)
                                                    <option value="{{ $u->id }}">{{ $u->unite_mesure }}</option>
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
                                            <label class="col-form-label">Devise</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="id_unite_monetaire" required>
                                                @foreach ($uniteMonetaire as $devise)
                                                    <option value="{{ $devise->id }}">{{ $devise->unite }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Grammage</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" value="0"
                                                name="grammage">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">LaizeUtile</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" value="0"
                                                name="laize_utile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Famille</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="familleTissu" class="form-control"
                                                placeholder="" required>
                                            <input type="hidden" id="id_famille_tissus" class="form-control"
                                                name="id_famille_tissus" required>
                                            <ul id="suggestionsListFamilleTissu" class="list-group mt-2"
                                                style="display: none;"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">L-retraitLavage(%)</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" value="0"
                                                name="l_retrait_lavage">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">W-retraitLavage(%)</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" value="0"
                                                name="w_retrait_lavage">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">L-retraitTeinture(%)</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" value="0"
                                                name="l_retrait_teinture">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">W-retraitTeinture(%)</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" value="0"
                                                name="w_retrait_teinture">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Prix unitaire </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" value="0" name="prix_unitaire" pattern="[\d,]+(\.\d+)?">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Frais </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" value="0"
                                                name="frais">
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>



                    <!-- Unité Monétaire, Qualité et Etat -->
                    <div class="form-group row">
                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label" >Photo </label>
                                </div>
                                <div class="col-12">
                                    <input type="file"  class="form-control" name="photo">
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label">Nom du fiche technique</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="nom_fiche_technique">
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label" >Fiche technique </label>
                                </div>
                                <div class="col-12">
                                    <input type="file"  class="form-control" name="fiche_technique">
                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="form-group row">

                        <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                            <a href="{{ route('CRM.listeMatierePremiere') }}" class="btn btn-info mr-3">Retour</a>
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger text-center" style="margin: 0 auto" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</div>


<!--**********************************
        modal start
***********************************-->





<!--**********************************
        javascript start
***********************************-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var typeTissu = document.getElementById('typeTissu');
        var id_type_tissus = document.getElementById('id_type_tissus');
        var suggestionsList = document.getElementById('suggestionsList');

        typeTissu.addEventListener('input', function() {
            var query = typeTissu.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('rechercheTypeTissu') }}?typeTissu=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var countries = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (countries.length > 0) {
                        countries.forEach(function(country) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = country.type_tissus;
                            li.addEventListener('click', function() {
                                typeTissu.value = country.type_tissus;
                                id_type_tissus.value = country.id;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!typeTissu.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var composition = document.getElementById('composition');
        var id_composition_tissus = document.getElementById('id_composition_tissus');
        var suggestionsList = document.getElementById('suggestionsListComposition');

        composition.addEventListener('input', function() {
            var query = composition.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('rechercheComposition') }}?composition=' + encodeURIComponent(
                query), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var countries = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (countries.length > 0) {
                        countries.forEach(function(country) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = country.composition_tissus;
                            li.addEventListener('click', function() {
                                composition.value = country.composition_tissus;
                                id_composition_tissus.value = country.id;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!composition.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var familleTissu = document.getElementById('familleTissu');
        var id_famille_tissus = document.getElementById('id_famille_tissus');
        var suggestionsList = document.getElementById('suggestionsListFamilleTissu');

        familleTissu.addEventListener('input', function() {
            var query = familleTissu.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('rechercheFamilleTissu') }}?familleTissu=' + encodeURIComponent(
                query), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var countries = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (countries.length > 0) {
                        countries.forEach(function(country) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = country.famille_tissus;
                            li.addEventListener('click', function() {
                                familleTissu.value = country.famille_tissus;
                                id_famille_tissus.value = country.id;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!familleTissu.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
