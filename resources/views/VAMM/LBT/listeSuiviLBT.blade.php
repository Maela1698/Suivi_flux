@include('CRM.header')
@include('CRM.sidebar')
<title>ListeSuiviFluxLBT</title>

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

        {{--  <div class="row" style="margin-top: 0;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Qte coupé</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qteCoupe }}</h2>
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
                                Qte reçu</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qteRecu }}</h2>
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
                                Qte livré</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qteLivre }}</h2>
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
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                En cours</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">0</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-industry"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #667eea, #764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Balance</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">0</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-industry"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>

        </div>  --}}

        <div class="row">
            <div class="card col-12">

                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">LISTE DES SUIVIS LBT</h3>
                </div>
{{--
                <form action="{{ route('SERIGRAPHIE.listeSuiviFlux') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomSaison" name="nomSaison" class="form-control" placeholder="Saison"
                                    value="{{ $nomSaison }}">
                                <input type="hidden" id="idSaison" name="idSaison" value="{{ $idSaison }}">
                                <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="modele" name="modele" class="form-control" placeholder="Modele"
                                    value="{{ $modele }}">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomTiers" name="nomTiers" class="form-control" placeholder="Nom Client"
                                    value="{{ $nomTiers }}">
                                <input type="hidden" id="idTiers" name="idTiers" value="{{ $idTiers }}">
                                <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>

                        <div class="col-2">
                            <select class="form-control" name="type">
                                @if (!empty($type))
                                    <option value="{{ $type }}">{{ $nomType }}</option>
                                @endif
                                <option value="">Type</option>
                                <option value="1">Réception</option>
                                <option value="2">Livraison</option>
                            </select>
                        </div>

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

                        <div class="col-1">
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                        </div>


                    </div>


                </form>  --}}

                <div class="table-responsive mt-4" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>Date opération</th>
                                <th>Theme</th>
                                <th>Modèle</th>
                                <th>Stade</th>
                                <th>Client</th>
                                <th>Saison</th>
                                <th>Style</th>
                                <th>Type LBT</th>
                                <th>Type flux</th>
                                <th>Quantité</th>
                                <th>Recoupe</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @for ($i = 0; $i < count($suivi); $i++)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($suivi[$i]->date_operation)->format('d/m/y H:i') }}</td>
                                    <td>{{ $suivi[$i]->theme }}</td>
                                    <td>{{ $suivi[$i]->nom_modele }}</td>
                                    <td>{{ $suivi[$i]->type_stade }}</td>
                                    <td>{{ $suivi[$i]->nomtier }}</td>
                                    <td>{{ $suivi[$i]->type_saison }}</td>
                                    <td>{{ $suivi[$i]->nom_style }}</td>
                                    <td>
                                        @if ($suivi[$i]->type_lbt == 1)
                                            Lavage
                                        @elseif($suivi[$i]->type_lbt == 2)
                                            Blanchissement
                                        @else
                                            Teinture
                                        @endif
                                    </td>
                                    <td>
                                        @if ($suivi[$i]->type_action == 1)
                                            Reception
                                        @else
                                            Livraison
                                        @endif
                                    </td>
                                    <td>
                                        @if ($suivi[$i]->type_piece == 1)
                                        {{ $suivi[$i]->quantite }} Panneau
                                        @else
                                        {{ $suivi[$i]->quantite }}  Piece
                                        @endif
                                    </td>

                                    <td>{{ $suivi[$i]->recoupe }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-finish mt-1 btn-sm" style="width: 90px;"
                                        data-toggle="modal" data-target="#suiviFlux" data-id="{{ $suivi[0]->id_demande_client }}"
                                        data-iddemande="{{ $suivi[0]->id_demande_client }}">
                                        Suivi flux
                                    </button>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>


            </div>
        </div>

        <!-- Modal insertion flux -->
        <div class="modal fade" id="suiviFlux" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion suivi flux</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('LBT.insertSuiviFluxLBT') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Date d'opération</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="datetime-local" name="dateOper" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Type pieces</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="typePiece">
                                                <option value="1">Panneau</option>
                                                <option value="2">Piece</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Type flux</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="typeFlux">
                                                <option value="1">Réception</option>
                                                <option value="2">Livraison</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Quantité</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="qte" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Type LBT</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="typeLBT">
                                                <option value="1">Lavage</option>
                                                <option value="2">Blanchissement</option>
                                                <option value="2">Teinture</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Recoupe</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="recoupe" class="form-control"
                                                required>
                                        </div>
                                    </div>
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

{{--  suivi flux  --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#suiviFlux').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            var etapeDemande = button.data('iddemande');
            var modal = $(this);
            modal.find('#etapeIdDemandeSer').val(etapeId);
            modal.find('#etapeIdDemande').val(etapeDemande);
        });
    });
</script>
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
