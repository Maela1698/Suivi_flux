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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">PARAMETRE SERIGRAPHIE</h3>
                    @if (count($param)==0)
                    <form action="{{ route('SERIGRAPHIE.formAjoutParametreSer') }}" method="get">
                        @csrf
                        <input type="hidden" name="erreur" value="">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                    @endif

                </div>
                <div class="card-body" style="background-color: rgb(239, 238, 238); border-radius: 10px;">
                    <center>
                        <h2>{{ $demande[0]->type_saison }}</h2>
                    </center>
                    <div class="row mt-3" style="display: flex; align-items: center;">
                        <div class="col-md-2 mt-1">
                            <center>
                                <img src="data:image/png;base64,{{ $demande[0]->photo_commande }}"
                                    class="img-fluid rounded-start mb-5" alt="Logo" width="120px" height="120px">
                            </center>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte"><b>Date entrée :</b>
                                    {{ \Carbon\Carbon::parse($demande[0]->date_entree)->format('d/m/y') }}</p>
                                <p class="texte"><b>Periode :</b> {{ $demande[0]->periode }}</p>
                                <p class="texte"><b>Client :</b> {{ $demande[0]->nomtier }}</p>
                                <p class="texte"><b>Modèle :</b>{{ $demande[0]->nom_modele }}</p>
                                <p class="texte"><b>Designation :</b>{{ $demande[0]->nom_style }}</p>
                                <p class="texte"><b>Thème :</b>{{ $demande[0]->theme }}</p>
                                <p class="texte"><b>Quantité prévisionnel
                                        :</b>{{ $demande[0]->qte_commande_provisoire }}</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte">
                                    <b>ETD:</b>{{ \Carbon\Carbon::parse($demande[0]->date_livraison)->format('d/m/y') }}
                                </p>
                                <p class="texte"><b>Stade :</b> {{ $demande[0]->type_stade }}</p>
                                <p class="texte"><b>Grille de taille
                                        :</b>{{ $demande[0]->taillemin }}--{{ $demande[0]->taillemax }}</p>
                                <p class="texte"><b>Taille de base :</b>{{ $demande[0]->taille_base }}</p>
                                <p class="texte"><b>Incontern :</b> {{ $demande[0]->type_incontern }}</p>
                                <p class="texte"><b>Phase :</b> {{ $demande[0]->type_phase }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (count($param) != 0)
                        <form action="{{ route('SERIGRAPHIE.updateParametreSer') }}" method="post" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">SMV Print </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="smvPrint" class="form-control"
                                                value="{{ $param[0]->smv_print }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Quantité coupé </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="qteCoupe" class="form-control"
                                                value="{{ $param[0]->qte_coupe }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Prix </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="prix" class="form-control"
                                                value="{{ $param[0]->prix_print }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning">Modifier</button>
                                </div>
                            </div>
                        </form>
                    @endif
                    @if (count($param) != 0)
                        <form action="{{ route('SERIGRAPHIE.updateDetailParametreSer') }}" method="post"
                            autocomplete="off">
                            @csrf
                            <div id="form-container">
                                <div class="row form-row">
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label">Type encre </label>
                                            </div>
                                            <div class="col-12">
                                                <select class="form-control" name="typeEncre" required>
                                                    @for ($i = 0; $i < count($type); $i++)
                                                        <option value="{{ $type[$i]->id }}">
                                                            {{ $type[$i]->type_encre }}
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
                                                <input type="hidden" id="idEncre" class="form-control"
                                                    name="idEncre" required>
                                                <ul id="suggestionEncre" class="list-group mt-2"
                                                    style="display: none;">
                                                </ul>
                                                <div id="errorMessageSaison" style="color: red; margin-top: 5px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label">Grammage </label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="grammage" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label">Couche </label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="couche" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label" style="color: transparent">Plus </label>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-success">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive mt-4">
                            <table class="table table-striped" style="color: black">
                                <thead>
                                    <tr>
                                        <th>Type Encre</th>
                                        <th>Encre</th>
                                        <th>Grammage</th>
                                        <th>Couche</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @for ($i = 0; $i < count($param); $i++)
                                        <tr>
                                            <td>{{ $param[$i]->type_encre }}</td>
                                            <td>{{ $param[$i]->encre }}</td>
                                            <td>{{ $param[$i]->grammage }} g</td>
                                            <td>{{ $param[$i]->couche }}</td>
                                            <td>
                                                <form action="{{ route('SERIGRAPHIE.deteleDetailParametre') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="idDetail" value="{{ $param[$i]->id }}">
                                                    <button type="submit" class="btn btn-danger mt-1 btn-sm mr-2">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endfor


                                </tbody>
                            </table>
                        </div>
                    @else
                        <tr>
                            <td colspan="6">Pas de parametre pour le moment</td>
                        </tr>
                    @endif
                </div>
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



    // Fonction pour supprimer une ligne
    function removeFormRow(button) {
        button.closest('.form-row').remove();
    }
</script>

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
