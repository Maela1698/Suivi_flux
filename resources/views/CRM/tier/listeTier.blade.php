@include('CRM.header')
@include('CRM.sidebar')

<style>
    #suggestionsList {
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
    #suggestionsListTiers {
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
<style>
    .entete {

        color: #7571f9; /* Ajuster la couleur du texte si n�cessaire */
    }
    .card-small {
        height: 110px; /* Ajustez cette valeur selon vos besoins */
        padding: 10px;
    }

    .card-small .card-title {
        font-size: 1.3rem; /* Taille de la police du titre */
    }

    .card-small h2 {
        font-size: 2rem; /* Taille de la police du chiffre */
    }

    .card-small .display-5 {
        font-size: 2.2rem; /* Taille de l'ic�ne */
        opacity: 0.5; /* Garder l'opacit� comme avant */
    }


    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        transform: translate3d(0, 0, 0);
        will-change: transform;
        display: none;
    }

    .texte {
        color: black;
    }

</style>

<style>
    .table th {
    color: #000000; /* Couleur noire intense */
    font-weight: bold; /* Optionnel : Rend le texte plus épais */
    }
    .table td {
    color: #828282; /* Couleur noire intense */
    font-weight: bold; /* Optionnel : Rend le texte plus épais */
    }
</style>
   <!--**********************************
            Content body start
        ***********************************-->

        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                @include('CRM.headerCrm')
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1 card-small" style="border-radius: 28px 3px 28px 3px;">
                            <div class="card-body mb-5" style="margin-top: -10px;margin-left: 10px;">
                                <h3 class="card-title text-white" style="margin-bottom: 5px;">TIERS</h3>
                                <div class="d-inline-block mb-5">
                                    <h2 class="text-white">{{ $tierscount }}</h2>
                                </div>
                                <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-users" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2 card-small" style="border-radius: 28px 3px 28px 3px;">
                            <div class="card-body mb-5" style="margin-top: -10px;margin-left: 10px;">
                                <h3 class="card-title text-white" style="margin-bottom: 5px;">CLIENTS</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">{{ $tiersclient }}</h2>
                                </div>
                                <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-user-check" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3 card-small" style="border-radius: 28px 3px 28px 3px;">
                            <div class="card-body mb-5" style="margin-top: -10px;margin-left: 10px;">
                                <h3 class="card-title text-white" style="margin-bottom: 5px;">FOURNISSEURS</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">{{ $tiersfournisseur }}</h2>
                                </div>
                                <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-truck" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-5 card-small" style="border-radius: 28px 3px 28px 3px;">
                            <div class="card-body mb-5" style="margin-top: -10px;margin-left: 10px;">
                                <h3 class="card-title text-white" style="margin-bottom: 5px;">PROSPECTS</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">{{ $tiersprospect }}</h2>
                                </div>
                                <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-user-plus" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                @include('CRM.reglage')
                <div class="col-lg-12">
                    <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                        <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                            <h3  class="entete">LISTES DES TIERS</h3>
                        <form action="{{ route('CRM.ajoutTier') }}" method="get">
                            @csrf
                            <button class="btn btn-primary" style="margin-right: 15px;">Ajouter</button>
                        </form>
                        </div>
                        <div class="card-body" style="margin-top: -15px;">
                            <form action="{{ route('CRM.accueil') }}" method="get" autocomplete="off">
                                @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" id="nomTiers" class="form-control" placeholder="Nom" value="{{ $nomTiers }}" oninput="syncHiddenField('nomTiers', 'idTiers')">
                                        <input type="hidden" id="idTiers" name="idTiers" value="{{ request()->idTiers }}">
                                        <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" id="nomPays" class="form-control" placeholder="Entrez un nom de pays" value="{{ $nomPays }}" oninput="syncHiddenField('nomPays', 'idPays')">
                                        <input type="hidden" id="idPays" class="form-control" name="idPays" value="{{ request()->idPays }}">
                                        <ul id="suggestionsList" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" name="idEtat" value="{{ request()->idEtat }}">
                                            <option value="">Etat</option>
                                            @foreach ( $etat as $e)
                                            <option value="{{ $e->id }}"
                                                {{ (old('idEtat') ?? request()->idEtat) == $e->id ? 'selected' : '' }}>
                                                {{ $e->etattiers }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" name="idActeur">
                                            <option value="">Acteur</option>
                                            @foreach ($acteur as $a)
                                                <option value="{{ $a->id }}"
                                                    {{ (old('idActeur') ?? request()->idActeur) == $a->id ? 'selected' : '' }}>
                                                    {{ $a->acteur }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="autre" placeholder="Autres" value="{{ request()->autre }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group" id="date-range">
                                        <input type="date" class="form-control" name="start" value="{{ request()->start }}">
                                        <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                        <input type="date" class="form-control" name="end" value="{{ request()->end }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success">Filtrer</button>
                                </div>
                            </div>
                            </form>
                            <br>
                            <br>

                                    <div class="table-responsive" style="margin-top: -15px;">
                                        <table class="table student-data-table m-t-20 table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date Entree</th>
                                                    <th>Nom Tier</th>
                                                    <th>Nature</th>
                                                    <th>Pays</th>
                                                    <th>Tel</th>
                                                    <th>Email Client</th>
                                                    <th>Etat</th>
                                                </tr>
                                            </thead>
                                            <tbody style="cursor: pointer;">
                                                @foreach($tierss as $t)
                                                <tr onclick="window.location.href = '{{ route('CRM.detailTier', ['idTier' => $t->id_tier]) }}';" style="cursor: pointer;">
                                                    <td>{{ \Carbon\Carbon::parse($t->dateentree)->locale('fr')->translatedFormat('j/m/y') }}</td>
                                                    <td>{{ $t->nomtier }}</td>
                                                    <td>{{ $t->acteur }}</td>
                                                    <td>{{ $t->pays }}</td>
                                                    <td>{{ $t->numphone }}</td>
                                                    <td>{{ $t->emailtier }}</td>
                                                    <td>{{ $t->etat }}</td>
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
    document.addEventListener('DOMContentLoaded', function () {
        var nomPays = document.getElementById('nomPays');
        var idPays = document.getElementById('idPays');
        var suggestionsList = document.getElementById('suggestionsList');

        nomPays.addEventListener('input', function () {
            var query = nomPays.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("recherche-pays") }}?nomPays=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var countries = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (countries.length > 0) {
                        countries.forEach(function (country) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = country.nom_fr_fr;
                            li.addEventListener('click', function () {
                                nomPays.value = country.nom_fr_fr;
                                idPays.value = country.id;
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
            if (!nomPays.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nomTiers = document.getElementById('nomTiers');
        var idTiers = document.getElementById('idTiers');
        var suggestionsListTiers = document.getElementById('suggestionsListTiers');

        nomTiers.addEventListener('input', function () {
            var query = nomTiers.value;

            if (query.length < 1) {
                suggestionsListTiers.style.display = 'none';
                return;
            }

            var xhr1 = new XMLHttpRequest();
            xhr1.open('GET', '{{ route("recherche-tiers") }}?nomTiers=' + encodeURIComponent(query), true);
            xhr1.onload = function () {
                if (xhr1.status === 200) {
                    var tiers = JSON.parse(xhr1.responseText);
                    suggestionsListTiers.innerHTML = '';
                    if (tiers.length > 0) {
                        tiers.forEach(function (tier) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = tier.nomtier;
                            li.addEventListener('click', function () {
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

        document.addEventListener('click', function (event) {
            if (!nomTiers.contains(event.target) && !suggestionsListTiers.contains(event.target)) {
                suggestionsListTiers.style.display = 'none';
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
