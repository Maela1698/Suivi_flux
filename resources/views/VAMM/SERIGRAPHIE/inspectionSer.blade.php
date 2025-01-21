@include('CRM.header')
@include('CRM.sidebar')
<title>InspectionSerigraphie</title>

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

    #suggestionsListEmploye {
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
        @include('VAMM.headerVAMM')

        <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
            <div class="col-lg-4 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                PiecesProduites</h3>
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
                                QuantiteInspectés</h3>
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
                                ModeleInspecté</h3>
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

        <div class="row" style="margin-top: 0;">
            <div class="col-lg-4 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                TauxRejet</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">0</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #16a085, #f4d03f);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                PourcentageDefaut</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">0</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-file-alt"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="card col-12">

                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">INSPECTION SERIGRAPHIE</h3>
                </div>

                <form action="{{ route('SERIGRAPHIE.listeInspectionSerigraphie') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="dateDebut"
                                    value="{{ $dateDebut }}">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="dateFin"
                                    value="{{ $dateFin }}">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group">
                                <input type="text" id="nomSaison" name="nomSaison" class="form-control"
                                    placeholder="Saison" value="{{ $nomSaison }}">
                                <input type="hidden" id="idSaison" name="idSaison" value="{{ $idSaison }}">
                                <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group">
                                <input type="text" id="modele" name="modele" class="form-control"
                                    placeholder="Modele" value="{{ $modele }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomTiers" name="nomTiers" class="form-control"
                                    placeholder="Nom Client" value="{{ $nomTiers }}">
                                <input type="hidden" id="idTiers" name="idTiers" value="{{ $idTiers }}">
                                <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>

                        <div class="col-1">
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                        </div>


                    </div>

                </form>

                <div class="table-responsive mt-4" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>Date inspection</th>
                                <th>Saison</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Qte previsionnel</th>
                                <th>Stade</th>
                                <th>Style</th>
                                <th>Nombre Inspecter</th>
                                <th>Taux rejet</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody >
                            @for ($i = 0; $i < count($inspection); $i++)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($inspection[$i]->date_inspection)->format('d/m/y') }}</td>
                                    <td>{{ $inspection[$i]->type_saison }}</td>
                                    <td>{{ $inspection[$i]->nomtier }}</td>
                                    <td>{{ $inspection[$i]->nom_modele }}</td>
                                    <td>{{ $inspection[$i]->qte_commande_provisoire }}</td>
                                    <td>{{ $inspection[$i]->type_stade }}</td>
                                    <td>{{ $inspection[$i]->nom_style }}</td>
                                    <td>{{ $inspection[$i]->nombre_inspecter }}</td>
                                    <td> {{ number_format($inspection[$i]->taux_retouche, 3, '.', ' ') }}%</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-finish mt-1 btn-sm"
                                            style="width: 110px;" data-toggle="modal" data-target="#inspection"
                                            data-id="{{ $inspection[$i]->id_demande_client }}" >
                                            <i class="fas fa-search"></i> Inspection
                                        </button>
                                    </td>
                                </tr>
                            @endfor

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Modal inspection -->
        <div class="modal fade" id="inspection" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion inspection
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('SERIGRAPHIE.insertInspection') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="row">

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <input type="hidden" id="etapeIdDemande" name="iddemande">
                                            <label class="col-form-label texte">Nombre inspection</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="nombreInspection" class="form-control" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="table-responsive mt-5">
                                    <table class="table texte">
                                        <thead>
                                            <th>TypeDefaut</th>
                                            <th>Nombre</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @for ($u = 0; $u < count($typeDefaut); $u++)
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-secondary btn-finish mt-1 btn-sm" style="width: 120px">
                                                        {{ $typeDefaut[$u]->valeur }}
                                                    </button>
                                                    <input type="hidden" name="typeDefaut[]" value="{{ $typeDefaut[$u]->id }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="nombre[]" value="0"
                                                        class="form-control" readonly required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-finish mt-1 btn-sm">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
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

{{--  employe  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('heeyyyy');
        var nomSaison = document.getElementById('nomEmploye');
        var idSaison = document.getElementById('idEmploye');
        var suggestionsList = document.getElementById('suggestionsListEmploye');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('DEV.recherchePatronier') }}?nom=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.nom + ' ' + saison.prenom;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.nom + ' ' + saison.prenom;
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gérer l'augmentation de la valeur
        document.querySelectorAll('.btn-secondary').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr'); // Trouver la rangée parente
                const input = row.querySelector('input[name="nombre[]"]');
                let value = parseInt(input.value, 10);
                input.value = value + 1; // Incrémenter la valeur
            });
        });

        // Gérer la diminution de la valeur
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr'); // Trouver la rangée parente
                const input = row.querySelector('input[name="nombre[]"]');
                let value = parseInt(input.value, 10);
                if (value > 0) {
                    input.value = value - 1; // Décrémenter la valeur si supérieur à 0
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#inspection').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            console.log(etapeId);
            var modal = $(this);
            modal.find('#etapeIdDemande').val(etapeId);
        });
    });
</script>

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
