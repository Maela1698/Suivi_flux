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
</style>

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
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Nbr Commande</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $nbrcommande }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-list"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #4568dc, #b06ab3);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                En Cour De Nego</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $nego }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-handshake"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Commande Validée</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $valide }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-check-circle"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #f3904f, #3b4371);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Commande Annulée</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $refus }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-times-circle"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 0;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                PROTO</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $proto }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #16a085, #f4d03f);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                TDS</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $tds }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-file-alt"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #82a382, #000c40);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                PPS</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $pps }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-box"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #667eea, #764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white"
                                style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">PROD</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $prod }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-industry"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>

        @include('CRM.reglage')
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">LISTES DES DEMANDES CLIENTS</h3>
                    <form action="{{ route('CRM.ajoutDemande') }}" method="get">
                        <button class="btn btn-primary" style="margin-right: 15px;">Ajouter</button>
                    </form>
                </div>
                <div class="card-body" style="margin-top: -15px;">
                    <form action="{{ route('CRM.listeDemande') }}" method="get" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="theme" placeholder="Theme"
                                        value="{{ request()->theme }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="modele" placeholder="Modele"
                                        value="{{ request()->modele }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" id="nomTiers" class="form-control" placeholder="Nom Tier"
                                        value="{{ $nomTiers }}" oninput="syncHiddenField('nomTiers', 'idTiers')">
                                    <input type="hidden" id="idTiers" name="idTiers"
                                        value="{{ request()->idTiers }}">
                                    <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="input-group">
                                    <input type="text" id="nomSaison" class="form-control"
                                        placeholder="Nom du saison" value="{{ $nomSaison }}"
                                        oninput="syncHiddenField('nomSaison', 'idSaison')">
                                    <input type="hidden" id="idSaison" name="idSaison"
                                        value="{{ request()->idSaison }}">
                                    <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="form-group">
                                    <select class="form-control" name="stade" value="{{ request()->stade }}">
                                        <option value="">Stade</option>
                                        @foreach ($stade as $s)
                                            <option value="{{ $s->id }}"
                                                {{ (old('stade') ?? request()->stade) == $s->id ? 'selected' : '' }}>
                                                {{ $s->type_stade }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="form-group">
                                    <select class="form-control" name="etat" value="{{ request()->etat }}">
                                        <option value="">Etat</option>
                                        @foreach ($etat as $et)
                                            <option value="{{ $et->id }}"
                                                {{ (old('etat') ?? request()->etat) == $et->id ? 'selected' : '' }}>
                                                {{ $et->type_etat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startEntree"
                                        value="{{ request()->startEntree }}">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="endEntree"
                                        value="{{ request()->endEntree }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group" id="date-range">
                                    <input type="date" class="form-control" name="startLivre"
                                        value="{{ request()->startLivre }}">
                                    <span class="input-group-addon b-0 text-white"
                                        style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                    <input type="date" class="form-control" name="endLivre"
                                        value="{{ request()->endLivre }}">
                                </div>
                            </div>
                            <div class="col-3 ">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="autre" placeholder="Autre"
                                        value="{{ request()->autre }}">
                                </div>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-success">Filtrer</button>
                            </div>
                            <div class="col-2">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Voir +
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="0" checked>
                                            Saison
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="1" checked>
                                            Date Entree
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="2" checked>
                                            Date de
                                            livraison
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="3" checked>
                                            Client
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="4" checked>
                                            Modèle
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="5" checked>
                                            Etat
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="6" checked>
                                            Stade
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="7" checked>
                                            Quantité
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="8">
                                            Thême
                                        </label>

                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="9"> Taille de
                                            base
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="10"> Requête
                                            client
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="11">
                                            Commentaire
                                            merch
                                        </label>

                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="12"> Style
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="13"> Phase
                                        </label>

                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="14"> Taille Min
                                        </label>
                                        <label class="dropdown-item">
                                            <input type="checkbox" class="column-toggle" data-column="15"> Taille Max
                                        </label>



                                    </div>
                                </div>
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
                                    <th>Date entrée</th>
                                    <th>Date livraison</th>
                                    <th>Client</th>
                                    <th>Modèle</th>
                                    <th>Etat</th>
                                    <th>Stade</th>
                                    <th>Quantite</th>
                                    <th>Thême</th>
                                    <th>Taille base</th>
                                    <th>Requête client</th>
                                    <th>Commentaire merch</th>
                                    <th>Style</th>
                                    <th>Phase</th>
                                    <th>Taille Min</th>
                                    <th>Taille Max</th>
                                </tr>
                            </thead>
                            <tbody style="cursor: pointer;">
                                @foreach ($demandes as $d)
                                    <tr>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->type_saison }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">
                                            {{ \Carbon\Carbon::parse($d->date_entree)->format('d/m/y') }}
                                        </td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">
                                            {{ \Carbon\Carbon::parse($d->date_livraison)->format('d/m/y') }}
                                        </td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->nomtier }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->nom_modele }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->type_etat }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->type_stade }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->qte_commande_provisoire }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->theme }}</td>

                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->taille_base }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->requete_client }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->commentaire_merch }}</td>

                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->nom_style }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->type_phase }}</td>

                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->taillemin }}</td>
                                        <td onclick="window.location.href = '{{ route('CRM.detailDemande', ['idDemande' => $d->id]) }}';"
                                            style="cursor: pointer;">{{ $d->taillemax }}</td>


                                        <td>

                                            <a href="{{ route('CRM.duplicata', ['idDemande' => $d->id]) }}"
                                                class="btn btn-secondary">Dupliquer</a>

                                        </td>
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
    function syncHiddenField(textInputId, hiddenInputId) {
        const textInput = document.getElementById(textInputId);
        const hiddenInput = document.getElementById(hiddenInputId);

        if (textInput.value.trim() === '') {
            hiddenInput.value = ''; // Clear the hidden field if the text input is empty
        }
    }
</script>
@include('CRM.footer')
