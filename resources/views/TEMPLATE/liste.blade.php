@include('CRM.header')
@include('CRM.sidebar')
<title>Liste</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .table th {
        color: #000000;
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }

    .table td {
        color: #828282;
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }

    #suggestionsListSaison {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }

    #suggestionsListTiers {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }

    #suggestionsListStyle {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }


    #suggestionsListStade {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
            <div class="col-lg-4 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Nbr Commande</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">0</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-list"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #4568dc, #b06ab3);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantite commande</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">0</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-handshake"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Nego</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">0</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-check-circle"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="card col-12">

                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">LISTE</h3>
                </div>

                <form action="" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-1">
                            <div class="input-group">
                                <input type="text" id="nomSaison" name="nomSaison" class="form-control"
                                    placeholder="Saison" value="">
                                <input type="hidden" id="idSaison" name="idSaison" value="">
                                <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="modele" name="modele" class="form-control"
                                    placeholder="Modele" value="">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomTiers" name="nomTiers" class="form-control"
                                    placeholder="Nom Client" value="">
                                <input type="hidden" id="idTiers" name="idTiers" value="">
                                <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="input-group">
                                <input type="text" id="nomStyle" name="nomStyle" class="form-control"
                                    placeholder="Style" value="">
                                <input type="hidden" id="idStyle" name="idStyle" value="">
                                <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>

                        <div class="col-2">

                            <select class="form-control" name="etatDemande">
                                <option value="">Etat</option>
                                <option value="">Etat2</option>
                                <option value="">Etat3</option>
                            </select>

                        </div>

                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomStade" name="nomStade" class="form-control"
                                    placeholder="Stade" value="">
                                <input type="hidden" id="idStade" name="idStade" value="">
                                <ul id="suggestionsListStade" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="dateDebut"
                                    value="">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="dateFin" value="">
                            </div>
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-9">
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                        </div>
                    </div>

                </form>

                <div class="table-responsive" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>Date entrée</th>
                                <th>Saison</th>
                                <th>Client</th>
                                <th>Type</th>
                                <th>Modèle</th>
                                <th>Qte previsionnel</th>
                                <th>Stade</th>
                                <th>Etat</th>
                                <th>Style</th>
                                <th>TotalDejaInspecter</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">

                        </tbody>
                    </table>
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
{{--  saison  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomSaison');
        var idSaison = document.getElementById('idSaison');
        var suggestionsList = document.getElementById('suggestionsListSaison');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-saison') }}?nomSaison=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.type_saison;
                            li.addEventListener('click', function() {
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

        document.addEventListener('click', function(event) {
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

{{--  tiers  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomTiers = document.getElementById('nomTiers');
        var idTiers = document.getElementById('idTiers');
        var suggestionsListTiers = document.getElementById('suggestionsListTiers');

        nomTiers.addEventListener('input', function() {
            var query = nomTiers.value;

            if (query.length < 1) {
                suggestionsListTiers.style.display = 'none';
                return;
            }

            var xhr1 = new XMLHttpRequest();
            xhr1.open('GET', '{{ route('recherche-tiers-demande') }}?nomTiers=' + encodeURIComponent(
                query), true);
            xhr1.onload = function() {
                if (xhr1.status === 200) {
                    var tiers = JSON.parse(xhr1.responseText);
                    suggestionsListTiers.innerHTML = '';
                    if (tiers.length > 0) {
                        tiers.forEach(function(tier) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = tier.nomtier;
                            li.addEventListener('click', function() {
                                nomTiers.value = tier.nomtier;
                                idTiers.value = tier.id;
                                suggestionsListTiers.style.display = 'none';
                            });
                            suggestionsListTiers.appendChild(li);
                        });
                        suggestionsListTiers.style.display = 'block';
                    } else {
                        suggestionsListTiers.style.display = 'none';
                    }
                }
            };
            xhr1.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomTiers.contains(event.target) && !suggestionsListTiers.contains(event.target)) {
                suggestionsListTiers.style.display = 'none';
            }
        });
    });
</script>



{{--  style  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomStyle');
        var idSaison = document.getElementById('idStyle');
        var suggestionsList = document.getElementById('suggestionsListStyle');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-style') }}?nomStyle=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.nom_style;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.nom_style;
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

        document.addEventListener('click', function(event) {
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

{{--  stade  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomStade');
        var idSaison = document.getElementById('idStade');
        var suggestionsList = document.getElementById('suggestionsListStade');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('DEV.rechercheStade') }}?type_stade=' + encodeURIComponent(
                    query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.type_stade;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.type_stade;
                                idSaison.value = saison.type_stade;
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
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
