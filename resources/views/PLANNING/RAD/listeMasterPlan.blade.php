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

        .bdge2{
            color:white;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-size: 0.8rem;
        }


    </style>
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                @include('PLANNING.headerPlan')
                <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
                    <div class="col-lg-2 col-sm-4">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Négociation</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($nb_negoc[0]->nb_negoc,0,' ',' ') }}</h2>
                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-list" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #4568dc, #b06ab3);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Appro</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($nb_approv[0]->nb_approv,0,' ',' ') }}</h2>
                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-handshake" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #43cea2, #185a9d);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Transformat°</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($nb_transfo[0]->nb_transfo,0,' ',' ') }}</h2>
                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-check-circle" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #f3904f, #3b4371);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Cond°</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($nb_cond[0]->nb_cond,0,' ',' ') }}</h2>
                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-times-circle" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #ff6e7f, #556770);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Expédiés</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($nb_expe[0]->nb_cond,0,' ',' ') }}</h2>
                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4">
                        <div class="card card-small" style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #ff6e7f, #556770);">
                            <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                                <div>
                                    <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Facturés</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($nb_fact[0]->nb_fact,0,' ',' ') }}</h2>
                                    </div>
                                </div>
                                <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs" style="color: white;"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <br> </br>
                @include('CRM.reglage')
                <div class="col-lg-12">
                    <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                        <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                                <h3  class="entete">MASTER PLAN</h3>
                            {{-- <form action="#" method="get"> --}}
                                <a href="{{route('LRP.showajoutermasterplan')}}">
                                    <button class="btn btn-primary" style="margin-right: 15px;">Ajouter</button>
                                </a>
                            {{-- </form> --}}
                        </div>
                        <form action="{{ route('LRP.listeMasterPlan') }}" method="get" autocomplete="off" >
                            @csrf
                        <div class="card-body" style="margin-top: -15px;">
                            <div class="row">
                                <div class="col-md-2 col-lg-2">
                                    <div class="input-group">
                                        {{-- <input type="text" id="nomSaison" class="form-control" placeholder="Saison" value="{{ $nomSaison }}" oninput="syncHiddenField('nomSaison', 'idSaison')"> --}}
                                        <input type="text" id="nomSaison" class="form-control" placeholder="Saison" value="{{ $nomSaison }}">
                                        <input type="hidden" id="idSaison" name="idSaison" value="{{ request()->idSaison }}">
                                        <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>

                                <div class="col-md-2 col-lg-2">
                                    <div class="input-group">
                                        {{-- <input type="text" id="nom_client" class="form-control" placeholder="Client" value="{{ $nom_client }}" oninput="syncHiddenField('nom_client', 'demande_client_id')"> --}}
                                        <input type="text" id="nom_client" class="form-control" placeholder="Client" value="{{ $nom_client }}">
                                        <input type="hidden" id="demande_client_id" name="demande_client_id" value="{{ request()->demande_client_id }}">
                                        <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>

                                <div class="col-md-2 col-lg-2">
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

                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <select class="form-control" name="designation_stade_master_plan" value="{{request()->designation_stade_master_plan}}">
                                            <option value="">Etat</option>
                                            @if(!empty($designation_stade_master_plan))
                                                @foreach($designation_stade_master_plan as $t)
                                                    <option value="{{ $t->designation }}"
                                                        {{ (old('designation_stade_master_plan') ?? request()->designation_stade_master_plan) == $t->designation ? 'selected' : '' }}>
                                                        {{ $t->designation }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <select class="form-control" name="nom_style" value="{{request()->nom_style}}">
                                            <option value="">Style</option>
                                            @if(!empty($nom_style))
                                                @foreach($nom_style as $t)
                                                    <option value="{{ $t->nom_style }}"
                                                        {{ (old('nom_style') ?? request()->nom_style) == $t->nom_style ? 'selected' : '' }}>
                                                        {{ $t->nom_style }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group" id="date-range">
                                        <label for="" style="color:#000000; text-decoration:bold">PO Date : &nbsp;&nbsp;</label><br>
                                        <input type="date" class="form-control" name="podateStart">
                                        <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                        <input type="date" class="form-control" name="podateTil">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" id="date-range">
                                        <label for="" style="color:#000000; text-decoration:bold">ETD : &nbsp;&nbsp;</label><br>
                                        <input type="date" class="form-control" name="etdStart">
                                        <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                        <input type="date" class="form-control" name="etdTil">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success">Filtrer</button>
                                </div>
                            </form>
                                <div class="col-md-2" style="margin-left: -110px;">
                                    <div class="dropdown" style="margin-left: 15px;">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Voir +
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="0" checked> Saison
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="1" checked> Client
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="2" checked> Modèle
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="3" checked> Style
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="4" checked> Numéro Commande
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="5" checked> Quantité
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="6" > Réception BC
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="7" checked> ETD
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="8" checked> Besoin OK Prod
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="9" checked> Besoin MP
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="10" checked> Besoin Lancement
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="11" checked> Lead Time Réel
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="12" > BC Tissu
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="13" > BC Accy
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="22" > KI Lancement
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="23" > KI OK Prod
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="24" > KI MP
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="14" > Qté Expédition
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="15" checked> Statut Commande
                                            </label>
                                            <label class="dropdown-item">
                                                <input type="checkbox" class="column-toggle" data-column="16" checked > Stade Spécifique
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <br>
                            <div class="table-responsive"  style="margin-top: -15px; table-layout: auto;">
                                <table class="table student-data-table m-t-20 table-hover">
                                    <thead>
                                        <tr>
                                            <th>BC</th>
                                            <th>PO Date</th>
                                            <th>ETD</th>
                                            {{-- <th>Lead Time Reel</th> --}}
                                            <th>LTR</th>
                                            <th>Saison</th>
                                            <th>Client</th>
                                            <th>Modèle</th>
                                            <th>Style</th>
                                            <th>N° C/de</th>
                                            <th>QTE</th>
                                            {{-- <th>Réception BC</th>
                                            <th>Besoin OK Prod</th>
                                             <th>Besoin MP</th>
                                            <th>Besoin Lancement</th>
                                            <th>Lead Time Réel</th>
                                            <th>BC Tissu</th>
                                            <th>BC Accy</th>
                                             <th>KI Lancement</th>
                                            <th>KI OK Prod</th>
                                            <th>KI MP</th> --}}
                                            <th>Stade SPF</th>
                                            <th>VA</th>

                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($masterPlans as $m)
                                        <tr onclick="window.location.href = '{{ route('LRP.detailMasterPlan', ['demande_client_id' => $m->demande_client_id]) }}';" style="cursor: pointer;">
                                            <input type="hidden" name="id_recap_commande" value="{{$m->id_recap_commande}}">
                                            <input type="hidden" name="id_recap_commande" value="{{$m->id_destination}}">
                                            <td>
                                                <div style="display: flex; gap: 10px;">
                                                    <div style="display: flex; gap: 10px;">
                                                        <div style="display: flex; gap: 10px;">

                                                            @if(isset($retardValues[$m->id_recap_commande]))
                                                                @php
                                                                    $retardTissu = $retardValues[$m->id_recap_commande]['retardTissu'];
                                                                    $retardAccessoire = $retardValues[$m->id_recap_commande]['retardAccessoire'];
                                                                @endphp
                                                                @if($retardTissu === 30)
                                                                    <span class="bdge1 badge badge-outlined rounded-pill is-active" name="bt">BT</span>
                                                                @endif
                                                                @if($retardTissu === 20)
                                                                    <span class="bdge2 badge rounded-pill bg-danger" name="btRouge">BT</span>
                                                                @endif
                                                                @if($retardTissu === 10)
                                                                    <span class="bdge2 badge rounded-pill bg-success" name="btVert">BT</span>
                                                                @endif

                                                                @if($retardAccessoire === 30)
                                                                    <span class="bdge1 badge badge-outlined rounded-pill is-active" name="ba">BA</span>
                                                                @endif
                                                                @if($retardAccessoire === 10)
                                                                    <span class="bdge2 badge rounded-pill bg-success" name="baVert">BA</span>
                                                                @endif
                                                                @if($retardAccessoire === 20)
                                                                    <span class="bdge2 badge rounded-pill bg-danger" name="baRouge">BA</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>

                                            <td>
                                                @if(isset($m->id_recap_commande))
                                                    {{-- <p>Podate Checked: {{ $m->podatecheked }}</p> --}}
                                                    {{-- <p>{{dd($m->podatecheked)}}</p> --}}
                                                {{-- ; --}}

                                                    @if($m->podatecheked == 10)
                                                        <span class="badge badge-info" style="font-size: 85%">
                                                            {{$m->podate}}
                                                        </span>
                                                    @elseif($m->podatecheked == 20)
                                                        <span class="badge badge-warning" style="font-size: 85%">
                                                            {{$m->podateprev}}
                                                        </span>
                                                    @else
                                                    {{-- <span class="badge badge-info" style="font-size: 85%">
                                                        {{$m->podate}}
                                                    </span> --}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($m->id_destination))
                                                    {{-- <p>ETD Checked: {{ $m->etdcheked }}</p> --}}
                                                    @if($m->etdcheked  == 10)
                                                        <span class="badge badge-success" style="font-size: 85%">
                                                            {{$m->etdinitial}}
                                                        </span>
                                                    @elseif($m->etdcheked  == 20)
                                                        <span class="badge badge-warning" style="font-size: 85%">
                                                            {{$m->etdrevise}}
                                                        </span>
                                                    @else
                                                    <span class="badge badge-success" style="font-size: 85%">
                                                        {{$m->etdinitial}}
                                                    </span>
                                                    @endif
                                                @endif
                                            </td>


                                            <td>{{$m->leadtimereel}} jours</td>
                                            <td>{{$m->type_saison}}</td>
                                            <td>{{$m->nom_client}}</td>
                                            <td>{{$m->nom_modele}}</td>
                                            <td>{{$m->nom_style}}</td>
                                            <td>{{$m->numerocommande}}</td>
                                            <td>{{$m->qte_commande_provisoire }}</td>
                                            <td>{{$m->designation_stade_specifique}}</td>
                                            <td>{{$m->types_valeur_ajoutee}}</td>
                                        </tr>
                                            {{-- @endif --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
            row.querySelectorAll('td, th')[column].style.display = checkbox.checked ? '' : 'none';
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
            document.addEventListener('DOMContentLoaded', function () {
                var nom_client = document.getElementById('nom_client');
                var demande_client_id = document.getElementById('demande_client_id');
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
                                        demande_client_id.value = tier.id;
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

@include('CRM.footer')
