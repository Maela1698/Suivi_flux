@include('CRM.header')
@include('CRM.sidebar')
<title>AjoutParametreSer</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .form-control {
        border: 1px solid #b5b5b5;
    }

    label {
        color: #767575;
    }

    #suggestionEncre {
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
    .list-group-item {
        color: black !important;
    }
</style>

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('VAMM.headerVAMM')
        <div class="row">
            <div class="card col-12">
                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">INSERTION PARAMETRE SERIGRAPHIE</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('SERIGRAPHIE.ajoutParametreSer') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">SMV Print </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="smvPrint" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Quantité coupé </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="qteCoupe" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label">Prix </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="prix" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="form-container">
                            <div class="row form-row">
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Type encre </label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="typeEncre[]" required>
                                                @for ($i = 0; $i < count($type); $i++)
                                                    <option value="{{ $type[$i]->id }}">{{ $type[$i]->type_encre }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Encre </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="nomEncre" class="form-control"
                                                placeholder="Encre" required>
                                            <input type="hidden" id="idEncre" class="form-control" name="idEncre[]"
                                                required>
                                            <ul id="suggestionEncre" class="list-group mt-2" style="display: none;">
                                            </ul>
                                            <div id="errorMessageSaison" style="color: red; margin-top: 5px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Grammage </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="grammage[]" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Couche </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="couche[]" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label" style="color: transparent">Plus </label>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-success"
                                                onclick="addFormRow()">+</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row mt-3">
                            <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                <a href="{{ route('SERIGRAPHIE.listeParametreSer') }}"
                                    class="btn btn-secondary mr-3">Retour</a>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('VAMM.SERIGRAPHIE.parametreSer')
    <!--**********************************
        modal start
***********************************-->





    <!--**********************************
        javascript start
***********************************-->
    {{--
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nomEncre = document.getElementById('nomEncre');
        var idEncre = document.getElementById('idEncre');
        var suggestionsList = document.getElementById('suggestionEncre');

        nomEncre.addEventListener('input', function () {
            var query = nomEncre.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("rechercheEncre") }}?encre=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function (saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.encre;
                            li.addEventListener('click', function () {
                                nomEncre.value = saison.encre;
                                idEncre.value = saison.id;
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
            if (!nomEncre.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>  --}}
    <script>
        // Fonction pour attacher l'autocomplétion à un champ
        function attachAutoComplete(nomEncre, idEncre, suggestionsList) {

            nomEncre.addEventListener('input', function() {
                var query = nomEncre.value;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route('rechercheEncre') }}?encre=' + encodeURIComponent(query), true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var saisons = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (saisons.length > 0) {
                            saisons.forEach(function(saison) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = saison.encre;
                                li.addEventListener('click', function() {
                                    nomEncre.value = saison.encre;
                                    idEncre.value = saison.id;
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
                if (!nomEncre.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Attacher l'autocomplétion au champ d'origine
            attachAutoComplete(document.getElementById('nomEncre'), document.getElementById('idEncre'), document
                .getElementById('suggestionEncre'));
        });

        // Fonction pour ajouter une nouvelle ligne avec autocomplétion
        function addFormRow() {
            var formRow = document.querySelector('.form-row').cloneNode(true);

            // Remplacer le bouton ajouter par supprimer
            var btn = formRow.querySelector('button');
            btn.classList.remove('btn-success');
            btn.classList.add('btn-danger');
            btn.textContent = '-';
            btn.setAttribute('onclick', 'removeFormRow(this)');

            // Vider les champs
            formRow.querySelectorAll('input').forEach(input => input.value = '');

            // Réinitialiser l'élément d'autocomplétion
            var newNomEncre = formRow.querySelector('#nomEncre');
            var newIdEncre = formRow.querySelector('#idEncre');
            var newSuggestionEncre = formRow.querySelector('#suggestionEncre');


            // Assigner des IDs uniques pour éviter les conflits
            newNomEncre.id = 'nomEncre-' + Date.now();
            newIdEncre.id = 'idEncre-' + Date.now();
            newSuggestionEncre.id = 'suggestionEncre-' + Date.now();

            // Attacher l'autocomplétion au nouveau champ Encre
            attachAutoComplete(newNomEncre, newIdEncre, newSuggestionEncre);

            // Ajouter la nouvelle ligne au conteneur
            document.getElementById('form-container').appendChild(formRow);
        }

        // Fonction pour supprimer une ligne
        function removeFormRow(button) {
            button.closest('.form-row').remove();
        }
    </script>

    <!--**********************************
        Content body end
***********************************-->
    @include('CRM.footer')
