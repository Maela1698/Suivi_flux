@include('CRM.header')
@include('CRM.sidebar')
   <!--**********************************
            Content body start
        ***********************************-->
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
                max-height: 300px;
                overflow-y: auto;
                overflow-x: hidden;
                z-index: 1050;
            }

            .texte {
                color: black;
            }
            .content-body {
                background: linear-gradient(to bottom, #66ccff, #d4a373);
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
            #suggestionsListMerch {
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
    .table th {
        color: #000000; /* Couleur noire intense */
        font-weight: bold; /* Optionnel : Rend le texte plus épais */
    }
    .table td {
        color: #828282; /* Couleur noire intense */
        font-weight: bold; /* Optionnel : Rend le texte plus épais */
    }
</style>


        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                @include('Planning.headerPlan')
                <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
                    <div class="col-lg-3 col-sm-4">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Nbr Commande</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);"> {{ number_format($sumnbcommande[0]->sum_nb_commande,0,' ',' ')}} commande(s)</h2>
                                        {{-- <td>{{ $obj->tauxconfirmation ? number_format($obj->tauxconfirmation, 2) : '0' }} %</td> --}}
                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-list" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #4568dc, #b06ab3);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Objectif</h3>
                                    <div class="d-inline-block">
                                        {{-- <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($sumobjectif[0]->sum,0,' ',' ') }} pièces</h2> --}}
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($sumobjectif[0]->total_target_saison,0,' ',' ') }} pièces</h2>

                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-handshake" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #43cea2, #185a9d);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Qté Confirmé</h3>
                                    <div class="d-inline-block">
                                        {{-- <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($sumConfirmed[0]->total_qte_provisoire,0,' ',' ') }} pièces</h2> --}}
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($sumConfirmed[0]->total_confirmee,0,' ',' ') }} pièces</h2>


                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-check-circle" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #f3904f, #3b4371);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Taux Confirmé</h3>
                                    <div class="d-inline-block">
                                        {{-- <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{$moyenne}} %</h2> --}}
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($moyenne, 2) }} %</h2>
                                        {{-- <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{$moyenne, 2}} %</h2> --}}
                                        {{-- <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($moyenne, 2) }} %</h2> --}}


                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-times-circle" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                </br>
                @include('CRM.reglage')
                <div class="col-lg-12">
                    <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                        <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                                <h3  class="entete">OBJECTIF PAR SAISON</h3>

                                <a href="/LRP/ajouterobjectifSaison">
                                    <button class="btn btn-primary" style="margin-right: 15px;">Ajouter</button>
                                </a>

                        </div>
                        <div class="card-body" style="margin-top: -15px;">
                            <form action="{{ route('LRP.objectifSaison') }}" method="GET" autocomplete="off">
                                @csrf
                            <div class="row">
                                <div class="col-md-2 col-lg-2">
                                    <div class="input-group">
                                        <input type="text" id="nomSaison" class="form-control" placeholder="Saison" >
                                        <input type="hidden" id="idsaison" name="idsaison" >
                                        <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <div class="input-group">
                                        {{-- <input type="text" id="nomTiers" class="form-control" placeholder="Client" value="{{ $nomTiers }}" oninput="syncHiddenField('nomTiers', 'id_tier')"> --}}
                                        <input type="text" id="nomTiers" class="form-control" placeholder="Client" >

                                        <input type="hidden" id="id_tier" name="id_tier" >
                                        <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <div class="input-group">
                                        {{-- <input type="text" class="form-control" id="nommerchsenior" placeholder="Merch" value="{{ $merchsenior }}" oninput="syncHiddenField('nommerchsenior','merchsenior')"> --}}
                                        <input type="text" class="form-control" id="nommerchsenior" placeholder="Merch" >
                                        <input type="hidden" id="merchsenior" name="merchsenior" >
                                        <ul id="suggestionsListMerch" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>

                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <select class="form-control" name="etat">
                                            <option>Etat</option>
                                            <option>Atteint</option>
                                            <option>Non Atteint</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success" type="submit">Filtrer</button>
                                </div>
                            </form>
                            </div>

                            <div class="table-responsive"  style="margin-top: -15px;">
                                <table class="table student-data-table m-t-20 table-hover">
                                    <thead>
                                        <tr>
                                            <th>Merch</th>
                                            <th>Saison</th>
                                            <th>Client</th>
                                            <th>Nb Commande</th>
                                            <th>Objectif</th>
                                            <th>Qté Confirmé</th>
                                            <th>Qté En-cours Nego</th>
                                            <th>Taux Confirmé</th>
                                        </tr>
                                    </thead>
                                    @foreach ($objectif as $obj)
                                    <tr onclick="window.location.href = '{{ route('LRP.detailobjectifSaison', ['id_tier' => $obj->id_tier, 'id_saison' => $obj->idsaison]) }}';" style="cursor: pointer;">
                                        <td>{{ $obj->merchsenior ?? '0' }}</td>
                                        <td>{{ $obj->type_saison ?? '0' }}</td>
                                        <td>{{ $obj->nomtier ?? '0' }}</td>
                                        <td>{{ $obj->nb_commandes ? number_format($obj->nb_commandes,0,' ',' ') : '0' }}</td>
                                        <td>{{ $obj->targetsaison ? number_format($obj->targetsaison,0,' ',' ') : '0' }}</td>
                                        <td>{{ $obj->total_qte_confirmee ?? '0' }}</td>
                                        <td>{{ $obj->total_qte_encours_nego ?? '0' }}</td>
                                        <td>{{ $obj->tauxconfirmation ? number_format($obj->tauxconfirmation, 2) : '0' }} %</td>
                                        {{-- <td>{{$obj->tauxconfirmation }} %</td> --}}
                                    </tr>
                                @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nomTiers = document.getElementById('nomTiers');
        var id_tier = document.getElementById('id_tier');
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
                                id_tier.value = tier.id;
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
    document.addEventListener('DOMContentLoaded', function () {
        var nomSaison = document.getElementById('nomSaison');
        var idsaison = document.getElementById('idsaison');
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
                                idsaison.value = saison.id;
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
        var nommerchsenior = document.getElementById('nommerchsenior');
        var merchsenior = document.getElementById('merchsenior');
        var suggestionsListMerch = document.getElementById('suggestionsListMerch');

        nommerchsenior.addEventListener('input', function () {
            var query = nommerchsenior.value;

            if (query.length < 1) {
                suggestionsListMerch.style.display = 'none';
                return;
            }

            var xhr11 = new XMLHttpRequest();
            xhr11.open('GET', '{{ route("LRP.recherche-merchsenior") }}?merchsenior=' + encodeURIComponent(query), true);
            xhr11.onload = function () {
                if (xhr11.status === 200) {
                    var merch = JSON.parse(xhr11.responseText);
                    suggestionsListMerch.innerHTML = '';
                    if (merch.length > 0) {
                        merch.forEach(function(merchs) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = merchs.merchsenior;
                            li.addEventListener('click', function () {
                                nommerchsenior.value = merchs.merchsenior;
                                merchsenior.value = merchs.merchsenior;
                                suggestionsListMerch.style.display = 'none';
                            });
                            suggestionsListMerch.appendChild(li);
                        });
                        suggestionsListMerch.style.display = 'block';
                    } else {
                        suggestionsListMerch.style.display = 'none';
                    }
                }
            };
            xhr11.send();
        });

        document.addEventListener('click', function (event) {
            if (!nommerchsenior.contains(event.target) && !suggestionsListMerch.contains(event.target)) {
                suggestionsListMerch.style.display = 'none';
            }
        });
    });
</script>
<script>
    function syncHiddenField(textInputId, hiddenInputId) {
        const textInput = document.getElementById(textInputId);
        const hiddenInput = document.getElementById(hiddenInputId);

        if (textInput.value.trim() === '') {
            hiddenInput.value = '';
        }
    }
</script>
@include('CRM.footer')
