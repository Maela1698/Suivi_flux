@include('CRM.header')
@include('CRM.sidebar')
<title>AjoutAccessoire</title>

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
</style>
<style>
    .custom-tooltip .tooltip-inner {
        background-color: #f8d7da;
        /* Couleur de fond */
        color: #721c24;
        /* Couleur du texte */
        font-size: 16px;
        /* Taille du texte */
        padding: 10px;
        /* Espacement */
    }

    .custom-tooltip .arrow::before {
        border-top-color: #f8d7da;
        /* Couleur de la flèche */
    }

    .checkbox {
        display: grid;
        grid-template-columns: repeat(20, auto);
        /* 10 colonnes */
        gap: 10px;
        /* Espace entre les checkboxes */
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        /* Aligne les éléments au centre verticalement */
        font-size: 15px;
        /* Ajustez la taille de la police si nécessaire */
    }

    .checkbox input {
        margin-right: 5px;
        /* Espace entre la case à cocher et le texte */
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">DUPLICATA</h3>
                </div>

                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" action=" {{ route('CRM.ajoutDuplicata') }} " method="post"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <input type="hidden" name="idDemandeClient" value="{{ $idDemandeClients }}">
                            <div class="form-group row">
                                <div class="checkbox">
                                    <label class="checkbox-label"><input type="checkbox" name="mp"
                                            value="mp"><span class="texte mr-4">Matiere premiere</span></label>
                                    <label class="checkbox-label"><input type="checkbox" name="fdc"
                                            value="fdc"><span class="texte mr-4">FDC</span></label>
                                    <label class="checkbox-label"><input type="checkbox" name="smv"
                                            value="smv"><span class="texte mr-4">SMV</span></label>
                                    <label class="checkbox-label"><input type="checkbox" name="pri"
                                            value="pri"><span class="texte mr-4">PRI</span></label>

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Date entrée </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" class="form-control" name="dateEntree" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Nom modèle </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="nomModele" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Saison </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="nomSaison" class="form-control" placeholder="Nom du saison" required>
                                            <input type="hidden" id="idSaison" class="form-control" name="idSaison" >
                                            <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Image demande </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="file" class="form-control" name="photo">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Nom du DT </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="nomDT">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Fichier du DT </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="file" class="form-control" name="ficheDT">
                                        </div>
                                    </div>
                                </div>
                            </div>


                    </div>






                    <div class="form-group row">
                        <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Dupliquer</button>
                        </div>
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
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
