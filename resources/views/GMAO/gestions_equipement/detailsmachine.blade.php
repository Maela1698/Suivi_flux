<style>
    thead th {
        font-weight: bold;
        color: black;
    }
    tbody td {
        color: black;
    }
</style>
{{-- autocompletion --}}
<style>
    #suggestionsListElement {
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
    #suggestionsListPiece {
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
{{-- autocompletion --}}
@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('GMAO.headerGMAO')

        <div class="row">
            @include('GMAO.cin_machine')
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-sm btn-success mt-2" data-bs-toggle="modal" data-bs-target="#affecterMachineModal">
                                <i class="fas fa-plus"></i> Affecter à un secteur
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-sm btn-success mt-2" data-bs-toggle="modal" data-bs-target="#addElementModal">
                                <i class="fas fa-plus"></i> Ajouter un Element
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-sm btn-success mt-2" data-bs-toggle="modal" data-bs-target="#addPieceModal">
                                <i class="fas fa-plus"></i> Affecter une/des Pièce(s)
                            </button>
                        </div>
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4 class="card-title">Les éléments de la machine</h4>
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Id Eléments</th>
                                        <th>Element</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($elements as $e)
                                    <tr>

                                        <td>{{$e->id}}</td>
                                        <td>{{$e->element}}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm fas fa-edit" data-id="{{$e->id}}" data-bs-toggle="modal" data-bs-target="#updateElementModal"></button>

                                            <button type="button" class="btn btn-danger btn-sm fas fa-trash-alt " data-id="{{$e->id}}" data-bs-toggle="modal" data-bs-target="#deleteElementModal"></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <h4 class="card-title">Les pièces de la machine</h4>
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Id Pièces</th>
                                        <th>Id Element</th>
                                        <th>Element</th>
                                        <th>Designation</th>
                                        <th>Reference</th>
                                        <th>Duree de Vie</th>
                                        <th>Nombre</th>
                                        <th>Photo</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pieces as $p)
                                    <tr>
                                        <td>
                                            <span class="badge badge-success">{{$p->id_piece}}</span>
                                        </td>
                                        <td>{{$p->id_element}}</td>
                                        <td><span>{{$p->element}}</span></td>
                                        <td>{{$p->designation}}</td>
                                        <td>{{$p->reference_piece}}</td>
                                        <td>{{$p->dureevie}} h</td>
                                        <td>{{$p->nombre}}</td>
                                        <td>
                                            <div class="round-img">
                                                {{-- <img src="data:image/png;base64;{{ $p->photo }}" style="width: 90px; height: 50px;"/> --}}
                                                <img src="data:image/jpeg;base64;{{ $p->photo }}" style="width: 50px; height: 50px;"/>

                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('GMAO.showupdatepiece', ['idpiece' => $p->id_piece]) }}">
                                                <button type="button" class="btn btn-success btn-sm fas fa-edit mb-1" style="margin-right: 10px"></button>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm fas fa-trash-alt " data-id="{{$p->id_piece}}" data-bs-toggle="modal" data-bs-target="#deletePieceModal"></button>
                                        </td>
                                    </tr>

                                   {{-- <tr>
                                    <td>
                                        <div class="round-img">
                                            <img src="data:image/png;base64,{{ $p->photo }}" alt="Image" style="width: 190px; height: 250px;"/>
                                        </div>
                                    </td>
                                   </tr> --}}

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour ajouter un élément -->
        <div class="modal fade" id="addElementModal" tabindex="-1" aria-labelledby="addelementLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addelementLabel">Ajouter un nouvel élément</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="fa fa-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="elementForm">
                            <div class="mb-3">
                                <label class="col-form-label">Machine</label>
                                <select class="form-control" name="id_machine" required>
                                    @foreach($liste_machine as $machine)
                                        <option value="{{ $machine->id }}">{{ $machine->codemachine }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="element" class="form-label">Nom de l'élément</label>
                                <input type="text" class="form-control" id="element" name="element" required>
                                {{-- <input type="hidden" id="idelement1" class="form-control" name="element1" >
                            <ul id="suggestionsListElement1" class="list-group mt-2" style="display: none;"></ul> --}}
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" id="saveElement">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal pour ajouter un élément -->

        <!-- Modal pour ajouter une ou des pièces -->
        <div class="modal fade" id="addPieceModal" tabindex="-1" aria-labelledby="addelementLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addelementLabel">Affecter une ou des pièces</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="fa fa-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-valide" action="{{route('GMAO.affecterpiece')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="piece-form">
                            @csrf
                            <div class="mb-3">
                                <label class="col-form-label">Machine</label>
                                <select class="form-control" name="id_machine" id="id_machine" required>
                                    {{-- <option value="">Sélectionner une machine</option> --}}
                                    @foreach($liste_machine as $machine)
                                        <option value="{{ $machine->id }}">{{ $machine->codemachine }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="piece" class="form-label">Date d'affectation</label>
                                <input type="date" class="form-control" id="date_affectation" name="date_affectation" required>
                            </div>
                            <div class="mb-3">
                                <label for="element" class="form-label">Élément</label>
                                <input type="text" class="form-control" id="element1" name="element1" required>
                                <input type="hidden" id="idelement1" class="form-control" name="element1" >
                            <ul id="suggestionsListElement" class="list-group mt-2" style="display: none;"></ul>
                            </div>
                            <div class="mb-3">
                                <label for="piece" class="form-label">Pièce</label>
                                <input type="text" class="form-control" id="piece1" name="piece1" required>
                                <input type="hidden" id="idpiece1" class="form-control" name="piece1" >
                                <ul id="suggestionsListPiece" class="list-group mt-2" style="display: none;"></ul>
                            </div>

                            <div class="mb-3">
                                <label for="piece" class="form-label">Commentaire</label>
                                <textarea class="form-control" id="commentaire" name="commentaire"></textarea>
                            </div>
                            <div class="mb-3">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <label class="col-form-label" >Plus </label>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-success" id="addMoreButton">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive" style="overflow: auto" >
                                <table class="table table-bordered d-none" id="pieceTable">
                                    <thead>
                                        <tr>
                                            <th>Element</th>
                                            <th>Designation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            </div>
                            <input type="hidden" id="rowCountInput" name="rowCountInput" value="0">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary" id="savePiece">Enregistrer</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- Mend odal pour ajouter une ou des pièces -->

        {{-- Modal pour confirmation pour retirer la pièce --}}
        <div class="modal fade custom-modal" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="fa fa-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous réellement retirer cette pièce ?
                        <input type="hidden" name="idpiece_hidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                        <button type="button" class="btn btn-primary" id="confirmDeleteButton">Oui</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end Modal pour confirmation --}}

        <!-- Modal pour affecter une machine à un secteur-->
        <div class="modal fade" id="affecterMachineModal" tabindex="-1" aria-labelledby="affecterMachineLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="affecterMachine">Affecter cette machine à un secteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="fa fa-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="affectationSecteurForm" method="POST" action="{{ route('insert-secteur-machine') }}" autocomplete="off">
                            @csrf
                            <div class="mb-4">
                                <label class="col-form-label">Machine</label>
                                <select class="form-control" name="id_machine" required>
                                    @foreach($liste_machine as $machine)
                                        <option value="{{ $machine->id }}">{{ $machine->codemachine }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="secteur" class="form-label">Secteur</label>
                                <input type="text" class="form-control" id="secteur" name="secteur" required>
                                <input type="hidden" id="idsecteur" class="form-control" name="secteur" >
                                <ul id="suggestionsListSecteur" class="list-group mt-2" style="display: none;"></ul>
                            </div>
                            <div class="mb-4">
                                <label for="date_affectation" class="form-label">Date d'affectation</label>
                                <input type="date" class="form-control" id="date_affectation" name="date_affectation">

                            </div>
                            <div class="mb-3">
                                <label for="piece" class="form-label">Commentaire</label>
                                <textarea class="form-control" id="commentaire" name="commentaire"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary" id="saveSecteurMachine">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal pour affecter une machine à un secteur-->

    <!-- Modal pour modifier un élément-->
    <div class="modal fade" id="updateElementModal" tabindex="-1" aria-labelledby="updateElementLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateElement">Modifier cet élément</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateElementForm" method="POST" action="{{ route('element.update') }}" autocomplete="off">
                        @csrf
                        <div class="mb-4">
                            <label for="element" class="form-label">Elément</label>
                            <input type="text" class="form-control" id="element" name="element" required>
                            <input type="hidden" id="idElement" class="form-control" name="idelement" >
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" id="updateElement">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal pour modifier un élément-->

    <!-- Modal pour supprimer élément -->
    <div class="modal fade" id="deleteElementModal" tabindex="-1" aria-labelledby="deleteElementLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteElementLabel">Supprimer élément</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form id="updateElementForm" method="POST" action="{{ route('element.updateStatus') }}" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        Voulez-vous réellement retirer cet élément ?
                        <input type="hidden" name="idElement2" id="idElement2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="deleteElement">Enregistrer</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- END Modal pour supprimer élément -->

    <!-- Modal pour supprimer pièce etat=400 -->
    <div class="modal fade" id="deletePieceModal" tabindex="-1" aria-labelledby="deletePieceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePieceLabel">Supprimer cette pièce</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    Voulez-vous réellement retirer cette pièce ?
                    <input type="hidden" name="id_piece" id="id_piece">
                    <input type="hidden" name="etat" id="etat" value="400">
                    <input type="hidden" name="idmachine" id="idmachine" value="{{$details_machine[0]->id_machine}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="confirmDeletePiece">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal pour supprimer pièce etat=400 -->
    </div>
</div>
@include('GMAO.boutongmao')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



{{-- auto-completion --}}
    {{-- element --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            var element = document.getElementById('element1');
            var idelement = document.getElementById('idelement1');
            var suggestionsList = document.getElementById('suggestionsListElement');

            element.addEventListener('input', function () {
                var query = element.value;
                // console.log("Query entered:", query);


                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("recherche-element-machine") }}?element=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var element_machine = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (element_machine.length > 0) {
                            element_machine.forEach(function (e) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = e.element;
                                li.addEventListener('click', function () {
                                    element.value = e.element;
                                    idelement.value = e.id;
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
                if (!element.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var element = document.getElementById('element1');
            var idelement = document.getElementById('idelement1');
            var suggestionsList = document.getElementById('suggestionsListElement');
            var idMachine = document.getElementById('id_machine'); // Assurez-vous que cet élément existe pour récupérer l'ID de la machine

            element.addEventListener('input', function () {
                var query = element.value;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("recherche-element-machine") }}?element=' + encodeURIComponent(query) + '&id_machine=' + encodeURIComponent(idMachine.value), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var element_machine = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (element_machine.length > 0) {
                            element_machine.forEach(function (e) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = e.element;
                                li.addEventListener('click', function () {
                                    element.value = e.element;
                                    idelement.value = e.id;
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
                if (!element.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>

    {{-- element --}}

    {{-- pièces --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var element = document.getElementById('piece1');
            var idelement = document.getElementById('idpiece1');
            var suggestionsList = document.getElementById('suggestionsListPiece');

            element.addEventListener('input', function () {
                var query = element.value;
                // console.log("Query entered:", query);


                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("recherche-piece-machine") }}?piece=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var piece_machine = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (piece_machine.length > 0) {
                            piece_machine.forEach(function (e) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = e.designation;
                                li.addEventListener('click', function () {
                                    element.value = e.designation;
                                    idelement.value = e.id;
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
                if (!element.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
    {{-- pièces --}}

    {{-- rajout de choses et tout --}}
    <script>
        $(document).ready(function () {
            var rowCount = 0;
            var rowToDelete = null;
            var idpiece;

            $('#addMoreButton').click(function () {
            var idelement = $('#idelement1').val();
            idpiece = $('#idpiece1').val();
            var element = $('#element1').val();
            var piece = $('#piece1').val();

            if (idelement || idpiece) {
                var newRow = '<tr>' +
                            '<td><input class="form-control" type="text" value="' + element + '" name="element1[' + rowCount + ']"><input class="form-control" type="hidden" value="' + idelement + '" name="id_element1[' + rowCount + ']"> </td>' +
                            '<td><input class="form-control" type="text" value="' + piece + '" name="piece1[' + rowCount + ']"> <input class="form-control" type="hidden" value="' + idpiece + '" name="id_piece1[' + rowCount + ']"></td>' +
                            '<td><button type="button" class="btn btn-danger btn-sm delete-row fas fa-trash-alt" data-id="' + idpiece + '"></button></td>' +
                            '</tr>';

                $('#pieceTable tbody').append(newRow);
                $('#pieceTable').removeClass('d-none');

                // Clear input fields
                $('#idelement1').val('');
                $('#idpiece1').val('');

                // Incrémenter rowCount de 1
                rowCount += 1;
                $('#rowCountInput').val(rowCount);
            }
        });


            $(document).on('click', '.delete-row', function () {
                rowToDelete = $(this).closest('tr');
                idpiece = $(this).data('id');
                $('#confirmDeleteModal').modal('show');
                $('#confirmDeleteModal').find('input[name="idpiece_hidden"]').val(idpiece);
            });

            $('#confirmDeleteButton').click(function () {
                var idpiece_tobedeleted = $('#confirmDeleteModal').find('input[name="idpiece_hidden"]').val();

                if (rowToDelete) {
                    rowToDelete.remove();
                    rowToDelete = null;

                    // Réinitialiser les noms des inputs
                    // Réinitialiser les noms des inputs après la suppression
                    $('#pieceTable tbody tr').each(function (index) {
                        $(this).find('input[name^="idelement1"]').attr('name', 'id_element1[' + index + ']');
                        $(this).find('input[name^="idpiece1"]').attr('name', 'id_piece1[' + index + ']');
                    });


                    // Mettre à jour rowCount
                    rowCount -= 1;
                    $('#rowCountInput').val(rowCount);

                    if ($('#pieceTable tbody tr').length === 0) {
                        $('#pieceTable').addClass('d-none');
                    }
                }
                $('#confirmDeleteModal').modal('hide');
            });
        });
    </script>
    {{-- rajout de choses et tout --}}



    {{-- secteur auto-completion --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const secteur = document.getElementById('secteur');
            const idsecteur = document.getElementById('idsecteur');
            const suggestionsList = document.getElementById('suggestionsListSecteur');

            secteur.addEventListener('input', function () {
                const query = secteur.value.trim();

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                const xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("recherche-secteur-machine") }}?secteur=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const loca = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';

                        if (loca.length > 0) {
                            loca.forEach(function (lc) {
                                const li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = lc.secteur;
                                li.style.cursor = 'pointer';
                                li.addEventListener('click', function () {
                                    secteur.value = lc.secteur;
                                    idsecteur.value = lc.id;
                                    suggestionsList.style.display = 'none';
                                });
                                suggestionsList.appendChild(li);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    } else {
                        console.error("Erreur lors de la récupération des secteurs");
                    }
                };
                xhr.onerror = function () {
                    console.error("Erreur lors de la requête AJAX");
                };
                xhr.send();
            });

            document.addEventListener('click', function (event) {
                if (!secteur.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
    {{-- secteur auto-completion --}}

{{-- end  auto-completion --}}


{{-- ajout element --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const saveElementButton = document.getElementById('saveElement');

            saveElementButton.addEventListener('click', function () {
                const elementForm = document.getElementById('elementForm');
                const formData = new FormData(elementForm);

                const machine = formData.get('id_machine');
                const elementName = formData.get('element');

                // Valider les données avant de continuer
                if (!machine || !elementName) {
                    alert('Veuillez remplir tous les champs requis.');
                    return;
                }

                fetch('{{route('GMAO.createelement')}}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const addElementModal = new bootstrap.Modal(document.getElementById('addElementModal'));
                        addElementModal.hide();

                        elementForm.reset();

                        alert('Élément ajouté avec succès.');
                    } else {
                        alert('Erreur lors de l\'ajout de l\'élément.');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de l\'ajout de l\'élément.');
                });
            });
        });
    </script>
{{-- ajout element --}}

{{-- form submit à un element--}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const saveElementButton = document.getElementById('saveElement');

        saveElementButton.addEventListener('click', function () {
            const elementForm = document.getElementById('elementForm');
            const formData = new FormData(elementForm);

            const machine = formData.get('id_machine');
            const elementName = formData.get('element');

            // Valider les données avant de continuer
            if (!machine || !elementName) {
                alert('Veuillez remplir tous les champs requis.');
                return;
            }

            fetch('{{route('GMAO.createelement')}}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const addElementModal = new bootstrap.Modal(document.getElementById('addElementModal'));
                    addElementModal.hide();

                    elementForm.reset();

                    alert('Élément ajouté avec succès.');
                } else {
                    alert('Erreur lors de l\'ajout de l\'élément.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'ajout de l\'élément.');
            });
        });
    });
</script>
{{-- end submit à un element --}}

{{-- formulaire submit affectation à un secteur--}}
{{-- <script>
    $(document).ready(function () {
        $('#saveSecteurMachine').click(function () {
            let formData = {
                idsecteur: $('#idsecteur').val(),
                id_machine: $('select[name="id_machine"]').val(),
                date_affectation: $('#date_affectation').val(),
                commentaire: $('#commentaire').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '{{ route('insert-secteur-machine') }}',
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        alert('Affectation ajoutée avec succès');
                        $('#affecterMachineModal').modal('hide');
                    } else {
                        alert('Erreur: ' + response.message);
                    }
                },
                error: function (xhr) {
                    alert('Erreur lors de la requête AJAX: ' + xhr.responseText);
                }
            });
        });
    });
</script> --}}

{{-- envoie id element à modifier élément --}}
<script>
        document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-success[data-bs-target="#updateElementModal"]');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const elementId = button.getAttribute('data-id');

                document.getElementById('idElement').value = elementId;
            });
        });
    });
</script>
{{-- end envoie id element à modifier un élément --}}

{{-- envoie id element à supprimer élément --}}
<script>
        document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-danger[data-bs-target="#deleteElementModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const elementId = button.getAttribute('data-id');
                document.getElementById('idElement2').value = elementId;
            });
        });
    });
</script>
{{-- end envoie id element à supprimer un élément --}}

{{-- envoie id_piece à supprimer une piece --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-danger[data-bs-target="#deletePieceModal"]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const pieceid = button.getAttribute('data-id');
                console.log("Piece ID récupéré:", pieceid);  // Vérifier l'ID
                document.getElementById('id_piece').value = pieceid;
            });
        });

        document.getElementById('confirmDeletePiece').addEventListener('click', function() {
            const id_piece = document.getElementById('id_piece').value;
            const etat = document.getElementById('etat').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            console.log("ID de la pièce envoyé:", id_piece);
            console.log("État envoyé:", etat);
            console.log("Token CSRF:", token);

            fetch('/update-etat-piece2', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ id_piece, etat, idmachine: document.getElementById('idmachine').value })  // Inclure idmachine
            })
            .then(response => response.json())
            .then(data => {
                console.log("Réponse de la requête:", data);
                if (data.success) {
                    alert('La pièce a été supprimée avec succès.');
                    // Redirection vers la page detailsmachine avec l'id_machine
                    window.location.href = `/GMAO/detailsmachine/${data.id_machine}`;
                } else {
                    alert('Erreur : ' + data.message);
                }
            })
            .catch(error => {
                console.error("Erreur AJAX:", error);
                alert('Erreur lors de la requête AJAX : ' + error);
            });

        });
    });
</script>
{{-- end envoie id_piece à supprimer une piece --}}

{{-- en for --}}
@include('CRM.footer')
