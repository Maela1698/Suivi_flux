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

    .content-section{
        display: none;
    }
    .content-section.active{
        display: block;
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
<style>
        .bdge1 {
        color: rgb(0, 0, 0);
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        font-size: 0.8rem;
    }

    .bdge1.badge.badge-outlined {
        background-color: transparent;
        border: 2px solid black; /* Définit la bordure */
        color: black; /* Couleur du texte */
    }
</style>

        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                @include('PLANNING.headerPlan')
                {{-- KPI --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="card-header">
                                    <h4 class="card-title">Capacites et charges mensuelles</h4>
                                    <div class="col-lg-10">
                                        <a href="{{route('LRP.listeajoutmacro')}}"><button class="btn btn-xs btn-info">Ajouter une Macro</button></a>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs">
                                    @foreach($type_macros as $type_macro)
                                        <li class="nav-item">
                                            <a href="#" id="{{ $type_macro->type_macro }}" class="nav-link @if($loop->first) active @endif"
                                               onclick="showSection('{{ $type_macro->type_macro }}')"
                                               data-value="{{ $type_macro->id_type_macro }}" name="id_type_macro">
                                               Macro {{ $type_macro->type_macro }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Année</th>
                                            <th>Mois</th>
                                            <th>Jours Ouvrables</th>
                                            <th>Effectif Total <small>(sans commando)</small></th>
                                            <th>Absence</th>
                                            <th>Efficience</th>
                                            <th>Heure Travail</th>
                                            <th>Heure Sup</th>
                                            <th>Capacité Heure</th>
                                            <th>Charge Heure</th>
                                            <th>% Charge</th>
                                            <th>Besoin en Effectif</th> <!-- Colonne unique pour BM -->
                                        </tr>
                                    </thead>
                                        <tbody id="yourTableBody">
                                            @foreach ($result as $annee => $mois_array)
                                                @foreach ($mois_array as $mois => $mois_data)
                                                    @foreach ($mois_data as $data)
                                                        <tr style="color:rgb(95, 95, 95)">
                                                            <td>{{ $data['annee'] }}</td>
                                                            <td>{{ $data['mois'] }}</td>
                                                            <td>{{ $data['jour_ouvrable'] }} j</td>
                                                            <td style="text-align: center">{{ $data['effectif_macro'] }} prs</td>
                                                            <td style="text-align: center">{{ $data['absence_macro'] }}</td>
                                                            <td style="text-align: center">{{ $data['efficience_macro'] }} %</td>
                                                            <td style="text-align: right">{{ $data['heure_t'] }} h</td>
                                                            <td style="text-align: right">{{ $data['heures_sup'] }} h</td>
                                                            <td style="text-align: right">{{ number_format($data['capacite_heure_usine'], 2, ',', ' ') }}</td>
                                                            <td style="text-align: right">{{ number_format($data['charge_heure'], 2, ',', ' ') }}</td>
                                                            @if($data['pourcentage_charge'] < 95.00)
                                                                <td style="text-align: right; color:green">{{ number_format($data['pourcentage_charge'], 2, ',', ' ') }}%</td>
                                                            @elseif($data['pourcentage_charge'] >= 98.00 && $data['pourcentage_charge'] < 110.00)
                                                                <td style="text-align: right; color:orange">{{ number_format($data['pourcentage_charge'], 2, ',', ' ') }}%</td>
                                                                {{-- <td style="text-align: right; color:orange">105%</td> --}}
                                                            @elseif($data['pourcentage_charge'] < 200.00)
                                                                <td style="text-align: right; color:red">200%</td>
                                                            @endif
                                                            <td style="text-align: right">besoin</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- KPI --}}

                @include('CRM.reglage')
                <div class="col-lg-12">
                    <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                        <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                                <h3  class="entete">DATA PLAN</h3>
                        </div>
                        <form action="{{route('LRP.listeData')}}" method="get" autocomplete="off">
                            @csrf
                            <div class="card-body" style="margin-top: -15px;">
                                {{-- filtre --}}
                                    <div class="row" style="display: flex">
                                        <div class="form-group row">
                                            <div class="col-3">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <input type="text" id="nomSaison" class="form-control" placeholder="Saison" >
                                                        <input type="hidden" id="idSaison" name="idSaison" >
                                                        <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;"></ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-3 mb-5">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <div class="input-group">
                                                            <input type="text" id="nom_client" class="form-control" placeholder="Client">
                                                            {{-- value="{{ $nom_client }}" oninput="syncHiddenField('nom_client', 'idtiers')"> --}}
                                                            <input type="hidden" id="idtiers" name="idtiers">
                                                            {{-- value="{{ request()->idtiers }}"> --}}
                                                            <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <input type="text" id="designation" name="designation" class="form-control" placeholder="Stade Specifique">
                                                        <input type="hidden" id="id_stade_specifique" name="id_stade_specifique">
                                                        <ul id="suggestionsListStade" name="suggestionsListStade" class="list-group mt-2" style="display: none;"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="modele" placeholder="Modèle">
                                                        {{-- value="{{$dts[0]->nom_modele}}" --}}
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div> --}}

                                        {{-- </div> --}}
                                        {{-- <div class="form-group row"> --}}
                                            <div class="col-3">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                            <input type="text" id="nomStyle" class="form-control" placeholder="Nom du style" >
                                                            <input type="hidden" id="idStyle" class="form-control" name="idStyle" >
                                                            <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <select class="form-control" name="type_lavage">
                                                            <option value="">Lavage</option>
                                                            @if(!empty($lavages))
                                                                @foreach($lavages as $t)
                                                                    <option value="{{ $t->type_lavage }}"
                                                                        {{ (old('lavages') ?? request()->type_lavage) == $t->type_lavage ? 'selected' : '' }}>
                                                                        {{ $t->type_lavage }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <select class="form-control" name="type_valeur_ajoutee">
                                                            <option value="">Valeur Ajoutée</option>
                                                            @if(!empty($valeursAjoutees))
                                                                @foreach($valeursAjoutees as $t)
                                                                    <option value="{{ $t->type_valeur_ajoutee }}"
                                                                        {{ (old('valeursAjoutees') ?? request()->type_valeur_ajoutee) == $t->type_valeur_ajoutee ? 'selected' : '' }}>
                                                                        {{ $t->type_valeur_ajoutee }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <select class="form-control" name="etat">
                                                            <option>Etat</option>
                                                            <option value="100">Dispo</option>
                                                            <option value="200">Non Dispo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- </div> --}}
                                        {{-- <div class="form-group row"> --}}
                                        <div class="col-4 mb-5">
                                            <div class="col-12">
                                                <label>Mois Disponibilité</label>
                                                <div class="input-group" id="date-range">
                                                    <input type="date" class="form-control" name="startMois" min="{{ $startMois }}" max="{{ $endMois }}">
                                                    <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;"> au</span>
                                                    <input type="date" class="form-control" name="endMois" min="{{ $startMois }}" max="{{ $endMois }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="col-12">
                                                <label>Intervalle Disponibilité</label>
                                                <div class="input-group" id="date-range">
                                                    <input type="date" class="form-control" name="startDispo">
                                                    <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">au</span>
                                                    <input type="date" class="form-control" name="endDispo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-8">
                                            <button class="btn btn-success">Filtrer</button>
                                    </div>
                        </form>

                                        <div class="col-md-2">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Voir +
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="0" checked> Mois
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="1" checked> Saison
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="2" checked> Client
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="3" checked> Modèle
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="4" checked> Style
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="5" checked> Qté
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="6"> ETD Initial
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="7"> ETD Révisé
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="8"> ETD Proposé
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="9">BC Client
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="10" checked> Date Disponibilité
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="11" checked> Date Tissu
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="12" checked> Date Accessoire
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="13" checked> Date Ok Prod
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="22" checked> SMV Prod
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="23" > SMV Finition
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="24" checked> Chaine
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="14" > Proposition Inline
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="15" > Inline
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="16" > Outline
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="17" > Capacité
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="18" checked> Nb Jour Prod
                                                    </label>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" class="column-toggle" data-column="19" > Minute Grmt
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    {{-- </div> --}}
                            {{-- filtre --}}
                            <br>
                            <br>
                            <div class="table-responsive"  style="margin-top: -15px; table-layout: auto;">
                                <table class="table student-data-table m-t-20 table-hover">
                                    <thead>
                                        <tr>
                                            <th>Couleur</th>
                                            <th>Mois</th>
                                            <th>Saison</th>
                                            <th>Client</th>
                                            <th>Modèle</th>
                                            <th>Style</th>
                                            <th>Qté</th>
                                            <th>ETD Initial</th>
                                            <th>ETD Révisé</th>
                                            <th>ETD Proposé</th>
                                            <th>BC Client</th>
                                            <th>Date Dispo</th>
                                            <th>Date Tissu</th>
                                            <th>Date Acc</th>
                                            <th>Date OK Prod</th>
                                            <th>SMV Prod</th>
                                            <th>Smv Finition</th>
                                            <th>Inspection</th>
                                            <th>Destination</th>
                                            <th>Qté</th>
                                            <th>Chaine</th>
                                            <th>Inline Proposée   </th>
                                            <th>Inline</th>
                                            <th>Outline    </th>
                                            <th>Capacite</th>
                                            <th>Nbj J Prod</th>
                                            <th>Minute Grmt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dts as $d)
                                        <tr onclick="window.location.href = '{{ route('LRP.dataprod', ['numerocommande' => $d->numerocommande,'iddemandeclient'=>$d->demande_client_id]) }}';" style="cursor: pointer;">
                                            <td>
                                                <div style="display: flex; gap: 10px;">
                                                    <div style="display: flex; gap: 10px;">
                                                        <div style="display: flex; gap: 10px;">
                                                            {{-- Pour tissu_max --}}
                                                            @if ($values[$d->demande_client_id]['tissu_max'] == 20)
                                                            <span class="bdge1 badge badge-outlined rounded-pill" name="tissu">T</span>
                                                            @else
                                                            <span class="bdge1 badge badge-success rounded-pill" name="tissu">T</span>
                                                            @endif

                                                            {{-- Pour accy_max --}}
                                                            @if ($values[$d->demande_client_id]['accy_max'] == 30)
                                                            <span class="bdge1 badge badge-outlined rounded-pill" name="accessoire">A</span>
                                                            @else
                                                            <span class="bdge1 badge badge-success rounded-pill" name="accessoire">A</span>
                                                            @endif

                                                            {{-- Pour disponibilite --}}
                                                            @if ($values[$d->demande_client_id]['ok_prod'] == 10)
                                                            <span class="bdge1 badge badge-outlined rounded-pill" name="ok_prod">OkP</span>
                                                            @else
                                                            <span class="bdge1 badge badge-success rounded-pill" name="ok_prod">OkP</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$d->mois_date_max ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->type_saison ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->nom_client ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->nom_modele ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->nom_style ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->qte ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->etdinitial ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->etdrevise ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->etdpropose ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->bcclient ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->disponibilite_data ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->tissu_max ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->accy_max ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->ok_prod ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->smv_prod ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->smv_finition}}</td>
                                            <td>{{$d->dateinspection ?? 'Aucune donnée'}}</td>
                                            <td>{{$d->destination}}</td>
                                            <td>{{$d->qte}}</td>
                                            <td>{{$d->designation}}</td>
                                            <td>{{$d->propositioninline}}</td>
                                            <td>{{$d->inline_prod}}</td>
                                            <td>{{$d->outline ?? 'Aucune Donnéée'}}</td>
                                            <td>{{$d->capacite}}</td>
                                            <td>{{$d->jourprod}}</td>
                                            <td>{{$d->minutegrmt}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            {{-- </div>
                        </div>
                    </div> --}}
                {{-- </div>
            </div>

        </div> --}}

        <!--**********************************
            Content body end
        ***********************************-->

<script src="{{ asset('./vendor/global/global.min.js') }}"></script>
<script src="{{ asset('js/quixnav-init.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>

<!-- Datatable -->
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>


{{-- FILTRE --}}
{{-- stade --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var designation = document.getElementById('designation');
    var id_stade_specifique = document.getElementById('id_stade_specifique');
    var suggestionsList = document.getElementById('suggestionsListStade');

    designation.addEventListener('input', function () {
        var query = designation.value;

        if (query.length < 1) {
            suggestionsList.style.display = 'none';
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '{{ route("LRP.recherchestadespecifique") }}?designation=' + encodeURIComponent(query), true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var stades = JSON.parse(xhr.responseText);
                suggestionsList.innerHTML = '';
                if (stades.length > 0) {
                    stades.forEach(function (stade) {
                        var li = document.createElement('li');
                        li.className = 'list-group-item';
                        li.textContent = stade.designation;
                        li.addEventListener('click', function () {
                            designation.value = stade.designation;
                            id_stade_specifique.value = stade.id;
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
        // listeData:840 GET http://127.0.0.1:8000/recherche-stadespecifique?designation=TEINTURE 500 (Internal Server Error)


    });

    document.addEventListener('click', function (event) {
        if (!designation.contains(event.target) && !suggestionsList.contains(event.target)) {
            suggestionsList.style.display = 'none';
        }
    });
});
</script>

{{-- saison --}}
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

{{-- client --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nom_client = document.getElementById('nom_client');
        var idtiers = document.getElementById('idtiers');
        var suggestionsListTiers = document.getElementById('suggestionsListTiers');

        nom_client.addEventListener('input', function () {
            var query = nom_client.value;

            if (query.length < 1) {
                suggestionsListTiers.style.display = 'none';
                return;
            }

            var xhr1 = new XMLHttpRequest();
            xhr1.open('GET', '{{ route("recherche-tiers-demande") }}?nom_client=' + encodeURIComponent(query), true);
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
                                nom_client.value = tier.nomtier;
                                idtiers.value = tier.id;
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
            if (!nom_client.contains(event.target) && !suggestionsListTiers.contains(event.target)) {
                suggestionsListTiers.style.display = 'none';
            }
        });
    });
</script>

{{-- style --}}
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
{{-- END FILTRE --}}


{{-- MACRO CHARGE --}}

<script>
    function showSection(sectionId)
    {
        document.querySelectorAll('.content-section').forEach(function(section)
        {
            section.classList.remove('active');
        });
        document.getElementById(sectionId).classList.add('active');
    }
</script>

{{-- <script>
    $(document).ready(function() {
        $('#prod_table').DataTable();
        $('#print_table').DataTable();
        $('#bm_table').DataTable();
        $('#bmc_table').DataTable();
        $('#lbt_table').DataTable();
    });
</script> --}}

<script>
  $(document).ready(function() {
    // Initialisation de la DataTable
    var table = $('#example').DataTable();

    // Configuration des colonnes à afficher pour chaque id_type_macro
    var columnVisibility = {
        1: [true, true, true, true, true, true, true, true, true, true, true, false], // Data Prod
        2: [true, true, true, true, true, true, true, true, true, true, true, false], // Data Print
        3: [true, true, true, true, true, true, true, true, true, true, true, true],  // Data BM
        4: [true, true, true, true, true, true, true, true, true, true, true, false], // Data BMC
        5: [true, true, true, false, false, false, true, true, true, true, true, false] // Data LBT
    };

    // Fonction pour masquer/afficher les colonnes
    function setColumnVisibility(id_type_macro) {
        var visibility = columnVisibility[id_type_macro];
        visibility.forEach(function(show, index) {
            table.column(index).visible(show);
        });
    }

    // Gérer les clics sur les onglets
    $('a[name="id_type_macro"]').on('click', function(e) {
        e.preventDefault();

        // Récupérer l'id_type_macro depuis l'attribut data-value de l'onglet cliqué
        var id_type_macro = $(this).data('value');

        // Ajuster la visibilité des colonnes selon l'id_type_macro
        setColumnVisibility(id_type_macro);

        // Charger les nouvelles données via AJAX
        $.ajax({
            url: '/LRP/listeData1', // Route Laravel pour récupérer les données
            method: 'GET',
            data: { id_type_macro: id_type_macro }, // Envoyer l'id_type_macro au serveur
            success: function(response) {
                // Mettre à jour la table avec les nouvelles données
                table.clear().rows.add(response.data).draw();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Initialiser avec l'onglet actif (par défaut, le premier onglet avec id_type_macro = 1)
    setColumnVisibility(1);
});
</script>

<script>
    function showSection(section) {
    // Récupérer l'ID du type macro depuis l'attribut data-value de l'élément cliqué
    var id_type_macro = $('[onclick="showSection(\'' + section + '\')"]').data('value');

    console.log("ID Type Macro:", id_type_macro);

    // Envoi d'une requête AJAX pour récupérer les données correspondantes
    $.ajax({
    url:  // Nouvelle route pour récupérer les données
    method: 'POST',
    data: {
        id_type_macro: id_type_macro,
        _token: '{{ csrf_token() }}' // Inclure le token CSRF
    },
    success: function(response) {
        console.log(response); // Utilisez les données ici
    },
    error: function(xhr, status, error) {
        console.error(error);
    }
});
}
</script>
@include('CRM.footer')
