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
</style>
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                @include('Planning.headerPlan')

                <br>
                </br>
                @include('CRM.reglage')
                <div class="d-flex justify-content-center" style="min-height: 100vh;">
                <div class="col-lg-8">
                    <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                        <div class="card-header text-center">
                            <h3 class="entete">Ajouter Master Plan</h3>
                        </div>
                        <form action="{{ route('LRP.ajoutermasterplan') }}" method="post" autocomplete="off">
                            @csrf
                            <div class="card-body">
                                <div class="row">


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="idsaison">Demande</label>
                                            <select class="form-control" name="iddemandeclient" id="iddemandeclient" onchange="updateIdRecap()">
                                                <option value="">Sélectionner une demande</option>
                                                @foreach($details_recap as $d)
                                                    <option value="{{ $d->iddemandeclient }}" data-idrecap="{{ $d->id }}">
                                                        recap : {{ $d->id }} || id : {{ $d->iddemandeclient }} de : {{ $d->nomtier }} || modele : {{ $d->nom_modele }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="idrecap" id="idrecap" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="idsaison">Stade Specifique</label>
                                            <div class="input-group">
                                                <input type="text" id="designation" name="designation" class="form-control" placeholder="Stade Specifique">
                                                <input type="hidden" id="id_stade_specifique" name="id_stade_specifique">
                                                <ul id="suggestionsListStade" name="suggestionsListStade" class="list-group mt-2" style="display: none;"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="targetsaison">Statut Commande</label>
                                            <input type="text" class="form-control" name="statut" placeholder="Statut">
                                        </div>
                                    </div>

                                    <div class="col-md-1 text-center">
                                        <button type="submit" class="btn btn-success">Ajouter</button>
                                    </div>

                                    <a href="{{route('LRP.listeMasterPlan')}}">
                                        <button type="button" class="btn btn-info" style="margin-left: 25px;">
                                            Voir Liste
                                        </button>
                                    </a>
                                </div>
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                </div>
            </div>

        </div>
        {{-- <script>
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
                    xhr1.open('GET', '{{ route("recherche-tiers-demande") }}?nomTiers=' + encodeURIComponent(query), true);
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
        </script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var nomTiers = document.getElementById('nomTiers');
                var idTiers = document.getElementById('id_tier'); // Correction ici
                var suggestionsListTiers = document.getElementById('suggestionsListTiers');

                nomTiers.addEventListener('input', function () {
                    var query = nomTiers.value;

                    if (query.length < 1) {
                        suggestionsListTiers.style.display = 'none';
                        return;
                    }

                    var xhr1 = new XMLHttpRequest();
                    xhr1.open('GET', '{{ route("recherche-tiers-demande") }}?nomTiers=' + encodeURIComponent(query), true);
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
                                        idTiers.value = tier.id; // Correction ici aussi
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

    });

    document.addEventListener('click', function (event) {
        if (!designation.contains(event.target) && !suggestionsList.contains(event.target)) {
            suggestionsList.style.display = 'none';
        }
    });
});
</script>

<script>
    function updateIdRecap() {
        var select = document.getElementById('iddemandeclient');
        var selectedOption = select.options[select.selectedIndex];
        var idRecap = selectedOption.getAttribute('data-idrecap');

        if (idRecap) {
            document.getElementById('idrecap').value = idRecap;
        }
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        var idRecapValue = document.getElementById('idrecap').value;

        if (!idRecapValue) {
            e.preventDefault();
            alert('Veuillez sélectionner une demande pour remplir le champ idrecap.');
        }
    });
</script>

@include('CRM.footer')
