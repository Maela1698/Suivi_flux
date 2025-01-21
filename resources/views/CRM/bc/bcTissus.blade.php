<style>
    .entete {
        color: #7571f9;
        background-color: white;
    }
    .carte {
        color: white;
        background-color: white;
    }
    .texte {
        color: black;
    }
    .table {
        color: black;
    }
    .button-group {
        display: flex;
        justify-content: space-around;
    }
    .button-group form {
        margin-right: 10px;
    }
    .form-inline .form-group {
        margin-right: 5px;
    }
    .form-inline .form-control {
        padding-left: 5px;
        padding-right: 5px;
    }
    .form-group.mb-2, .form-group.mx-sm-1.mb-2 {
        margin-bottom: 0;
    }
    .form-inline .form-control-plaintext {
        margin-right: 5px;
    }
    .form-inline select, .form-inline button {
        margin-left: 5px;
    }
    .delete-btn {
        position: absolute;
        right: 20px;
        top: 10px;
    }
    #suggestionsListClient {
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

    .suggestions-list {
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

@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid mt-3">
        @include('CRM.headerBc')
        <div class="card col-12 carte">
            <div class="card-header d-flex justify-content-center align-items-center entete">
                <h3 class="entete">BC TISSUS</h3>
            </div>

            <div class="card-body">
                <div class="row mt-3" style="display: flex; align-items: center; justify-content: space-between; border-bottom: solid 3px lightgrey;">
                    <div class="col-5" style="margin-left: 100px;">
                        <img src="" class="img-fluid rounded-start mb-5" alt="Logo" width="200" height="200px">
                    </div>
                    <div class="col-5" style="margin-top: -60px; margin-left:30px;">
                        <p class="texte mb-0"><b>Société Anonyme avec conseil d'administration</b></p>
                        <p class="texte mb-0"><b>au capital de 148 400 000 Ariary</b></p>
                        <p class="texte mb-0"><b>LOT 03810D Ambohitrangano Sabotsy Namehana</b></p>
                        <p class="texte mb-0"><b>Antananarivo 103</b></p>
                        <p class="texte mb-0"><b>NIF: 2000100388</b></p>
                        <p class="texte mb-0"><b>STAT: 14105 11 1995 0 00077</b></p>
                        <p class="texte mb-0"><b>Décret d'agrément n°95-410 du 30 Mai 1995</b></p>
                        <p class="texte mb-0"><b>TEL 22 451 54 / 22 534 84</b></p>
                        <p class="texte mb-0"><b>FAX / 24 741 05</b></p>
                    </div>
                </div>

                            <br>
            <form action="{{ route('CRM.bcTissus') }}" method="get">
                @csrf
                <div class="test" style="display: block;">
                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 151px;">Date :</span>
                                </div>
                                <input type="date" class="form-control custom-input" name="dateTissus">
                            </div>

                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 151px;">N° BC :</span>
                                </div>
                                <input type="text" class="form-control" name="numero" value="{{ $numero }}_tissu/LOI/{{ date('Y') }}" readonly>
                            </div>

                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" style="width: 151px;">Fournisseur</label>
                                </div>
                                <select class="custom-select" name="fournisseur">
                                    <option selected>Choisir un fournisseur...</option>
                                    @foreach($fournisseur as $f)
                                    <option value="{{ $f->id }}">{{ $f->nomtier }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group mb-1" style="width: 370px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Échéance Livraison :</span>
                                </div>
                                <input type="date" class="form-control" name="echeance">
                            </div>

                            <!-- Div principal pour le client -->
                            <div class="col-5" style="float: right; margin-top: -155px; position: relative;">
                                <div id="client-section">
                                    <div class="input-group mb-1" style="width: 370px;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="width: 151px;">Modele :</span>
                                        </div>
                                        <input type="text" id="nomClient" class="form-control" required>
                                        <input type="hidden" id="idClient" class="form-control" name="nomClient0" >
                                        <ul id="suggestionsListClient" class="list-group mt-2" style="display: none;"></ul>
                                    </div>
                                </div>
                                <button type="button" id="add-client" class="btn btn-primary" style="position: absolute; right: 35px; top: 3;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>


                            <input type="hidden" id="totalClients" name="totalClients" value="0">
                            <!-- Conteneur pour les nouveaux divs -->
                            <div id="additional-clients" style="clear: both;"></div>

                            <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                </div>
            </form>


@if(1==1)
    <div class="tests" style="display: none;margin-top: -10px;">
        <div class="input-group mb-1" style="width: 370px;">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width: 151px;">Date :</span>
            </div>
            <input type="date" class="form-control custom-input" name="dateTissus">
        </div>

        <div class="input-group mb-1" style="width: 370px;">
            <div class="input-group-prepend">
                <span class="input-group-text" style="width: 151px;">N° BC :</span>
            </div>
            <input type="text" class="form-control" name="numero" value="{{ $numero }}_tissu/LOI/{{ date('Y') }}" readonly>
        </div>

        <div class="input-group mb-1" style="width: 370px;">
            <div class="input-group-prepend">
                <label class="input-group-text" style="width: 151px;">Fournisseur</label>
            </div>
            <select class="custom-select" name="fournisseur">
                <option selected>Choisir un fournisseur...</option>
                @foreach($fournisseur as $f)
                <option value="{{ $f->id }}">{{ $f->nomtier }}</option>
                @endforeach
            </select>
        </div>

        <div class="input-group mb-1" style="width: 370px;">
            <div class="input-group-prepend">
                <span class="input-group-text">Échéance Livraison :</span>
            </div>
            <input type="date" class="form-control" name="echeance">
        </div>

        <!-- Div principal pour le client -->
        <div class="col-5" style="float: right; margin-top: -155px; position: relative;">
            <div id="client-section">
                <div class="input-group mb-1" style="width: 370px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 151px;">Modele :</span>
                    </div>
                    <input type="text" id="nomClient" class="form-control" readonly>
                </div>
                <div class="input-group mb-1" style="width: 370px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 151px;">H24</span>
                    </div>
                    <input type="text" id="nomClient" class="form-control" readonly>
                </div>
            </div>

        </div>
    </div>
@endif









                <br>
                <br>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black;">
                Êtes-vous sûr de vouloir supprimer ce client ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de confirmation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="color: black;">
          Êtes-vous sûr de vouloir enregistrer ces modifications ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <button type="button" class="btn btn-primary" id="confirmSave">Confirmer</button>
        </div>
        </div>
    </div>
</div>





<script>
    let clientId = 0;
    let inputToDelete = null;

    function getNextAvailableId() {
        // Trouver le plus grand ID existant parmi les éléments
        const existingIds = Array.from(document.querySelectorAll('.input-group-container'))
                                .map(el => parseInt(el.id.replace('inputGroup', '')))
                                .filter(id => !isNaN(id));
        const maxId = existingIds.length > 0 ? Math.max(...existingIds) : 0;
        return maxId + 1; // Le prochain ID disponible
    }

    function reindexClientIds() {
        // Sélectionner tous les éléments input-group-container
        const inputGroups = document.querySelectorAll('.input-group-container');
        inputGroups.forEach((group, index) => {
            // Mettre à jour les IDs et les labels
            const clientId = index + 1;
            const span = group.querySelector('.input-group-text');
            const input = group.querySelector('input.client-input');
            const hiddenInput = group.querySelector('input.client-hidden-input');
            const suggestionsList = group.querySelector('ul.suggestions-list');
            if (span) {
                span.textContent = `Modele${clientId} :`;
            }
            if (input) {
                input.id = `nomClient${clientId}`;
            }
            if (hiddenInput) {
                hiddenInput.id = `idClient${clientId}`;
                hiddenInput.name = `nomClient${clientId}`; // Mise à jour du name
            }
            if (suggestionsList) {
                suggestionsList.id = `suggestionsListClient${clientId}`;
            }

            // Réajuster le container avec le nouvel ID
            group.id = `inputGroup${clientId}`;
        });
        // Mettre à jour clientId pour le prochain ajout
        clientId = getNextAvailableId() - 1;
    }

    document.getElementById('add-client').addEventListener('click', function() {
        // Calculer le prochain ID disponible
        clientId = getNextAvailableId();

        // Créer un nouveau div similaire au div du client
        const newDiv = document.createElement('div');
        newDiv.className = 'col-5';
        newDiv.style.cssText = 'position: relative;margin-left: -15px;';
        newDiv.id = 'clientDiv' + clientId;

        const newInputGroup = `
            <div class="input-group-container" id="inputGroup${clientId}">
                <div class="input-group mb-1" style="width: 370px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 151px;">Modele :</span>
                    </div>
                    <input type="text" class="form-control client-input" required>
                    <input type="hidden" class="form-control client-hidden-input" name="nomClient${clientId}">
                    <ul class="list-group mt-2 suggestions-list" style="display: none;"></ul>
                </div>
                <button type="button" class="btn btn-danger delete-btn" onclick="confirmDelete(${clientId})" style="position: absolute; right: -250px; top: 3;"><i class="fas fa-trash"></i></button>
            </div>
        `;

        newDiv.innerHTML = newInputGroup;

        // Ajouter le nouveau div juste après le dernier div du client
        document.getElementById('client-section').appendChild(newDiv);
        document.getElementById('totalClients').value = clientId+1 ;
        // Ajouter l'écouteur d'événements pour l'autocomplétion
        attachAutocompleteListeners();
    });

    function confirmDelete(id) {
        inputToDelete = document.getElementById('clientDiv' + id);
        $('#confirmDeleteModal').modal('show');
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (inputToDelete) {
            inputToDelete.remove();
            reindexClientIds();
            $('#confirmDeleteModal').modal('hide');
        }
    });
    function attachAutocompleteListeners() {
        document.querySelectorAll('.client-input').forEach(input => {
            input.addEventListener('input', function () {
                var query = this.value;
                var suggestionsList = this.nextElementSibling.nextElementSibling;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("recherche-client-demande-bc") }}?nomClient=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var clients = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (clients.length > 0) {
                            clients.forEach(function (client) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = client.nom_modele;
                                li.addEventListener('click', function () {
                                    input.value = client.nom_modele;
                                    input.nextElementSibling.value = client.id;
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
        });

        document.addEventListener('click', function (event) {
            if (!event.target.classList.contains('client-input')) {
                document.querySelectorAll('.suggestions-list').forEach(list => {
                    if (!list.contains(event.target)) {
                        list.style.display = 'none';
                    }
                });
            }
        });
    }
    // Attacher les écouteurs d'événements d'autocomplétion lors du chargement initial
    attachAutocompleteListeners();

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nomClient = document.getElementById('nomClient');
        var idClient = document.getElementById('idClient');
        var suggestionsList = document.getElementById('suggestionsListClient');

        nomClient.addEventListener('input', function () {
            var query = nomClient.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route("recherche-client-demande-bc") }}?nomClient=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var clients = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (clients.length > 0) {
                        clients.forEach(function (client) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = client.nom_modele;
                            li.addEventListener('click', function () {
                                nomClient.value = client.nom_modele;
                                idClient.value = client.id;
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
            if (!nomClient.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.getElementById('saveButton').addEventListener('click', function () {
        // Ouvre le modal de confirmation
        $('#confirmationModal').modal('show');
    });

    document.getElementById('confirmSave').addEventListener('click', function () {
        // Masque le div avec la classe 'test'
        document.querySelector('.test').style.display = 'none';

        // Affiche le div avec la classe 'tests'
        document.querySelector('.tests').style.display = 'block';

        // Ferme le modal
        $('#confirmationModal').modal('hide');
    });
</script>


@include('CRM.footer')
