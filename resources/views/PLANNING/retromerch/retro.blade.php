@include('CRM.header')
@include('CRM.sidebar')
<!--**********************************
            Content body start
        ***********************************-->
<style>

    .entete {

        color: #7571f9;
        /* Ajuster la couleur du texte si n�cessaire */
    }

    .card-small {
        height: 110px;
        /* Ajustez cette valeur selon vos besoins */
        padding: 10px;
    }

    .card-small .card-title {
        font-size: 1.3rem;
        /* Taille de la police du titre */
    }

    .card-small h2 {
        font-size: 2rem;
        /* Taille de la police du chiffre */
    }

    .card-small .display-5 {
        font-size: 2.2rem;
        /* Taille de l'ic�ne */
        opacity: 0.5;
        /* Garder l'opacit� comme avant */
    }


    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 1050;
    }

    .texte {
        color: black;
    }

    .content-body {
        background-color: #0C275E;
    }
</style>

<style>
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
</style>

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1 card-small" style="border-radius: 28px 3px 28px 3px; background: linear-gradient(135deg, #6A82FB 0%, #FC5C7D 100%);">
                    <div class="card-body mb-5" style="margin-top: -10px;margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">MP Non Dispo</h3>
                        <div class="d-inline-block mb-5">
                            <h2 class="text-white">{{ $nondispo }}</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-exclamation-circle" style="color: white;"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2 card-small" style="border-radius: 28px 3px 28px 3px; background: linear-gradient(135deg, #56CCF2 0%, #2F80ED 100%);">
                    <div class="card-body mb-5" style="margin-top: -10px;margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Attente SDC</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $envoiesdc }}</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-clock" style="color: white;"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-5 card-small" style="border-radius: 28px 3px 28px 3px; background: linear-gradient(135deg, #F7971E 0%, #FFD200 100%);">
                    <div class="card-body mb-5" style="margin-top: -10px;margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">Retard</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $retard }}</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-hourglass-half" style="color: white;"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-3 card-small" style="border-radius: 28px 3px 28px 3px; background: linear-gradient(135deg, #43E97B 0%, #38F9D7 100%);">
                    <div class="card-body mb-5" style="margin-top: -10px;margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">OK Prod</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $okprod }}</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-check-circle" style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">RETRO MERCH DEV</h3>
                </div>
                <div class="card-body" style="margin-top: -15px;">
                    <form action="{{ route('PLANNING.retro') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" id="nomSaison" class="form-control" placeholder="saison" oninput="syncHiddenField('nomSaison', 'idSaison')">
                                    <input type="hidden" id="idSaison" name="idSaison">
                                    <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" id="nomTiers" class="form-control" placeholder="Client" oninput="syncHiddenField('nomTiers', 'idTiers')">
                                    <input type="hidden" id="idTiers" name="idTiers">
                                    <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="modele" placeholder="Modèle">
                                </div>
                            </div>

                            <div class="col-md-2 col-lg-2">
                                <div class="form-group">
                                    <select class="form-control" name="etatretro">
                                        <option value="">Etat</option>
                                        @foreach($etatretro as $e)
                                            <option value="{{ $e->id }}">{{ $e->etatretromerch }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" id="nomStyle" class="form-control" placeholder="style"  oninput="syncHiddenField('nomStyle', 'idStyle')">
                                    <input type="hidden" id="idStyle" name="idStyle" >
                                    <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;"></ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="form-group">
                                    <select class="form-control" name="stade">
                                        <option value="">Stade</option>
                                        @foreach($stade as $s)
                                            <option value="{{ $s->id }}">{{ $s->type_stade }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="start">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="end">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-success">Filtrer</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <br>
                    <div class="table-responsive" style="margin-top: -15px;">
                        <table class="table student-data-table m-t-20 table-hover">
                            <thead>
                                <tr>
                                    <th>Saison</th>
                                    <th>Date Réception</th>
                                    <th>Client</th>
                                    <th>Modèle</th>
                                    <th>Thème</th>
                                    <th>Style</th>
                                    <th>Stade</th>
                                    <th>Quantité A Monter</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($demandes as $d)
                                <tr onclick="window.location.href = '{{ route('PLANNING.detailRetro', ['idDemande' => $d->demande_id,'dateentree' => $d->demande_date_entree, 'okprodinitial' => $d->ok_prod_initial]) }}';" style="cursor: pointer;">
                                    <td>{{ $d->type_saison }}</td>
                                    <td>{{ $d->demande_date_entree }}</td>
                                    <td>{{ $d->nomtier }}</td>
                                    <td>{{ $d->nom_modele }}</td>
                                    <td>{{ $d->theme }}</td>
                                    <td>{{ $d->nom_style }}</td>
                                    <td>{{ $d->type_stade }}</td>
                                    @if($d->total_qte_detailsdc>0)
                                        <td>{{ $d->total_qte_detailsdc }}</td>
                                        @else
                                        <td>{{ $d->etape_quantite }}</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--**********************************
            Content body end
        ***********************************-->
<script>
    document.querySelectorAll('.column-toggle').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var column = this.getAttribute('data-column');
            var table = document.querySelector('.student-data-table');
            var rows = table.querySelectorAll('tr');

            rows.forEach(function(row) {
                row.querySelectorAll('td, th')[column].style.display = checkbox.checked ? '' :
                    'none';
            });
        });
    });

    // Masquer les colonnes qui ne sont pas cochées par défaut
    document.querySelectorAll('.column-toggle').forEach(function(checkbox) {
        var column = checkbox.getAttribute('data-column');
        var table = document.querySelector('.student-data-table');
        var rows = table.querySelectorAll('tr');

        if (!checkbox.checked) {
            rows.forEach(function(row) {
                row.querySelectorAll('td, th')[column].style.display = 'none';
            });
        }
    });
</script>


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
    function syncHiddenField(textInputId, hiddenInputId) {
        const textInput = document.getElementById(textInputId);
        const hiddenInput = document.getElementById(hiddenInputId);

        if (textInput.value.trim() === '') {
            hiddenInput.value = ''; // Clear the hidden field if the text input is empty
        }
    }
</script>

@include('CRM.footer')
