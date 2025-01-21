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
        <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
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
                    style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #4568dc, #b06ab3);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Expedié</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($expedie, 0, ' ', ' ') }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-paper-plane"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Qté Total</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($quantite, 0, ' ', ' ') }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-boxes"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #f3904f, #3b4371);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Qté Expedié</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($qteexpedie, 0, ' ', ' ') }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-shipping-fast"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 0;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Lavage & Teinture</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($lbt, 0, ' ', ' ') }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-tint"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #16a085, #f4d03f);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Brod Main</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($broadmain, 0, ' ', ' ') }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-hand-paper"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #82a382, #000c40);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Brod Machine</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($broadmachine, 0, ' ', ' ') }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-seedling"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 70px; background: linear-gradient(to right, #667eea, #764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white"
                                style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">Sérigraphie</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ number_format($serigraphie, 0, ' ', ' ') }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-print"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">RECAP COMMANDE</h3>
                </div>
                <div class="card-body" style="margin-top: -15px;">
                    <form action="{{ route('PLANNING.recapcommande') }}" method="get">
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
                                <select class="form-control" name="va">
                                    <option value="">VA</option>
                                    <option value="lavage">Lavage</option>
                                    <option value="Serigraphie">Serigraphie</option>
                                    <option value="Blanchiment">Blanchiment</option>
                                    <option value="Teinture">Teinture</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <select class="form-control" name="etat">
                                    <option value="">Etat</option>
                                    <option value="expedietout">Expedié 100%</option>
                                    <option value="expedie">Expedié Partielle</option>
                                    <option value="retard">Retard</option>
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
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="startetdinitial">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="endetdinitial">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="startetdreviser">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="endetdreviser">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success">Filtrer</button>
                        </div>
                    </form>
                        <div class="col-md-2" style="margin-left: -110px;">
                            <div class="dropdown" style="margin-left: -40px;">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Voir +
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="0" checked> code
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
                                        <input type="checkbox" class="column-toggle" data-column="5" checked> Smv
                                        Prod
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="6"> Smv Finition
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="7" checked> ETD
                                        Initial
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="8" checked> ETD
                                        Révisé
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="9"> Livraison
                                        Exacte
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="10"> Reception BC
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="11"> Numero
                                        Commande
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="12"> Incoterm
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="13"> Inspection
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="14"> Destination
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="15" checked> Qté
                                        Totale
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="16"> OK Prod
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="17"> Date Envoye BC
                                        Tissu
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="18"> Date Prev
                                        Arrivée Tissu
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="19"> Date Réception
                                        Tissu
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="20"> Date Envoye BC
                                        Accy
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="21"> Date Prev
                                        Arrivée Accy
                                    </label>
                                    <label class="dropdown-item">
                                        <input type="checkbox" class="column-toggle" data-column="22"> Date Réception
                                        Accy
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>
                    <div class="table-responsive" style="margin-top: -15px;">
                        <table class="table student-data-table m-t-20 table-hover">
                            <thead>
                                <tr>
                                    <th>code</th>
                                    <th>Saison</th>
                                    <th>Client</th>
                                    <th>Modèle</th>
                                    <th>Style</th>
                                    <th>Smv Prod</th>
                                    <th>Smv Finition</th>
                                    <th>ETD Initial</th>
                                    <th>ETD Révisé</th>
                                    <th>Livraison Exacte</th>
                                    <th>Réception BC</th>
                                    <th>Numéro Commande</th>
                                    <th>Incoterm</th>
                                    <th>Inspection</th>
                                    <th>Destination</th>
                                    <th>Qté Totale</th>
                                    <th>OK PROD</th>
                                    <th>Date Envoye BC Tissu</th>
                                    <th>Date Prev Arrivée Tissu</th>
                                    <th>Date Réception Tissu</th>
                                    <th>Date Envoye BC Accy</th>
                                    <th>Date Prev Arrivée Accy</th>
                                    <th>Date Réception Accy</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recap as $r)
                                    <tr
                                        onclick="window.location.href = '{{ route('PLANNING.detailRecap', ['idDemande' => $r->id, 'idRecap' => $r->recapcommande_id]) }}';">
                                        <td>
                                            <div style="display: flex;">
                                            <div
                                                style="border: solid thin black;
                                                                width: 20px;
                                                                height: 20px;
                                                                color: white;
                                                                display: flex;
                                                                justify-content: center;
                                                                align-items: center;
                                                                border-radius: 50%;
                                                                font-size: 12px;
                                                                color: black;
                                                                background-color:{{ $r->livraison_couleur }}">
                                                L
                                            </div>
                                            @if($r->date_livraison<now())
                                                <div
                                                    style="border: solid thin black;
                                                                    width: 20px;
                                                                    height: 20px;
                                                                    color: white;
                                                                    display: flex;
                                                                    justify-content: center;
                                                                    align-items: center;
                                                                    border-radius: 50%;
                                                                    font-size: 12px;
                                                                    color: black;
                                                                    margin-left:5px;
                                                                    background-color:rgb(250, 91, 91);">
                                                    R
                                                </div>
                                                @else
                                                <div
                                                    style="border: solid thin black;
                                                                    width: 20px;
                                                                    height: 20px;
                                                                    color: white;
                                                                    display: flex;
                                                                    justify-content: center;
                                                                    align-items: center;
                                                                    border-radius: 50%;
                                                                    font-size: 12px;
                                                                    color: black;
                                                                    margin-left:5px;">
                                                    R
                                                </div>
                                            @endif
                                        </div>

                                        </td>
                                        <td>{{ $r->type_saison }}</td>
                                        <td>{{ $r->nomtier }}</td>
                                        <td>{{ $r->nom_modele }}</td>
                                        <td>{{ $r->nom_style }}</td>
                                        <td>{{ $r->smv_prod }}</td>
                                        <td>{{ $r->smv_finition }}</td>
                                        <td>{{ $r->etdinitial }}</td>
                                        <td>{{ $r->etdrevise }}</td>
                                        <td>{{ $r->datelivraisonexacte }}</td>
                                        <td>{{ $r->receptionbc }}</td>
                                        <td>{{ $r->numerocommande }}</td>
                                        <td>{{ $r->type_incontern }}</td>
                                        <td>{{ $r->dateinspection }}</td>
                                        <td>{{ $r->designation }}</td>
                                        <td>{{ $r->qte_commande_provisoire }}</td>
                                        <td>{{ $r->micro_datecalcul }}</td>
                                        <td>{{ $r->tissus_dateconfirmation }}</td>
                                        <td>{{ $r->combined_final_deadline }}</td>
                                        <td>{{ $r->max_datearrivereelle }}</td>
                                        <td>{{ $r->accy_dateconfirmation }}</td>
                                        <td>{{ $r->combined_final_deadline_accy }}</td>
                                        <td>{{ $r->accy_max_datearrivereelle }}</td>
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
@include('CRM.footer')

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


