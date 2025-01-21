@include('CRM.header')
@include('CRM.sidebar')

<!--**********************************
        Content body start
***********************************-->
<style>
    .form-control{
        border: 1px solid #b5b5b5;
    }
    label {
        color: #767575;
    }
</style>
<title>AjoutDemandeClient</title>
<style>
    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
    }
    .checkbox-item {
        flex: 0 0 23%; /* Répartir en quatre colonnes */
        margin: 1%; /* Espacement entre les checkboxes */
        box-sizing: border-box; /* Inclure les marges dans la taille totale */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
    }
    .checkbox-item input[type="checkbox"] {
        margin-right: 10px; /* Espacement entre le checkbox et le texte */
    }
    .checkbox-item label {
        margin: 0; /* Réinitialiser les marges du label */
    }
    .checkbox-item:hover {
        background-color: #e6f7ff;
        border-color: #007bff;
    }
    .requete{
        height:  100px;
    }
    #suggestionsListClient {
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%; /* Place la liste juste en dessous du champ */
    left: 0; /* Aligne la liste avec le champ */
    }
    #suggestionsListSaison {
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%; /* Place la liste juste en dessous du champ */
    left: 0; /* Aligne la liste avec le champ */
    }
    #suggestionsListStyle {
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%; /* Place la liste juste en dessous du champ */
    left: 0; /* Aligne la liste avec le champ */
    }
    #suggestionsListUniteBase {
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%; /* Place la liste juste en dessous du champ */
    left: 0; /* Aligne la liste avec le champ */
    }
    #suggestionsListUniteMin {
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%; /* Place la liste juste en dessous du champ */
    left: 0; /* Aligne la liste avec le champ */
    }
    #suggestionsListUniteMax {
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%; /* Place la liste juste en dessous du champ */
    left: 0; /* Aligne la liste avec le champ */
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="card col-12">
            <div class="card-header d-flex justify-content-between align-items-center entete">
                <h3 class="entete">AJOUT DEMANDE CLIENT</h3>
            </div>

            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('CRM.nouveauDemande') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Date entrée </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="date" class="form-control" name="date_entree" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >ETD(Estimated Time Departure) </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="date" class="form-control" name="date_livraison" required>
                                    </div>
                                </div>
                            </div>
                            {{--  <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Certification </label>
                                    </div>
                                    <div class="col-12">
                                        <select class="form-control" name="certification" required>
                                            @for ($cer=0; $cer<count($certification); $cer++)
                                                <option value="{{ $certification[$cer]->id }}">{{ $certification[$cer]->certification }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>  --}}
                        </div>

                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Nom client </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="nomClient" class="form-control" placeholder="Nom client" required>
                                        <input type="hidden" id="idClient" class="form-control" name="nomClient" >
                                        <ul id="suggestionsListClient" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Nom du modèle </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="nom_modele">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Thème </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="theme">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Designation </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="nomStyle" class="form-control" placeholder="Designation" required>
                                        <input type="hidden" id="idStyle" class="form-control" name="idStyle" >
                                        <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Saison </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="nomSaison" class="form-control" placeholder="Saison" required>
                                        <input type="hidden" id="idSaison" class="form-control" name="idSaison" >
                                        <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Periode </label>
                                    </div>
                                    <div class="col-12">
                                        <select class="form-control"  name="periode" required>
                                            <option value="">Periode</option>
                                            @foreach($periode as $pe)
                                            <option value="{{ $pe->id }}">{{ $pe->periode }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Phase </label>
                                    </div>
                                    <div class="col-12">
                                        <select class="form-control"  name="phase" required>
                                            <option value="">Phase</option>
                                            @foreach($phase as $p)
                                            <option value="{{ $p->id }}">{{ $p->type_phase }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Incontern </label>
                                    </div>
                                    <div class="col-12">
                                        <select class="form-control"  name="incontern"  required>
                                            <option value="">Incontern</option>
                                            @foreach($incontern as $i)
                                            <option value="{{ $i->id }}">{{ $i->type_incontern }}</option>
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
                                        <label class="col-form-label">Lavage</label>
                                    </div>
                                    <div class="col-12 checkbox-container">
                                        @foreach($lavage as $l)
                                            <div class="checkbox-item" style="color: rgb(91, 89, 89);">
                                                <input type="checkbox" value="{{ $l->id }}" name="lavages[]">{{ $l->type_lavage }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-12">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Valeur ajoutée</label>
                                    </div>
                                    <div class="col-12 checkbox-container">
                                        @foreach($valeurajoute as $v)
                                            <div class="checkbox-item" style="color: rgb(91, 89, 89);">
                                                <input type="checkbox" value="{{ $v->id }}" name="valeurAjoutes[]">{{ $v->type_valeur_ajoutee }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Quantité prévisionnel </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="number"  class="form-control"  name="qteProvisoire" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Taille min </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="uniteTailleMin" class="form-control" placeholder="Taille min" required>
                                        <input type="hidden" id="idUniteTailleMin" class="form-control" name="uniteTailleMin" >
                                        <ul id="suggestionsListUniteMin" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Taille max </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="uniteTailleMax" class="form-control" placeholder="Taille max" required>
                                        <input type="hidden" id="idUniteTailleMax" class="form-control" name="uniteTailleMax" >
                                        <ul id="suggestionsListUniteMax" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Taille de base </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="uniteTailleBase" class="form-control" placeholder="Taille de base" required>
                                        <input type="hidden" id="idUniteTailleBase" class="form-control" name="tailleBase" >
                                        <ul id="suggestionsListUniteBase" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Requête client </label>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control requete" name="requeteClient" rows="4" cols="50"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Commentaire merch </label>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control requete" name="commentaireMerch" rows="4" cols="50"></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Image demande </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="file"  class="form-control" name="photo_commande">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Nom du DT </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="nomDT" placeholder="Nom modele_Stade">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Fichier du DT </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="file" class="form-control"  name="ficheDT">
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


<!--**********************************
        modal start
***********************************-->

<!--**********************************
        modal end
***********************************-->

<!--**********************************
        javascript start
***********************************-->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nomClient = document.getElementById('nomClient');
        var idClient = document.getElementById('idClient');
        var suggestionsList = document.getElementById('suggestionsListClient');

        nomClient.addEventListener('input', function () {
            var query = nomClient.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("recherche-client-demande") }}?nomClient=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var clients = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (clients.length > 0) {
                        clients.forEach(function (client) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = client.nomtier;
                            li.addEventListener('click', function () {
                                nomClient.value = client.nomtier;
                                idClient.value = client.id;
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

        document.addEventListener('click', function (event) {
            if (!nomClient.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nomSaison = document.getElementById('nomSaison');
        var idSaison = document.getElementById('idSaison');
        var suggestionsList = document.getElementById('suggestionsListSaison');

        nomSaison.addEventListener('input', function () {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("recherche-saison") }}?nomSaison=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function (saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.type_saison;
                            li.addEventListener('click', function () {
                                nomSaison.value = saison.type_saison;
                                idSaison.value = saison.id;
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

        document.addEventListener('click', function (event) {
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nomStyle = document.getElementById('nomStyle');
        var idStyle = document.getElementById('idStyle');
        var suggestionsList = document.getElementById('suggestionsListStyle');

        nomStyle.addEventListener('input', function () {
            var query = nomStyle.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("recherche-style") }}?nomStyle=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var styles = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (styles.length > 0) {
                        styles.forEach(function (style) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = style.nom_style;
                            li.addEventListener('click', function () {
                                nomStyle.value = style.nom_style;
                                idStyle.value = style.id;
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

        document.addEventListener('click', function (event) {
            if (!nomStyle.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var uniteTailleMin = document.getElementById('uniteTailleMin');
        var idUniteTailleMin = document.getElementById('idUniteTailleMin');
        var suggestionsList = document.getElementById('suggestionsListUniteMin');

        uniteTailleMin.addEventListener('input', function () {
            var query = uniteTailleMin.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("recherche-unite-taille-min") }}?nomUnite=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var unites = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (unites.length > 0) {
                        unites.forEach(function (unite) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = unite.unite_taille;
                            li.addEventListener('click', function () {
                                uniteTailleMin.value = unite.unite_taille;
                                idUniteTailleMin.value = unite.id;
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

        document.addEventListener('click', function (event) {
            if (!uniteTailleMin.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var uniteTailleMax = document.getElementById('uniteTailleMax');
        var idUniteTailleMax = document.getElementById('idUniteTailleMax');
        var suggestionsList = document.getElementById('suggestionsListUniteMax');

        uniteTailleMax.addEventListener('input', function () {
            var query = uniteTailleMax.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("recherche-unite-taille-max") }}?nomUnite=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var unites = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (unites.length > 0) {
                        unites.forEach(function (unite) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = unite.unite_taille;
                            li.addEventListener('click', function () {
                                uniteTailleMax.value = unite.unite_taille;
                                idUniteTailleMax.value = unite.id;
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

        document.addEventListener('click', function (event) {
            if (!uniteTailleMax.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var uniteTailleBase = document.getElementById('uniteTailleBase');
        var idUniteTailleBase = document.getElementById('idUniteTailleBase');
        var suggestionsList = document.getElementById('suggestionsListUniteBase');

        uniteTailleBase.addEventListener('input', function () {
            var query = uniteTailleBase.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("recherche-unite-taille-base") }}?nomUnite=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var unites = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (unites.length > 0) {
                        unites.forEach(function (unite) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = unite.unite_taille;
                            li.addEventListener('click', function () {
                                uniteTailleBase.value = unite.unite_taille;
                                idUniteTailleBase.value = unite.unite_taille;
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

        document.addEventListener('click', function (event) {
            if (!uniteTailleBase.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
