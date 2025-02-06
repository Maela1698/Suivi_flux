@include('CRM.header')
@include('CRM.sidebar')
<style>
    .code {
        display: flex;
        gap: 4px;
        /* Espace entre les cercles */
    }

    .circle {
        border: solid thin black;
        width: 30px;
        /* Largeur du cercle */
        height: 30px;
        /* Couleur de fond du cercle */
        color: white;
        /* Couleur du texte */
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        /* Rend le div rond */
        font-size: 24px;
        /* Taille du texte */
    }

    label {
        color: black;
        font-size: 12px;
    }
    #suggestionsListSaison {
        max-height: 200px;
        overflow-y: auto;
        color: white;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: black;
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
        color: white;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: black;
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
        color: white;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: black;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }
</style>
<!--**********************************
            Content body start
         ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: start;">
                    <h3 class="entete">LISTE DEMANDE FOR PPMEETING</h3>
                </div>
                <div class="card-body" style="margin-top: -15px;overflow: auto;">
                    <form action="{{ route('LRP.listeDemandeForPpmeeting') }}" method="get" autocomplete="off">
                        @csrf
                        <div class="recherche" style="display: flex; flex-wrap: wrap; align-items: center;">
                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput">Saison</label>
                                <input type="text" id="nomSaison" class="form-control"
                                        oninput="syncHiddenField('nomSaison', 'idSaison')">
                                    <input type="hidden" id="idSaison" name="idSaison">
                                    <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                    </ul>
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput">Client</label>
                                <input type="text" id="nomTiers" class="form-control" oninput="syncHiddenField('nomTiers', 'idTiers')">
                                    <input type="hidden" id="idTiers" name="idTiers">
                                    <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                    </ul>
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput">Modele</label>
                                <input type="text" class="form-control mr-sm-2" id="inlineFormInput" name="modele">
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput">Style</label>
                                <input type="text" id="nomStyle" class="form-control"  oninput="syncHiddenField('nomStyle', 'idStyle')">
                                <input type="hidden" id="idStyle" name="idStyle" >
                                <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;"></ul>
                            </div>
                            <div class="col-auto my-1" style="flex-grow: 1; min-width: 200px;">
                                <label class="mr-sm-2" for="inlineFormInput" style="color: transparent;">Search</label>
                                <input type="submit" style="background-color: rgb(51, 208, 51);width:80px;"
                                    class="form-control mr-sm-2" id="inlineFormInput" value="Filtrer">
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Couleur</th>
                                <th>Saison</th>
                                <th>Date entrée</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Style</th>
                                <th>Qté</th>
                                <th>ETD</th>
                                <th>Date Tissu</th>
                                <th>Date Acc</th>
                                <th>Date OK Prod</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($liste as $d)
                                <tr style="color: rgb(77, 77, 77);cursor: pointer;"
                                    onclick="window.location.href = '#">
                                    <td>
                                        <div class="code">
                                            @if($d->tissus)
                                                <div class="circle"
                                                style="background-color: green;font-size: 12px;color:white;">T</div>
                                                @else
                                                <div class="circle"
                                                style="background-color: white;font-size: 12px;color:black;">T</div>
                                            @endif
                                            @if($d->accy)
                                                <div class="circle"
                                                style="background-color: green;font-size: 12px;color:white;">A</div>
                                                @else
                                                <div class="circle"
                                                style="background-color: white;font-size: 12px;color:black;">A</div>
                                            @endif
                                            @if($d->okprod)
                                                <div class="circle"
                                                style="background-color: green;font-size: 12px;color:white;">Ok</div>
                                                @else
                                                <div class="circle"
                                                style="background-color: white;font-size: 12px;color:black;">Ok</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $d->type_saison }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->date_entree)->format('d/m/Y') }}</td>
                                    <td>{{ $d->nomtier }}</td>
                                    <td>{{ $d->nom_modele }}</td>
                                    <td>{{ $d->nom_style }}</td>
                                    <td>{{ $d->qte_commande_provisoire }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->date_livraison)->format('d/m/Y') }}</td>
                                    <td>@if($d->tissus){{ \Carbon\Carbon::parse($d->tissus)->format('d/m/Y') }}@endif</td>
                                    <td>@if($d->accy){{ \Carbon\Carbon::parse($d->accy)->format('d/m/Y') }}@endif</td>
                                    <td>@if($d->okprod){{ \Carbon\Carbon::parse($d->okprod)->format('d/m/Y') }}@endif</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!--**********************************
            Content body end
        ***********************************-->

@include('CRM.footer')



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
